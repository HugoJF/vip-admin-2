<?php

namespace App\Listeners;

use App\Events\OrderActivated;
use App\Events\OrderPaid;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateOrderActivation
{
	/**
	 * Handle the event.
	 *
	 * @param OrderPaid $event
	 *
	 * @return void
	 */
    public function handle(OrderPaid $event)
    {
    	$order = $event->order;

    	// Only active order is auto-activation is enabled
    	if($order->auto_activates) {
    		/** @var OrderService $service */
    		$service = app(OrderService::class);

    		$service->activateOrder($order);
		}
    }
}
