<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Invisnik\LaravelSteamAuth\SteamAuth;

class AuthController extends Controller
{
	protected $steam;

	protected $redirectURL = '/';

	public function __construct(SteamAuth $steam)
	{
		$this->steam = $steam;
	}

	public function redirectToSteam()
	{
		return $this->steam->redirect();
	}

	public function handle()
	{
		if ($this->steam->validate()) {
			$info = $this->steam->getUserInfo();

			if (!is_null($info)) {
				$user = $this->findOrNewUser($info);

				Auth::login($user, true);

				return redirect($this->redirectURL); // redirect to site
			}
		}

		return $this->redirectToSteam();
	}

	/**
	 * Getting user by info or created if not exists
	 *
	 * @param $info
	 *
	 * @return User
	 */
	protected function findOrNewUser($info)
	{
		$user = User::where('steamid', $info->steamID64)->first();

		if (!is_null($user)) {
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
