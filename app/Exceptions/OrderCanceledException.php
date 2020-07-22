<?php

namespace App\Exceptions;

class OrderCanceledException extends FlashException
{
    public function flash()
    {
        flash()->error('Seu pedido foi cancelado!');
    }

    public function getResponse()
    {
        return back();
    }
}
