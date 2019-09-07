<?php

namespace App\Http\Controllers;

use App\Classes\PaymentSystem;
use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderDurationException;
use App\Exceptions\OrderAlreadyActivated;
use App\Exceptions\OrderCanceled;
use App\Exceptions\OrderNotPaidException;
use App\Order;
use App\Services\Forms\OrderForms;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
	public function index()
	{
		$user = Auth::user();

		$query = $user->admin ? Order::query() : $user->orders();

		$orders = $query->with(['user'])->latest()->get();

		return view('orders.index', compact('orders'));
	}

	/**
	 * @param OrderService $service
	 * @param              $duration
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws InvalidOrderDurationException
	 */
	public function create(OrderService $service, $duration)
	{
		if (!$service->validateDuration($duration))
			throw new InvalidOrderDurationException();

		return view('orders.create', compact('duration'));
	}

	/**
	 * @param OrderService $service
	 * @param Request      $request
	 * @param              $duration
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws InvalidOrderDurationException
	 */
	public function store(OrderService $service, Request $request, $duration)
	{
		if (!$service->validateDuration($duration))
			throw new InvalidOrderDurationException();

		$user = Auth::user();

		list($order, $response) = $service->createOrder($user, $request->only('auto-activate'), $duration);

		event(new OrderCreated($order));

		return redirect($response->init_point);
	}

	public function edit(OrderForms $forms, Order $order)
	{
		$form = $forms->edit($order);

		return view('form', [
			'title'       => 'Updating order',
			'form'        => $form,
			'submit_text' => 'Update',
		]);
	}

	/**
	 * @param OrderService $service
	 * @param Order        $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws OrderAlreadyActivated
	 * @throws OrderCanceled
	 * @throws OrderNotPaidException
	 */
	public function activate(OrderService $service, Order $order)
	{
		if ($order->canceled)
			throw new OrderCanceled();

		if ($order->activated)
			throw new OrderAlreadyActivated();

		if (!$order->paid)
			throw new OrderNotPaidException();

		$service->activateOrder($order);

		flash()->success('Pedido ativado com sucesso!');

		return redirect()->route('orders.show', $order);
	}

	public function show(Order $order)
	{
		$order->recheck();

		$order->save();

		return view('orders.show', compact('order'));
	}

	public function update(OrderService $service, Request $request, Order $order)
	{
		$service->updateOrder($order, $request->all());

		flash()->success('Order was updated!');

		return redirect()->route('orders.index');
	}
}
