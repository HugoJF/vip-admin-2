<?php

namespace App\Exceptions;

use Exception;

class AffiliateCodeNotSetException extends FlashException
{
    public function flash()
    {
        flash()->error('Você precisa configurar um código de afiliado antes de acessar essa página!');
    }

    public function getResponse()
    {
        return back();
    }
}
