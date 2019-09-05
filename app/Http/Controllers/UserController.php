<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
	public function index()
	{
		$users = User::all();

		return view('users.index', compact('users'));
	}

	public function settings(Request $request)
	{
		$user = Auth::user();

		$user->fill($request->only(['email', 'tradelink', 'name', 'terms', 'affiliate_code']));

		$user->save();

		flash()->success('Opções de usuários atualizadas!');

		return redirect()->route('home');
	}

	public function affiliate($code)
	{
		if (Auth::check()) {
			flash()->error('Não é possível registra código de afiliado após o registro!');

			return redirect()->route('home');
		}

		$user = User::whereAffiliateCode($code)->first();

		if (!$user) {
			flash()->error('Código de afiliado inválido!');
		} else {
			Cookie::queue('affiliate', $user->id);

			flash()->success("Código $code registrado!");
		}

		return redirect()->route('home');
	}
}
