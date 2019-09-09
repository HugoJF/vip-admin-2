<?php

namespace App\Listeners;

use App\Events\NewAffiliateToken;
use App\Events\OrderPaid;
use App\Token;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateAffiliateToken
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

		$client = $order->user;

		$affiliate = $client->referrer;

		if ($affiliate) {
			$token = Token::make();

			$token->id = substr(md5(microtime(true)), 0, 20);
			$token->duration = 7;
			$token->note = "Token de afiliado gerado pelo pedido $order->id";
			$token->user()->associate($affiliate);

			$token->save();

			event(new NewAffiliateToken($token));
		}
	}
}
