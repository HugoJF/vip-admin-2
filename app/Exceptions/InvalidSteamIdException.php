<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidSteamIdException extends FlashException
{
	public function flash()
	{
		flash()->error("<strong>$this->message</strong> não é uma SteamID válida!");
	}

	public function getResponse()
	{
		return back();
	}
}
