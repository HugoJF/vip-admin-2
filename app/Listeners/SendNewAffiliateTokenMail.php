<?php

namespace App\Listeners;

use App\Events\NewAffiliateToken;
use App\Mail\NewAffiliateTokenMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewAffiliateTokenMail
{
	/**
	 * Handle the event.
	 *
	 * @param NewAffiliateToken $event
	 *
	 * @return void
	 */
    public function handle(NewAffiliateToken $event)
    {
		$order = $event->token;
		$user = $order->user;

		if ($user->email)
			Mail::to($user->email)->send(new NewAffiliateTokenMail($order));
    }
}
