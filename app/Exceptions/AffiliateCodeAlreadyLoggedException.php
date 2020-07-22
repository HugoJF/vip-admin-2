<?php

namespace App\Exceptions;

class AffiliateCodeAlreadyLoggedException extends FlashException
{
    public function flash()
    {
        flash()->error('Não é possível registrar código de afiliado após o registro!');
    }

    public function getResponse()
    {
        return redirect()->route('home');
    }
}
