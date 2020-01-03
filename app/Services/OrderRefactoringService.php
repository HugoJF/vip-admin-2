<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/25/2019
 * Time: 9:46 AM
 */

namespace App\Services;

use App\Classes\PaymentSystem;
use App\Coupon;
use App\Events\OrderActivated;
use App\Events\OrderCreated;
use App\Events\OrderUpdated;
use App\Exceptions\InvalidCouponException;
use App\Exceptions\InvalidSteamIdException;
use App\Order;
use App\Product;
use App\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class OrderRefactoringService
{
    public function refactorUser(User $user)
    {
        /** @var Collection $ordersByUser */
        $ordersByUser = $user
            ->orders()
            ->paid()
            ->valid()
            ->whereNull('steamid')
            ->whereNotNull('starts_at')
            ->get();
        $ordersById = $this->getOrdersBySteamid($user->steamid);

        info("Started refactoring for user $user->steamid");
        $this->refactorOrders($ordersById->merge($ordersByUser));
        info("Ended refactoring");
    }

    public function refactorSteamid($steamid)
    {
        $steamid = steamid64($steamid);
        // If SteamID is present in database, refactor as User
        $user = User::query()->where('steamid', $steamid)->first();
        if ($user) {
            $this->refactorUser($user);

            return;
        }

        /** @var Collection $orders */
        $orders = $this->getOrdersBySteamid($steamid);

        info("Started refactoring for user $steamid");
        $this->refactorOrders($orders);
        info("Ended refactoring");
    }

    protected function getOrdersBySteamid($steamid)
    {
        return Order::query()->paid()->valid()->whereNotNull('created_at')->where('steamid', $steamid)->get();
    }

    protected function refactorOrders($orders)
    {
        $orders = collect($orders)->sortBy('created_at');

        $base = now();
        /** @var Order $order */
        foreach ($orders as $order) {
            if ($order->starts_at->isPast()) {
                $duration = now()->diff($order->ends_at);
            } else {
                $duration = $order->starts_at->diff($order->ends_at);
            }
            $order->starts_at = $base;
            $base->add($duration);
            $order->ends_at = $base;

            info(sprintf("Refactored order %s from %s<=>%s to %s<=>%s",
                $order->id,
                $order->getOriginal('starts_at'),
                $order->getOriginal('ends_at'),
                $order->starts_at,
                $order->ends_at
            ));

            $order->save();
        }
    }
}