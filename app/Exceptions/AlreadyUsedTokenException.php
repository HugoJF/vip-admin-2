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
        $id = e($this->token->id);
        flash()->error("Token <strong>$id</strong> já foi utilizado!");
    }

    public function getResponse()
    {
        return back();
    }
}
