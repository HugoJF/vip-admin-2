<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
	use HandlesAuthorization;

	/**
	 * Create a new policy instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	public function before($user, $ability)
	{
		if ($user->banned)
			return false;

		if ($user->admin)
			return true;
	}

	public function view(User $user, User $other)
	{
		return false;
	}

	public function ban(User $user, User $other)
	{
		return false;
	}
}
