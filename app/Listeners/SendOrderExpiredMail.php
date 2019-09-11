<?php

namespace App\Listeners;

use App\Events\OrderExpired;
use App\Mail\OrderExpiredMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
	 * @param OrderExpired $event
	 *
	 * @return void
	 */
    public function handle(OrderExpired $event)
    {
		$user = $event->user;

		if ($user->email)
			Mail::to($user->email)->send(new OrderExpiredMail());
    }
}
