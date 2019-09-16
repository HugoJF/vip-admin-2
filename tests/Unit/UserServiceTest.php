<?php

namespace Tests\Unit;

use App\Order;
use App\Services\UserService;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
	public function testToggleAdmin()
	{
		/** @var UserService $service */
		$service = app(UserService::class);

		$user = factory(User::class)->create(['admin' => true]);

		$this->assertDatabaseHas('users', ['id' => $user->id, 'admin' => true]);
		$service->toggleAdmin($user);
		$this->assertDatabaseHas('users', ['id' => $user->id, 'admin' => false]);
	}

	public function testGetOrderBasePoint()
	{
		/** @var UserService $service */
		$service = app(UserService::class);

		// Testing with user with no orders
		$user = factory(User::class)->create();

		$base = $service->getOrderBasePoint($user);

		$this->assertLessThan(5, Carbon::now()->diffInMinutes($base, true));

		// Testing with user with an order expiring in 30 days
		$endsAt = Carbon::now()->addDays(30);
		$order = factory(Order::class)->create([
			'canceled' => false,
			'ends_at' => $endsAt,
		]);

		$order->user()->associate($user);
		$order->save();

		$base = $service->getOrderBasePoint($user);
		$this->assertLessThan(5, $endsAt->diffInMinutes($base, true));

	}
}
