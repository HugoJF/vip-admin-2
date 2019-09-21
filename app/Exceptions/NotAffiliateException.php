<?php

namespace App\Exceptions;

use Exception;

class NotAffiliateException extends FlashException
{
    public function flash()
    {
        flash()->error('Você precisa ser afiliado para acessar essa página!');
    }

    public function getResponse()
    {
        return back();
    }
}
