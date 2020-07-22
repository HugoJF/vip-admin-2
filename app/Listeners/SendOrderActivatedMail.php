<?php

namespace App\Listeners;

use App\Events\OrderActivated;
use App\Mail\OrderActivatedMail;
use Illuminate\Support\Facades\Mail;

class SendOrderActivatedMail
{
    /**
     * Handle the event.
     *
     * @param OrderActivated $event
     *
     * @return void
     */
    public function handle(OrderActivated $event)
    {
        $order = $event->order;
        $user = $order->user;

        if ($user->email)
            Mail::to($user->email)->send(new OrderActivatedMail($order));
    }
}
