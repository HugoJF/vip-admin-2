<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Services\OrderService;

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
        if ($order->auto_activates) {
            /** @var OrderService $service */
            $service = app(OrderService::class);

            $service->activateOrder($order);
        }
    }
}
