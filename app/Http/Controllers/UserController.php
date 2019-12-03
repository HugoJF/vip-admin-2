<?php

namespace App\Http\Controllers;

use App\Exceptions\AffiliateCodeAlreadyLoggedException;
use App\Services\AffiliateService;
use App\Services\UserService;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function index()
	{
		$users = User::all();

		return view('users.index', compact('users'));
	}

	public function toggleAdmin(UserService $service, User $user)
	{
		$service->toggleAdmin($user);

		$username = e($user->username);
		if ($user->admin)
			flash()->success("<strong>$username</strong> promovido para administrador!");
		else
			flash()->success("<strong>$username</strong> removido dos administradores");

		return back();
	}

	public function toggleAffiliate(UserService $service, User $user)
	{
		$service->toggleAffiliate($user);

		$username = e($user->username);
		if ($user->affiliate)
			flash()->success("<strong>$username</strong> adicionado para lista de afiliados");
		else
			flash()->success("<strong>$username</strong> removido da lista de afiliados");

		return back();
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
			$code = e($code);
			flash()->success("Código <strong>$code</strong> registrado!");
		else
			flash()->error('Código de afiliado inválido!');

		return redirect()->route('home');
	}
}
