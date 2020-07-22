<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\User;

class HomeController extends Controller
{
    public function home(ProductService $service)
    {
        $products = $service->getHomeProducts();

        return view('home', compact('products'));
    }

    public function faq()
    {
        return view('faq');
    }

    public function terms()
    {
        return view('terms');
    }

    public function clients()
    {
        $clients = [];
        $users = User::with(['orders'])->get();
        /** @var User $user */
        foreach ($users as $user) {
            if (!$user->email)
                continue;
            $data = collect($user->attributesToArray())->only(['username', 'steamid', 'email', 'created_at']);
            $vip = $user->currentVip() != false;
            $data['currently_vip'] = $vip;
            $data['total_orders'] = $user->orders->count();
            $data['paid_orders'] = $user->orders->where('paid', true)->count();
            $data['total_days'] = $user->orders->where('paid', true)->sum('duration');
            $data['last_expired_vip'] = $vip ? null : $user->orders->sortBy('ends_at')->first()->ends_at ?? null;
            $clients[] = $data;
        }

        return $clients;
    }
}
