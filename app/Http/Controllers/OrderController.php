<?php

namespace App\Http\Controllers;

use App\Classes\PaymentSystem;
use App\Events\OrderActivated;
use App\Exceptions\InvalidDurationException;
use App\Exceptions\OrderAlreadyActivated;
use App\Exceptions\OrderCanceled;
use App\Exceptions\OrderNotPaidException;
use App\Forms\OrderForm;
use App\Order;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\FormBuilder;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

		$orders = $query->latest()->get();

		return view('orders.index', compact('orders'));
	}

	public function create(OrderService $service, $duration)
	{
		if (!$service->validateDuration($duration)) {
			flash()->error('Duração do pedido inválida!');

			return back();
		}

		return view('orders.create', compact('duration'));
	}

	public function store(OrderService $service, Request $request, $duration)
	{
		if (!$service->validateDuration($duration)) {
			flash()->error('Duração do pedido inválida!');

			return back();
		}

		$info = config('vip-admin.durations');

		$user = Auth::user();
		$order = Order::make();

		$order->duration = $duration;
		$order->user()->associate($user);

		$order->save();

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

		$res = $this->paymentSystem->createOrder($details);
		if($res->status !== 201) {
			// TODO: figure a better exception
			dd($res);
		}
		$res = $res->content;
		$order->reference = $res->id;
		$order->save();

		return redirect($res->init_point);
	}

	public function edit(FormBuilder $builder, Order $order)
	{
		$form = $builder->create(OrderForm::class, [
			'method' => 'PATCH',
			'url'    => route('orders.update', $order),
			'model'  => $order,
		]);

		return view('form', [
			'title'       => 'Updating order',
			'form'        => $form,
			'submit_text' => 'Update',
		]);
	}

	/**
	 * @param Order $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws OrderAlreadyActivated
	 * @throws OrderCanceled
	 * @throws OrderNotPaidException
	 */
	public function activate(Order $order)
	{
		if ($order->canceled)
			throw new OrderCanceled();

		if ($order->activated)
			throw new OrderAlreadyActivated();

		if (!$order->paid)
			throw new OrderNotPaidException();

		$user = $order->user;

		$lastOrder = $user->orders()->where('canceled', false)->whereNotNull('ends_at')->orderBy('ends_at', 'DESC')->first();

		$basePoint = $lastOrder->ends_at;

		$order->starts_at = $basePoint;
		$order->ends_at = $basePoint->addDays($order->duration);

		$order->save();

		event(new OrderActivated($order));

		flash()->success('Pedido ativado com sucesso!');

		//TODO: update to show
		return redirect()->route('orders.index');
	}

	public function show(Order $order)
	{
		$order->recheck();

		$order->save();

		return redirect()->route('orders.index');
	}

	public function update(Request $request, Order $order)
	{
		// TODO: improve with validator?
		$order->fill($request->all() + ['paid' => false, 'canceled' => false]);

		$order->save();

		flash()->success('Order was updated!');

		return redirect()->route('orders.index');
	}
}
