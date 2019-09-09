<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends BasePolicy
{
	public function list(User $user, User $other)
	{
		return false;
	}

	public function admin(User $user, User $other)
	{
		return false;
	}
}
