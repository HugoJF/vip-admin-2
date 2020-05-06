<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:11 AM
 */

namespace App\Services;

use App\User;

class UserService
{
	public function toggleAdmin(User $user)
	{
		$user->admin = !$user->admin;

		$user->save();

		return $user;
	}

	public function toggleAffiliate(User $user)
	{
		$user->affiliate = !$user->affiliate;

		$user->save();

		return $user;
	}

	public function getOrderBasePoint(User $user)
	{
		$lastOrder = $user
            ->orders()
            ->paid()
            ->valid()
            ->started()
            ->notExpired()
            ->notTransferred()
            ->first();

		if ($lastOrder)
			return $lastOrder->ends_at;
		else
			return now();
	}
}
