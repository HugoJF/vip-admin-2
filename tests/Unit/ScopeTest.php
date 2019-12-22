<?php

namespace Tests\Unit;

use App\Order;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScopeTest extends TestCase
{
	use DatabaseTransactions;

	public function test_active_scope_is_working()
	{
		$order = factory(Order::class)->create([
			'starts_at'  => now()->addSecond(),
			'ends_at'    => now()->addDay(),
			'paid'       => true,
			'canceled'   => false,
			'created_at' => now()->addSecond(),
			'synced_at'  => now()->addSecond(),
		]);

		$that = Order::active()->where('id', $order->id)->first();

		$this->assertNotNull($that);
	}
}
