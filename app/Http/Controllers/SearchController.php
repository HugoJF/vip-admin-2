<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(SearchService $service, Request $request)
    {
        $mapping = [
            'orders' => [
                'title'    => 'Orders',
                'view'     => 'cards.orders',
                'variable' => 'orders',
            ],
            'users'  => [
                'title'    => 'Users',
                'view'     => 'cards.users',
                'variable' => 'users',
            ],
        ];

        $result = $service->search($request->input('term'));

        return view('search', compact('result', 'mapping'));
    }
}
