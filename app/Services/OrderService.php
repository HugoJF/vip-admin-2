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
use App\Exceptions\InvalidSteamIdException;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Log;

class OrderService
{
	public function createOrder($user, $data, Product $product)
	{
		$paymentSystem = app(PaymentSystem::class);

		$order = $this->createEmptyOrder($user, $product->duration);
		$details = $this->buildOrderDetails($order, $user, $product);

		$response = $paymentSystem->createOrder($details);

		if ($response->status !== 201) {
			dd($response);
			Log::error('Invalid PaymentSystem response', compact('response'));
			throw new \Exception('Invalid PaymentSystem response');
		}

		$response = $response->content;

		$order->auto_activates = $data['auto-activates'] === 'true' ?? false;
		$order->reference = $response->id;
		$order->init_point = $response->init_point;

		$order->save();

		return [$order, $response];
	}

	public function createEmptyOrder(User $user, $duration)
	{
		$order = Order::make();

		$order->duration = $duration;
		$order->user()->associate($user);

		$order->save();

		return $order;
	}

	public function buildOrderDetails(Order $order, User $user, Product $product)
	{
		$details['reason'] = "VIP de $product->duration dias nos servidores de_nerdTV";
		$details['return_url'] = url("/orders/{$order->id}");
		$details['cancel_url'] = url("/orders/{$order->id}");
		$details['preset_amount'] = round($product->cost * (1 - $product->discount));
		$details['reason'] = 'VIP servidores de_nerdTV';
		$details['product_name_singular'] = 'dia';
		$details['product_name_plural'] = 'dias';

		$details['avatar'] = $user->avatar;
		$details['payer_steam_id'] = $user->steamid;
		$details['payer_tradelink'] = $user->tradelink;

		// TODO: update this
		$details['unit_price'] = 8;
		$details['unit_price_limit'] = 6;
		$details['discount_per_unit'] = 0.1;
		$details['min_units'] = 14;
		$details['max_units'] = 90;

		return $details;
	}

	public function updateOrder(Order $order, array $values)
	{
		// TODO: improve with validator?
		$order->fill($values + ['paid' => false, 'canceled' => false]);

		$order->save();

		return $order;
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

	/**
	 * @param Order $order
	 * @param       $steamid
	 *
	 * @return void
	 * @throws InvalidSteamIdException
	 */
	public function transferOrder(Order $order, $steamid)
	{
		try {
			$steamid = new \SteamID($steamid);
		} catch (\InvalidArgumentException $e) {
			throw new InvalidSteamIdException($steamid);
		}

		$order->steamid = $steamid->ConvertToUInt64();
		$order->save();
	}

	public function returnOrder(Order $order)
	{
		$order->steamid = null;
		$order->save();
	}
}