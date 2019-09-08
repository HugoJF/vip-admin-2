<?php

namespace App\Http\Controllers;

use App\Product;

class HomeController extends Controller
{
	public function home()
	{
		$prices = config('vip-admin.durations');
		$products = Product::all();

		return view('home', compact('products', 'prices'));
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
