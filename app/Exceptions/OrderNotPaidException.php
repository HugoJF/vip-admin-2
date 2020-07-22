<?php

namespace App\Exceptions;

class OrderNotPaidException extends FlashException
{
    //
    public function flash()
    {
        flash()->error('O seu pedido ainda não foi pago!');
    }

    public function getResponse()
    {
        return back();
    }
}
