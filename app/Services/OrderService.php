<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/25/2019
 * Time: 9:46 AM
 */

namespace App\Services;

use App\Classes\PaymentSystem;
use App\Events\OrderActivated;
use App\Order;
use App\User;

class OrderService
{
	public function updateOrder(Order $order, array $values)
	{
		// TODO: improve with validator?
		$order->fill($values + ['paid' => false, 'canceled' => false]);

		$order->save();
	}

	public function validateDuration($duration)
	{
		return array_key_exists($duration, config('vip-admin.durations'));
	}

	public function createOrder($user, $duration)
	{
		$paymentSystem = app(PaymentSystem::class);

		$order = $this->createEmptyOrder($user, $duration);
		$details = $this->buildOrderDetails($order, $user, $duration);

		$response = $paymentSystem->createOrder($details);

		if ($response->status !== 201)
			dd($response); // TODO: improve

		$response = $response->content;
		$order->reference = $response->id;
		$order->save();

		return $response;
	}

	public function createEmptyOrder(User $user, $duration)
	{
		$order = Order::make();

		$order->duration = $duration;
		$order->user()->associate($user);

		$order->save();

		return $order;
	}

	public function buildOrderDetails(Order $order, User $user, $duration)
	{
		$info = config('vip-admin.durations');

		$details['reason'] = "VIP de ${duration} dias nos servidores de_nerdTV";
		$details['return_url'] = url("/orders/{$order->id}");
		$details['cancel_url'] = url("/orders/{$order->id}");
		$details['preset_amount'] = $info[ $duration ]['price'];
		$details['reason'] = 'VIP servidores de_nerdTV';
		$details['product_name_singular'] = 'dia';
		$details['product_name_plural'] = 'dias';

		$details['avatar'] = $user->avatar;
		$details['payer_steam_id'] = $user->steamid;
		$details['payer_tradelink'] = $user->tradelink;

		$details['unit_price'] = 8;
		$details['unit_price_limit'] = 6;
		$details['discount_per_unit'] = 0.1;
		$details['min_units'] = 14;
		$details['max_units'] = 90;

		return $details;
	}

	public function activateOrder(Order $order)
	{
		$service = app(UserService::class);

		$basePoint = $service->getOrderBasePoint($order->user);

		$order->starts_at = $basePoint;
		$order->ends_at = $basePoint->addDays($order->duration);

		$order->save();

		event(new OrderActivated($order));

		return $order;
	}
}