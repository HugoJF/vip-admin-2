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
}
