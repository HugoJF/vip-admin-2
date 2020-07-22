<?php

namespace App\Exceptions;

use App\Token;

class AlreadyUsedTokenException extends FlashException
{
    protected $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
        parent::__construct();
    }

    public function flash()
    {
        eflash()->error("Token <strong>%s</strong> já foi utilizado!", $this->token->id);
    }

    public function getResponse()
    {
        return back();
    }
}
