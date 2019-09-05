<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
	public function search(SearchService $service, Request $request)
	{
		$user = Auth::user();
		$admin = $user->admin;

		$term = $request->input('term');

		$users = $service->searchUsers($admin, $term);
		$orders = $service->searchOrders($admin, $term);

		return view('search', compact('term', 'users', 'orders'));
	}
}
