<?php

namespace App\Exceptions;

class OrderAlreadyActivated extends FlashException
{
	public function flash()
	{
		flash()->error('Seu pedido já foi ativado!');
	}

	public function getResponse()
	{
		return back();
	}
}
