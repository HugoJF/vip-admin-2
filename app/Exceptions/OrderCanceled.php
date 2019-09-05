<?php

namespace App\Exceptions;

use Exception;

class OrderCanceled extends FlashException
{
	public function flash()
	{
		flash()->error('Seu pedido foi cancelado!');
	}

	public function getResponse()
	{
		return back();
	}
}
