<?php

namespace App\Providers;

use App\Events\ManualServerSynchronization;
use App\Events\NewAffiliateToken;
use App\Events\OrderActivated;
use App\Events\OrderCreated;
use App\Events\OrderExpired;
use App\Events\VipExpired;
use App\Events\OrderPaid;
use App\Events\OrderSynchronized;
use App\Listeners\GeneratePaidOrderAffiliateToken;
use App\Listeners\GenerateOrderActivation;
use App\Listeners\GenerateUserRegisterAffiliateToken;
use App\Listeners\SendNewAffiliateTokenMail;
use App\Listeners\SendOrderActivatedMail;
use App\Listeners\SendOrderCreatedMail;
use App\Listeners\SendOrderExpiredMail;
use App\Listeners\SendOrderPaidMail;
use App\Listeners\SynchronizeServer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		Registered::class                  => [
			// SendEmailVerificationNotification::class,
			GenerateUserRegisterAffiliateToken::class,
		],
		OrderCreated::class                => [
			SendOrderCreatedMail::class,
		],
		OrderPaid::class                   => [
			GenerateOrderActivation::class,
			GeneratePaidOrderAffiliateToken::class,
			SendOrderPaidMail::class,
		],
		OrderActivated::class              => [
			SynchronizeServer::class,
			SendOrderActivatedMail::class,
		],
		OrderSynchronized::class           => [
			//
		],
		OrderExpired::class                => [
			//
		],
		VipExpired::class                  => [
			SendOrderExpiredMail::class,
		],
		NewAffiliateToken::class           => [
			SendNewAffiliateTokenMail::class,
		],
		ManualServerSynchronization::class => [
			SynchronizeServer::class,
		],
	];

	/**
	 * Register any events for your application.
	 *
	 * @return void
	 */
	public function boot()
	{
		parent::boot();
	}
}
