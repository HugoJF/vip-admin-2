<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:11 AM
 */

namespace App\Services;

use App\Coupon;

class CouponService
{
    public function create(array $data)
    {
        ($coupon = new Coupon)->fill($data);

        return $coupon;
    }

    public function update(Coupon $coupon, array $data)
    {
        $coupon->update($data);
        $coupon->save();

        return $coupon;
    }

    public function findCoupon($code)
    {
        return Coupon::valid()->whereCode($code)->orderBy('discount', 'DESC')->first();
    }
}
