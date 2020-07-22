<?php

namespace App\Listeners;

use App\Events\VipExpired;
use App\Mail\VipExpiredMail;
use Illuminate\Support\Facades\Mail;

class SendVipExpiredMail
{
    /**
     * Handle the event.
     *
     * @param VipExpired $event
     *
     * @return void
     */
    public function handle(VipExpired $event)
    {
        $order = $event->order;
        $user = $order->user;

        if ($user->email)
            Mail::to($user->email)->send(new VipExpiredMail());
    }
}
