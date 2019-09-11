<?php

namespace App\Listeners;

use App\Events\NewAffiliateToken;
use App\Token;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateUserRegisterAffiliateToken
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
	 * @param  Registered $event
	 *
	 * @return void
	 */
	public function handle(Registered $event)
	{
		$client = $event->user;

		$affiliate = $client->referrer;

		if ($affiliate) {
			$token = Token::make();

			$token->id = random_id(5);
			$token->duration = 7;
			$token->note = "Token de afiliado gerado pelo registro de $client->username";
			$token->user()->associate($affiliate);
			$token->reason()->associate($client);

			$token->save();

			event(new NewAffiliateToken($token));
		}
	}
}
