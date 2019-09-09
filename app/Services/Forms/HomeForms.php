<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:19 AM
 */

namespace App\Services\Forms;

use App\Forms\OrderForm;
use App\Forms\UserSettingsForm;
use App\User;
use Kris\LaravelFormBuilder\FormBuilder;

class HomeForms extends ServiceForms
{
	public function settings(User $user)
	{
		return $this->builder->create(UserSettingsForm::class, [
			'method' => 'PATCH',
			'url'    => route('settings'),
			'model'  => $user,
		], compact('user'));
	}
}