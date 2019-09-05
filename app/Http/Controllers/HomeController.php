<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
	public function home()
	{
		$prices = config('vip-admin.durations');

		return view('home', compact('prices'));
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
