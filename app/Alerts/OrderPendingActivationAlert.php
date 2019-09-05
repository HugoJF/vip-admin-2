<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Alerts;

class OrderPendingActivationAlert extends Alert
{
	private $pendingOrders;

	public function triggered()
	{
		$this->pendingOrders = $this->user->orders()->wherePaid(true)->whereNull('starts_at')->count();

		return $this->pendingOrders > 0;
	}

	public function getMessage()
	{
		$s = $this->pendingOrders === 1 ? '' : 's';

		return "Você tem $this->pendingOrders pedido$s pendente$s!";
	}

	public function getLevel()
	{
		return 'danger';
	}

	public function getUrl()
	{
		return route('orders.index');
	}
}