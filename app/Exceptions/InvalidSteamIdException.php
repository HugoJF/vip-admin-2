<?php

namespace App\Exceptions;

class InvalidSteamIdException extends FlashException
{
    public function flash()
    {
        eflash()->error("<strong>%s</strong> não é uma SteamID válida!", $this->message);
    }

    public function getResponse()
    {
        return back();
    }
}
