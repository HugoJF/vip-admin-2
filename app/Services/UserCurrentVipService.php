<?php

namespace App\Services;

use App\User;
use Carbon\Carbon;

class UserCurrentVipService
{
    public function handle(User $user)
    {
        $paidOrders = $user->orders()
                           ->wherePaid(true)
                           ->whereNotNull('ends_at')
                           ->whereNull('steamid')
                           ->whereCanceled(false)
                           ->get();

        if ($paidOrders->count() === 0) {
            return false;
        }

        $durations = $paidOrders->map(function ($order) {
            if ($order->ends_at->isPast()) {
                return 0;
            }

            // +1 because 23h = 0 days
            return $order->ends_at->diffInDays(Carbon::now()) + 1;
        });

        return $durations->max();
    }
}
