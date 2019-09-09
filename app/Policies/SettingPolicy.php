<?php

namespace App\Policies;

use App\Setting;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy extends BasePolicy
{
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
