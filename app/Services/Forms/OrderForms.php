<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:19 AM
 */

namespace App\Services\Forms;

use App\Forms\OrderForm;

class OrderForms extends ServiceForms
{
	public function edit($order)
	{
		return $this->builder->create(OrderForm::class, [
			'method' => 'PATCH',
			'url'    => route('orders.update', $order),
			'model'  => $order,
		]);
	}
}