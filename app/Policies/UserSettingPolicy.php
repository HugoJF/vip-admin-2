<?php

namespace App\Policies;

use App\User;
use App\UserSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserSettingPolicy extends BasePolicy
{
	public function list(User $user)
	{
		return true;
	}

	public function create(User $user)
	{
		return true;
	}

	public function update(User $user, UserSetting $setting)
	{
		return $user->id === $setting->user_id;
	}
}
