<?php

namespace App\Http\Controllers;

use App\Product;

class HomeController extends Controller
{
	public function home()
	{
		$products = Product::all();

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
