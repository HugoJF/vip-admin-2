<?php

namespace App\Services;

use App\Classes\PaymentSystem;
use App\Events\OrderPaid;
use App\Order;

class OrderRecheckService
{
    public function handle(Order $order)
    {
        /** @var $paymentSystem */
        $paymentSystem = app(PaymentSystem::class);

        $order->recheck_attempts = $order->recheck_attempts + 1;

        $order->touch();
        $order->save();

        if (!$order->reference) {
            return;
        }

        $payment = $paymentSystem->getOrder($order->reference);

        if (!in_array($payment->status, [200, 201])) {
            return;
        }

        $payment = $payment->content;

        if (!isset($payment)) {
            return;
        }

        if ($payment->paid_units) {
            $order->duration = $payment->paid_units;
        }

        if ($payment->paid) {
            $order->paid = true;
        }

        if (!$order->getOriginal('paid') && $order->paid) {
            event(new OrderPaid($order));
        }

        $order->touch();
        $order->save();
    }
}
