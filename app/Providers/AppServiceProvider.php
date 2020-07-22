<?php

namespace App\Providers;

use App\Observers\OrderObserver;
use App\Order;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
	    //
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Schema::defaultStringLength(191);

		$this->registerBladeDirectives();
		$this->registerCustomValidators();
		$this->setupObservers();
	}

	protected function setupObservers(): void
	{
		Order::observe(OrderObserver::class);
	}

	protected function registerCustomValidators()
	{
		// Validates SourceMod flags
		Validator::extend('sm_flag', function ($attribute, $value, $parameters, $validator) {
			return preg_match('/[a-tz]+/', $value);
		});

		// Validates any type of Steam ID
		Validator::extend('steamid', function ($attribute, $value, $parameters, $validator) {
			try {
				new \SteamID($value);

				return true;
			} catch (\InvalidArgumentException $e) {
				return false;
			}
		});
	}

	protected function registerBladeDirectives()
	{
		Blade::if ('admin', function () {
			return auth()->check() && auth()->user()->admin === true;
		});

		Blade::if ('affiliate', function () {
			return auth()->check() && auth()->user()->affiliate === true;
		});
	}
}
