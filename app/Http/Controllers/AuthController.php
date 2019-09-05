<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
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

	public function handle(AuthService $service)
	{
		// TODO: catch 429?
		if (!$this->steam->validate()) {
			$info = $this->steam->getUserInfo();

			if (!is_null($info)) {
				$user = $service->findOrNewUser($info);

				Auth::login($user, true);

				return redirect($this->redirectURL); // redirect to site
			}
		}

		return $this->redirectToSteam();
	}
}