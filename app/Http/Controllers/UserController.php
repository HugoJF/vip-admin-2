<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function settings(Request $request)
	{
		$user = Auth::user();

		$user->fill($request->only(['email', 'tradelink', 'name']));

		$user->save();

		return $user;
	}
}
