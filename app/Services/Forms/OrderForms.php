<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:19 AM
 */

namespace App\Services\Forms;

use App\Forms\OrderForm;
use App\Order;
use App\OrderTransferForm;

class OrderForms extends ServiceForms
{
	public function gift(Order $order)
	{
		return $this->builder->create(OrderTransferForm::class, [
			'method' => 'PATCH',
			'url'    => route('orders.transfer', $order),
			'model'  => $order,
		]);
	}

	public function edit(Order $order)
	{
		return $this->builder->create(OrderForm::class, [
			'method' => 'PATCH',
			'url'    => route('orders.update', $order),
			'model'  => $order,
		]);
	}
}