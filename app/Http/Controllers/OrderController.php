<?php

namespace App\Http\Controllers;

use App\Classes\PaymentSystem;
use App\Exceptions\InvalidDurationException;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
	private $paymentSystem;

	public function __construct()
	{
		$this->paymentSystem = new PaymentSystem();
	}

	public function index()
	{
		$user = Auth::user();

		if ($user->admin) {
			$query = Order::with(['user']);
		} else {
			$query = $user->orders()->with(['user']);
		}

		return $query->latest()->get();
	}

	/**
	 * @param Request $request
	 *
	 * @return bool|mixed
	 * @throws InvalidDurationException
	 */
	public function store(Request $request)
	{
		$durations = [14 => 500, 30 => 800, 60 => 1600];

		$duration = intval($request->input('duration'));

		if (!array_key_exists($duration, $durations))
			throw new InvalidDurationException("{$duration} days is not a valid duration");

		$user = Auth::user();
		$order = Order::make();

		$order->duration = $duration;
		$order->user()->associate($user);

		$order->save();

		$details['reason'] = "VIP de ${duration} dias nos servidores de_nerdTV";
		$details['return_url'] = url("/orders/{$order->id}");
		$details['cancel_url'] = url("/orders/{$order->id}");
		$details['preset_amount'] = $durations[ $duration ];
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

		$res = $this->paymentSystem->createOrder($details);

		$order->reference = $res->id;
		$order->save();

		return $order;
	}

	public function activate(Order $order)
	{
		if (isset($order->starts_at))
			throw new \Exception('Order is already activated');

		if (!$order->paid)
			throw new \Exception('Order is not paid');

		$order->starts_at = Carbon::now();
		$order->ends_at = Carbon::now()->addDays($order->duration);

		$order->save();

		return $order;
	}

	public function show(Order $order)
	{
		$order->recheck();

		$order->save();

		return $order;
	}

	public function update(Request $request, Order $order)
	{
		$order->fill($request->all());

		$order->save();

		return $order;
	}
}
