<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadyUsedTokenException;
use App\Exceptions\TokenExpiredException;
use App\Order;
use App\Token;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TokenController extends Controller
{
	public function index()
	{
		$user = Auth::user();

		if ($user->admin) {
			return Token::with(['user'])->get();
		} else {
			return $user->tokens()->with(['user'])->get();
		}
	}

	public function use(Token $token)
	{
		if ($token->order !== null)
			throw new AlreadyUsedTokenException('Token already used.');

		if ($token->expires_at->isPast())
			throw new TokenExpiredException('Expired tokens cannot be used');

		$order = Order::make();

		$order->id = 'to' . $token->id;
		$order->duration = $token->duration;

		$order->paid = true;
		$order->canceled = false;

		$order->user()->associate(Auth::user());

		$order->recheck();

		$token->order()->associate($order);

		$token->save();

		return $token;
	}

	public function store(Request $request)
	{
		$validation = Validator::make($request->all(), [
			'id'      => 'required|alpha_num',
			'duration'   => 'required|numeric',
			'expires_at' => 'after:now',
		]);

		if ($validation->fails())
			// TODO: return as error (this is status code 200)
			return $validation->errors()->toJson();

		$token = Token::create($request->all());

		return $token;
	}

	public function update(Request $request, Token $token)
	{
		$token->fill($request->all());

		$token->save();

		return $token;
	}

	public function destroy(Token $token)
	{
		$token->delete();

		return $token;
	}
}
