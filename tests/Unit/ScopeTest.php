<?php

namespace Tests\Unit;

use App\Order;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ScopeTest extends TestCase
{
	use DatabaseTransactions;

	public function test_active_scope_is_working()
	{
		$order = factory(Order::class)->create([
			'starts_at'  => now(),
			'ends_at'    => now()->addDay(),
			'paid'       => true,
			'canceled'   => false,
			'created_at' => now(),
			'synced_at'  => now(),
		]);

		$that = Order::active()->where('id', $order->id)->first();

		$this->assertNotNull($that);
	}
}
