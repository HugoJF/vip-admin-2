<?php

namespace App\Policies;

use App\Admin;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

	public function before($user, $ability)
	{
		if ($user->banned)
			return false;

		if ($user->admin)
			return true;
	}

	public function view(User $user, Admin $admin)
	{
		return false;
	}

	public function store(User $user, Admin $admin)
	{
		return false;
	}

	public function update(User $user, Admin $admin)
	{
		return false;
	}

	public function destroy(User $user, Admin $admin)
	{
		return false;
	}
}
