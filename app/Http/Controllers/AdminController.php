<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function index()
	{
		return Admin::all();
	}

	public function store(Request $request)
	{
		$admin = Admin::create($request->all());

		return $admin;
	}

	public function update(Request $request, Admin $admin)
	{
		$admin->fill($request->all());

		$admin->save();

		return $admin;
	}

	public function destroy(Admin $admin)
	{
		$admin->delete();

		return $admin;
	}
}
