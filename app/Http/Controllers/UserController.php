<?php

namespace App\Http\Controllers;

use App\Exceptions\AffiliateCodeAlreadyLoggedException;
use App\Services\AffiliateService;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function index()
	{
		$users = User::all();

		return view('users.index', compact('users'));
	}

	/**
	 * @param AffiliateService $service
	 * @param                  $code
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws AffiliateCodeAlreadyLoggedException
	 */
	public function affiliate(AffiliateService $service, $code)
	{
		if (Auth::check())
			throw new AffiliateCodeAlreadyLoggedException();

		if ($service->attachAffiliateCode($code))
			flash()->success("Código <strong>$code</strong> registrado!");
		else
			flash()->error('Código de afiliado inválido!');

		return redirect()->route('home');
	}
}
