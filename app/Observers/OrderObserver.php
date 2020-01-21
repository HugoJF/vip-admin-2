<?php

namespace App\Observers;

use App\Order;
use Exception;

class OrderObserver
{
    public function creating(Order $order)
    {
        // Do nothing if an ID was already assigned
        if ($order->id)
            return;

        $id = null;
        $attempts = 0;
        $maxAttempts = config('vip-admin.unique-order-id-max-attempts', 30);

        while ($attempts++ < $maxAttempts) {
            $id = random_id(5);

            $exists = Order::query()->find($id);

            // Stop trying to find new IDs if nothing was found
            if (!$exists)
                break;
        }

        if ($attempts >= $maxAttempts)
            throw new Exception("Failed to find an ID after $attempts tries.");

        $order->id = $id;
    }
}
