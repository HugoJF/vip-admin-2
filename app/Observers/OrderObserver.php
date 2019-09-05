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
		$order->id = $this->randomString(5);
	}

	protected function randomString($length)
	{
		return substr(md5(microtime(true)), 0, $length);
	}
}
