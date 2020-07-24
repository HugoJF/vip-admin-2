<?php

namespace App\Services;

use App\Classes\PaymentSystem;
use App\Events\OrderPaid;
use App\Order;

class OrderRecheckService
{
    /**
     * @var PaymentSystem
     */
    protected $paymentSystem;

    /**
     * @var OrderDurationCorrection
     */
    protected $durationCorrection;

    public function __construct(PaymentSystem $paymentSystem, OrderDurationCorrection $durationCorrection)
    {
        $this->paymentSystem = $paymentSystem;
        $this->durationCorrection = $durationCorrection;
    }

    public function handle(Order $order)
    {
        $order->query()->increment('recheck_attempts');

        if (!$order->reference) {
            return;
        }

        $payment = $this->paymentSystem->getOrder($order->reference);

        if (!in_array($payment->status, [200, 201])) {
            return;
        }

        $payment = $payment->content;

        if (!isset($payment)) {
            return;
        }

        // Apply correction if duration has changed
        if ($order->duration !== intval($payment->paid_units)) {
            $this->durationCorrection->handle($order, $payment->paid_units);
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
