<?php

namespace App\Exceptions;

use Throwable;

class InvalidCouponException extends FlashException
{
	protected $coupon;

	public function __construct($coupon = null, $message = "", $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->coupon = $coupon;
	}

	public function flash()
	{
		if ($this->coupon)
			flash()->error("Cupom <strong>{$this->coupon}</strong> não é válido!");
		else
			flash()->error('Cupom inválido!');
	}

	public function getResponse()
	{
		return back();
	}
}
