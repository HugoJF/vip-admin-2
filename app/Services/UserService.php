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
	public function getOrderBasePoint(User $user)
	{
		$lastOrder = $user->orders()->where('canceled', false)->whereNotNull('ends_at')->orderBy('ends_at', 'DESC')->first();

		return $lastOrder->ends_at;
	}
}