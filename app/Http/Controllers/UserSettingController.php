<?php

namespace App\Http\Controllers;

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

	public function update(Request $request)
	{
		$user = Auth::user();

		$user->fill($request->only(['email', 'tradelink', 'name', 'terms', 'affiliate_code']));

		$user->save();

		flash()->success('Opções de usuários atualizadas!');

		return redirect()->route('home');
	}
}
