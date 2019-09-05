<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffiliateController extends Controller
{
	public function index()
	{
		return view('affiliates.index');
	}
}
