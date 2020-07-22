<?php

namespace App\Http\Controllers;

use App\Order;
use App\Services\OrderRecheckService;

class WebhookController extends Controller
{
    public function webhook(OrderRecheckService $service, Order $order)
    {
        $service->handle($order);

        return response()->json([
            'status' => 200,
        ]);
    }
}
