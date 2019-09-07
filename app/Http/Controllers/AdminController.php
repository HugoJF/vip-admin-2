<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Services\Forms\AdminForms;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function index()
	{
		$admins = Admin::all();

		return view('admins.index', compact('admins'));
	}

	public function create(AdminForms $forms)
	{
		$form = $forms->create();

		return view('form', [
			'title'       => 'Criando novo admin',
			'form'        => $form,
			'submit_text' => 'Criar',
		]);
	}

	public function store(AdminService $service, Request $request)
	{

		$admin = Admin::create($request->all());

		flash()->success("Admin <strong>$admin->username</strong> criado com sucesso!");

		return redirect()->route('admins.index');
	}

	public function update(Request $request, Admin $admin)
	{
		$admin->fill($request->all());

		$admin->save();

		flash()->success("Admin $admin->username atualizado!");

		return $admin;
	}

	public function destroy(Admin $admin)
	{
		$admin->delete();

		flash()->success("Admin <strong>$admin->username</strong> removido!");

		return redirect()->route('admins.index');
	}
}
