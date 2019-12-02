<?php

namespace App\Http\Controllers;

use App\Events\UserSettingsUpdated;
use App\Http\Requests\UserSettingsUpdateRequest;
use App\Services\Forms\HomeForms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\FormBuilder;

class UserSettingController extends Controller
{
	public function edit(HomeForms $forms)
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

		$user->fill($request->validated() + ['hidden_flags' => 0, 'terms' => 0]);

		$user->save();

		event(new UserSettingsUpdated($user));

		flash()->success('Opções de usuários atualizadas!');

		return redirect()->route('home');
	}
}
