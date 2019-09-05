<?php

namespace App\Exceptions;

use Exception;

class InvalidOrderDurationException extends FlashException
{
	public function flash()
	{
		flash()->error('Duração do pedido inválida!');
	}

	public function getResponse()
	{
		return back();
	}
}
