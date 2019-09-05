<?php

namespace App\Http\Controllers;

use App\Forms\UserSettingsForm;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\FormBuilder;

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

	public function settings(FormBuilder $builder)
	{
		$form = $builder->create(UserSettingsForm::class, [
			'method' => 'PATCH',
			'url'    => route('settings'),
			'model'  => Auth::user(),
		]);

		return view('form', [
			'title'       => 'Opções de usuário',
			'form'        => $form,
			'submit_text' => 'Atualizar',
		]);
	}

	public function search(Request $request)
	{
		$user = Auth::user();
		$admin = $user->admin;

		$term = $request->input('term');

		if ($admin)
			$users = User::search($term)->get();

		if ($admin)
			$orders = Order::search($term)->get();
		else
			$orders = $user->orders()->search($term)->get();

		return view('search', compact('term', 'users', 'orders'));
	}
}
