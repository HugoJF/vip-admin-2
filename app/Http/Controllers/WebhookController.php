<?php

namespace App\Http\Controllers;

use App\Order;

class WebhookController extends Controller
{
    public function webhook(Order $order)
    {
        $order->recheck();

        return response()->json([
            'status' => 200,
        ]);
    }
}
