<?php

namespace Tests\Unit;

use App\Order;
use App\Services\OrderService;
use App\User;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
	// TODO: buildOrderDetails
	// TODO: createOrder
	public function testCreateEmptyOrderAndUpdateOrder()
	{
		/** @var OrderService $service */
		$service = app(OrderService::class);
		$user = factory(User::class)->create();

		$order = $service->createEmptyOrder($user, 30);

		$this->assertInstanceOf(Order::class, $order);
		$this->assertDatabaseHas('orders', [
			'id'       => $order->id,
			'duration' => 30,
		]);

		$order = $service->updateOrder($order, [
			'duration' => 60,
			'paid'     => true,
		]);

		$this->assertInstanceOf(Order::class, $order);
		$this->assertDatabaseHas('orders', [
			'id'       => $order->id,
			'duration' => 60,
		]);
	}
}
