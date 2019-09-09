<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:34 AM
 */

namespace App\Services;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class AuthService
{

	/**
	 * @param $info
	 *
	 * @return mixed
	 */
	public function findOrNewUser($info)
	{
		$user = User::where('steamid', $info->steamID64)->first();

		if (!is_null($user)) {
			$user->username = $info->personaname;
			$user->avatar = $info->avatarfull;
			$user->save();

			return $user;
		}

		$user = User::make([
			'username' => $info->personaname,
			'avatar'   => $info->avatarfull,
		]);
		$user->steamid = $info->steamID64;

		if (Cookie::has('affiliate')) {
			$affiliate = User::find(Cookie::get('affiliate'));

			if ($affiliate) {
				$user->referrer_id = $affiliate->id;
				$user->referred_at = Carbon::now();
			}
		}

		$user->save();

		return $user;
	}
}