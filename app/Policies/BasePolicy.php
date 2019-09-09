<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/9/2019
 * Time: 12:39 AM
 */

namespace App\Policies;

class BasePolicy
{
	use HandlesAuthorization;

	public function before($user, $ability)
	{
		if ($user->banned)
			return false;

		if ($user->admin)
			return true;
	}
}