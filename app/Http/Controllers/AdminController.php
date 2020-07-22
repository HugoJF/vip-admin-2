<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Services\AdminService;
use App\Services\Forms\AdminForms;

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

        eflash()->success("Admin <strong>%s</strong> criado com sucesso!", $admin->username);

        return redirect()->route('admins.index');
    }

    public function update(AdminService $service, AdminUpdateRequest $request, Admin $admin)
    {
        $admin = $service->updateAdmin($admin, $request->validated());

        eflash()->success("Admin <strong>%s</strong> atualizado!", $admin->username);

        return redirect()->route('admins.index');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        eflash()->success("Admin <strong>%s</strong> removido!", $admin->username);

        return redirect()->route('admins.index');
    }
}
