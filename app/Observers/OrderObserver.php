<?php

namespace App\Observers;

use App\Order;

class OrderObserver
{
	/**
	 * Handle the app order "created" event.
	 *
	 * @param  \App\Order $order
	 *
	 * @return void
	 */
	public function retrieved(Order $order)
	{
		if (!$order->paid)
			$order->recheck();
	}

	public function creating(Order $order)
	{
		if ($order->id)
			return;
		$found = false;
		$id = null;

		while (!$found) {
			$id = random_id(5);

			$check = Order::find($id);

			if (!$check)
				$found = true;
		}

		$order->id = $id;
	}
}
