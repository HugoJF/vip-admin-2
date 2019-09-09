<?php

namespace App\Policies;

use App\Token;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TokenPolicy extends BasePolicy
{
	public function list(User $user)
	{
		return true;
	}

	public function view(User $User, Token $token)
	{
		return true;
	}

	public function store(User $user)
	{
		return false;
	}

	public function use(User $user, Token $token)
	{
		return true;
	}

	public function delete(User $user, Token $token)
	{
		return false;
	}
}
