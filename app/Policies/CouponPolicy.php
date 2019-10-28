<?php

namespace App\Policies;

use App\User;
use App\Coupon;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy extends BasePolicy
{
	use HandlesAuthorization;

	public function list(User $user)
	{
		return false;
	}

	public function create(User $user)
	{
		return false;
	}

	public function edit(User $user, Coupon $coupon)
	{
		return false;
	}

	public function store(User $user)
	{
		return false;
	}

	public function update(User $user, Coupon $coupon)
	{
		return false;
	}

	public function destroy(User $user, Coupon $coupon)
	{
		return false;
	}
}
