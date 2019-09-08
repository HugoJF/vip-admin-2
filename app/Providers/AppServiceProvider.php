<?php

namespace App\Providers;

use App\Observers\OrderObserver;
use App\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
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
		$this->setupObservers();
	}

	protected function setupObservers(): void
	{
		Order::observe(OrderObserver::class);
	}

	protected function registerBladeDirectives()
	{
		Blade::if('admin', function () {
			return auth()->check() && auth()->user()->admin === true;
		});
	}
}
