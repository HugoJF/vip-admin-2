<?php

namespace App\Http\Controllers;

use App\Classes\SteamID;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Invisnik\LaravelSteamAuth\SteamAuth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
	protected $steam;

	public function __construct(SteamAuth $steam)
	{
		$this->steam = $steam;
	}

	public function index()
	{
		if (Auth::check()) {
			return [
				'authed' => true,
				'user'   => Auth::user(),
			];
		} else {
			return [
				'authed'   => false,
				'redirect' => $this->steam->getAuthUrl(),
			];
		}
	}

	public function refresh()
	{
		$user = Auth::user();

		$return = $this->index();
		$return['token'] = JWTAuth::fromUser($user);

		return $return;
	}

	/**
	 * @return array
	 * @throws \Exception
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function store()
	{
		if ($this->steam->validate()) {
			$info = $this->steam->getUserInfo();

			if (!is_null($info)) {
				$user = $this->findOrNewUser($info);

				$token = JWTAuth::fromUser($user);
			} else {
				throw new \Exception('Failed to communicate with Steam servers.');
			}
		} else {
			throw new \Exception('Failed to authenticate user');
		}

		if (isset($token)) {
			return [
				'authed' => true,
				'user'   => $user,
				'token'  => $token,
			];
		} else {
			return [
				'authed' => false,
			];
		}
	}

	/**
	 * Getting user by info or created if not exists.
	 *
	 * @param $info
	 *
	 * @return User
	 */
	protected function findOrNewUser($info)
	{
		$steamId = SteamID::normalizeSteamID($info->steamID64);
		$user = User::where('steamid', $steamId)->first();

		if (!is_null($user)) {
			return $user;
		}

		$user = User::make([
			'username' => $info->personaname,
			'avatar'   => $info->avatarfull,
		]);

		$user->steamid = $steamId;
		$user->save();

		return $user;
	}
}
