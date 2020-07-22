<?php

namespace App\Exceptions;

use Exception;

class OrderNotActivatedException extends FlashException
{
    public function flash()
    {
        flash()->error('O seu pedido ainda não está ativado!');
    }

    public function getResponse()
    {
        return back();
    }
}
