<?php

namespace App\Providers;

use App\Events\ManualServerSynchronization;
use App\Events\OrderActivated;
use App\Events\OrderCreated;
use App\Events\OrderExpired;
use App\Events\OrderPaid;
use App\Listeners\GenerateAffiliateToken;
use App\Listeners\GenerateOrderActivation;
use App\Listeners\SendOrderActivatedMail;
use App\Listeners\SendOrderCreatedMail;
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
			SendEmailVerificationNotification::class,
		],
		OrderCreated::class                => [
			SendOrderCreatedMail::class,
		],
		OrderPaid::class                   => [
			GenerateOrderActivation::class,
			GenerateAffiliateToken::class,
			SendOrderPaidMail::class,
		],
		OrderActivated::class              => [
			SynchronizeServer::class,
			SendOrderActivatedMail::class,
		],
		OrderExpired::class                => [
			SynchronizeServer::class,
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
