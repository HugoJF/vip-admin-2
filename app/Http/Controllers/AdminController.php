<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Services\AdminService;
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

	public function edit(AdminForms $forms, Admin $admin)
	{
		$form = $forms->edit($admin);

		return view('form', [
			'title'       => 'Editando admin',
			'form'        => $form,
			'submit_text' => 'Atualizar',
		]);
	}

	public function store(AdminService $service, AdminStoreRequest $request)
	{
		$admin = $service->storeAdmin($request->validated());
		$username = e($admin->username);

		flash()->success("Admin <strong>$username</strong> criado com sucesso!");

		return redirect()->route('admins.index');
	}

	public function update(AdminService $service, AdminUpdateRequest $request, Admin $admin)
	{
		$admin = $service->updateAdmin($admin, $request->validated());
		$username = e($admin->username);

		flash()->success("Admin <strong>$username</strong> atualizado!");

		return redirect()->route('admins.index');
	}

	public function destroy(Admin $admin)
	{
		$admin->delete();
		$username = e($admin->username);

		flash()->success("Admin <strong>$username</strong> removido!");

		return redirect()->route('admins.index');
	}
}
