<?php

namespace App\Providers;

use App\Admin;
use App\Order;
use App\Policies\AdminPolicy;
use App\Policies\OrderPolicy;
use App\Policies\SettingPolicy;
use App\Policies\TokenPolicy;
use App\Policies\UserPolicy;
use App\Policies\UserSettingPolicy;
use App\Setting;
use App\Token;
use App\User;
use App\UserSetting;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		User::class        => UserPolicy::class,
		Order::class       => OrderPolicy::class,
		Setting::class     => SettingPolicy::class,
		UserSetting::class => UserSettingPolicy::class,
		Token::class       => TokenPolicy::class,
		Admin::class       => AdminPolicy::class,
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();
	}
}
