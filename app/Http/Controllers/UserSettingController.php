<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSettingsUpdateRequest;
use App\Services\Forms\HomeForms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\FormBuilder;

class UserSettingController extends Controller
{
	public function edit(HomeForms $forms, FormBuilder $builder)
	{
		$user = Auth::user();
		$form = $forms->settings($user);

		return view('form', [
			'title'       => 'Opções de usuário',
			'form'        => $form,
			'submit_text' => 'Atualizar',
		]);
	}

	public function update(UserSettingsUpdateRequest $request)
	{
		$user = Auth::user();

		$user->fill($request->validated() + ['terms' => 0]);

		$user->save();

		flash()->success('Opções de usuários atualizadas!');

		return redirect()->route('home');
	}
}
