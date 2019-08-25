<?php

namespace App\Policies;

use App\Token;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TokenPolicy
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

	public function list(User $user)
	{
		return true;
	}

	public function create(User $user)
	{
		return false;
	}

	public function update(User $user, Token $token)
	{
		return false;
	}

	public function delete(User $user, Token $token)
	{
		return false;
	}

	public function use(User $user, Token $token)
	{
		return true;
	}
}
