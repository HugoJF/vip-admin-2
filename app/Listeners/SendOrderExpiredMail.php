<?php

namespace App\Listeners;

use App\Events\VipExpired;
use App\Mail\OrderExpiredMail;
use Illuminate\Support\Facades\Mail;

class SendOrderExpiredMail
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
	 * @param VipExpired $event
	 *
	 * @return void
	 */
	public function handle(VipExpired $event)
	{
		$order = $event->order;
		$user = $order->user;

		if ($user->email)
			Mail::to($user->email)->send(new OrderExpiredMail());
	}
}
