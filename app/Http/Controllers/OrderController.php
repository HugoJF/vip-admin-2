<?php

namespace App\Http\Controllers;

use App\Classes\PaymentSystem;
use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderDurationException;
use App\Exceptions\OrderAlreadyActivatedException;
use App\Exceptions\OrderCanceledException;
use App\Exceptions\OrderNotPaidException;
use App\Http\Requests\OrderStoreRequest;
use App\Order;
use App\Product;
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

		$orders = $query->with(['user'])->latest()->paginate(50);

		return view('orders.index', compact('orders'));
	}

	/**
	 * @param Product $product
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create(Product $product)
	{
		return view('orders.create', compact('product'));
	}

	/**
	 * @param OrderService      $service
	 * @param OrderStoreRequest $request
	 * @param Product           $product
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(OrderService $service, OrderStoreRequest $request, Product $product)
	{
		$user = Auth::user();

		list($order, $response) = $service->createOrder($user, $request->validated(), $product);

		event(new OrderCreated($order));

		return redirect($response->init_point);
	}

	public function edit(OrderForms $forms, Order $order)
	{
		$form = $forms->edit($order);

		return view('form', [
			'title'       => 'Atualizando pedido',
			'form'        => $form,
			'submit_text' => 'Atualizar',
		]);
	}

	public function gift(OrderForms $forms, Order $order)
	{
		$form = $forms->gift($order);

		return view('form', [
			'title'       => 'Transferindo pedido',
			'form'        => $form,
			'submit_text' => 'Transferir',
		]);
	}

	/**
	 * @param OrderService $service
	 * @param Order        $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws OrderAlreadyActivatedException
	 * @throws OrderCanceledException
	 * @throws OrderNotPaidException
	 */
	public function activate(OrderService $service, Order $order)
	{
		if ($order->canceled)
			throw new OrderCanceledException();

		if ($order->activated)
			throw new OrderAlreadyActivatedException();

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

	/**
	 * @param OrderService $service
	 * @param Request      $request
	 * @param Order        $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \App\Exceptions\InvalidSteamIdException
	 */
	public function transfer(OrderService $service, Request $request, Order $order)
	{
		if (empty($request->input('steamid'))) {
			$service->returnOrder($order);

			flash()->success('Pedido retornado para sua conta!');
		} else {
			$service->transferOrder($order, $request->input('steamid'));

			flash()->success("Pedido transferido para a SteamID <strong>$order->steamid</strong>!");
		}

		return redirect()->route('orders.show', $order);
	}

	public function update(OrderService $service, Request $request, Order $order)
	{
		$service->updateOrder($order, $request->all());

		flash()->success('Order was updated!');

		return redirect()->route('orders.index');
	}
}
