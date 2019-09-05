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

		$term = $request->input('term');

		$users = $service->searchUsers($user, $term);
		$orders = $service->searchOrders($user, $term);

		return view('search', compact('term', 'users', 'orders'));
	}
}
