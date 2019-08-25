<?php

namespace App\Providers;

use App\Events\OrderActivated;
use App\Events\OrderPaid;
use App\Listeners\GenerateOrderActivation;
use App\Listeners\SynchronizeServer;
use Illuminate\Support\Facades\Event;
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
		Registered::class     => [
			SendEmailVerificationNotification::class,
		],
		OrderPaid::class      => [
			GenerateOrderActivation::class,
		],
		OrderActivated::class => [
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
