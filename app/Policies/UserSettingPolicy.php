<?php

namespace App\Policies;

use App\User;
use App\UserSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserSettingPolicy
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
		if($user->banned)
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
		return true;
	}

	public function update(User $user, UserSetting $setting)
	{
		return $user->id === $setting->user_id;
	}
}
