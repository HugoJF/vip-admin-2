<?php

namespace App\Jobs;

use App\Order;
use App\Services\OrderRecheckService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RecheckPendingOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $waitingPeriods;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->waitingPeriods = config('payment-system.rechecking-periods');
    }

    /**
     * Execute the job.
     *
     * @param OrderRecheckService $service
     *
     * @return void
     */
    public function handle(OrderRecheckService $service)
    {
        $pendingOrders = Order::wherePaid(false)->valid()->get();

        info("Found {$pendingOrders->count()} pending orders...");

        foreach ($pendingOrders as $order) {
            // Check if order is old enough to be rechecked
            if ($this->shouldRecheck($order)) {
                info("Rechecking order {$order->id}");
                $service->handle($order);
            }

            // Log if state changed
            if ($order->paid) {
                info("Order $order->id was detected as paid.");
            }
        }
    }

    protected function shouldRecheck(Order $order)
    {
        // How many recheck attempts this order has
        $attempts = $order->recheck_attempts;

        // What index should we check for time diff
        $index = $this->clamp($attempts, 0, count($this->waitingPeriods) - 1);

        // The wait time for this order
        $time = $this->waitingPeriods[ $index ];
        $delta = $order->updated_at->diffInSeconds();

        info("Order $order->id has a delta of $delta seconds and needs $time seconds");

        return $delta > $time;
    }

    protected function clamp($value, $min, $max)
    {
        return max(min($max, $value), $min);
    }
}
