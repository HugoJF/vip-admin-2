<?php

namespace App\Policies;

use App\Setting;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
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
		return false;
	}

	public function create(User $user)
	{
		return false;
	}

	public function update(User $user, Setting $setting)
	{
		return false;
	}

	public function destroy(User $user, Setting $setting)
	{
		return false;
	}
}
