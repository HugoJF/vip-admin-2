<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Mail\OrderPaid as OrderPaidMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderPaidMail
{
	/**
	 * Handle the event.
	 *
	 * @param  OrderPaid $event
	 *
	 * @return void
	 */
	public function handle(OrderPaid $event)
	{
		$order = $event->order;
		$user = $order->user;

		if ($user->email)
			Mail::to($user->email)->send(new OrderPaidMail($order));
	}
}
