<?php

namespace App\Exceptions;

use Throwable;

class InvalidCouponException extends FlashException
{
    protected $coupon;

    public function __construct($coupon = null)
    {
        parent::__construct();

        $this->coupon = $coupon;
    }

    public function flash()
    {
        if ($this->coupon) {
            eflash()->error("Cupom <strong>%s</strong> não é válido!", $this->coupon);
        } else {
            flash()->error('Cupom inválido!');
        }
    }

    public function getResponse()
    {
        return back();
    }
}
