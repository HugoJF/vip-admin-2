<?php

namespace App\Exceptions;

class InvalidSteamIdException extends FlashException
{
    public function flash()
    {
        $message = e($this->message);
        flash()->error("<strong>$message</strong> não é uma SteamID válida!");
    }

    public function getResponse()
    {
        return back();
    }
}
