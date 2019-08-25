<?php

namespace App\Http\Controllers;

use App\Order;
use App\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
	public function search(Request $request)
	{
		$user = Auth::user();
		$admin = $user->admin;
		$term = $request->input('term');

		// Admins should be able to search all records and users only what's related to him
		if ($admin) {
			$orders = Order::query();
			$tokens = Token::query();
		} else {
			$orders = $user->orders();
			$tokens = $user->tokens();
		}

		$orders = $orders->search($term)->get();
		$tokens = $tokens->search($term)->with(['order', 'user'])->get();

		return compact('orders', 'tokens');
	}
}
