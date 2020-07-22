<?php

namespace App\Http\Controllers;

use App\Exceptions\OrderAlreadyActivatedException;
use App\Exceptions\OrderCanceledException;
use App\Exceptions\OrderNotActivatedException;
use App\Exceptions\OrderNotPaidException;
use App\Http\Requests\OrderStoreRequest;
use App\Order;
use App\Product;
use App\Services\Forms\OrderForms;
use App\Services\OrderRecheckService;
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
     * @throws \Exception
     */
    public function store(OrderService $service, OrderStoreRequest $request, Product $product)
    {
        $user = Auth::user();
        $response = $service->create($user, $request->validated(), $product);
        // TODO: move flashexceptions to flash directory
        // TODO: throw flash on payment system
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
        $service->activateOrder($order);

        flash()->success('Pedido ativado com sucesso!');

        return redirect()->route('orders.show', $order);
    }

    public function show(OrderRecheckService $service, Order $order)
    {
        $service->handle($order);

        return view('orders.show', compact('order'));
    }

    /**
     * @param OrderService $service
     * @param Request      $request
     * @param Order        $order
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\InvalidSteamIdException
     * @throws OrderNotActivatedException
     */
    public function transfer(OrderService $service, Request $request, Order $order)
    {
        if (empty($request->input('steamid'))) {
            if (!$service->returnOrder($order)) {
                return back();
            }

            flash()->success('Pedido retornado para sua conta!');

            return redirect()->route('orders.show', $order);
        }

        if (!$order->activated) {
            throw new OrderNotActivatedException;
        }

        if (!$service->transferOrder($order, $request->input('steamid'))) {
            return back();
        }

        flash()->success("Pedido transferido para a SteamID <strong>$order->steamid</strong>!");

        return redirect()->route('orders.show', $order);
    }

    public function update(OrderService $service, Request $request, Order $order)
    {
        $service->updateOrder($order, $request->all());

        flash()->success('Order was updated!');

        return redirect()->route('orders.index');
    }
}
