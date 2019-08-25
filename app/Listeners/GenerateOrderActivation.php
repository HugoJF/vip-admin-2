<?php

namespace App\Listeners;

use App\Events\OrderActivated;
use App\Events\OrderPaid;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateOrderActivation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

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
    		$order->activate();
    		$order->save();

    		event(new OrderActivated($order));
		}
    }
}
