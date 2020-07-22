<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:19 AM
 */

namespace App\Services\Forms;

use App\Coupon;
use App\Forms\CouponForm;

class CouponForms extends ServiceForms
{
    public function create()
    {
        return $this->builder->create(CouponForm::class, [
            'method' => 'POST',
            'url'    => route('coupons.store'),
        ]);
    }

    public function edit(Coupon $coupon)
    {
        return $this->builder->create(CouponForm::class, [
            'method' => 'PATCH',
            'url'    => route('coupons.update', $coupon),
            'model'  => $coupon,
        ]);
    }
}
