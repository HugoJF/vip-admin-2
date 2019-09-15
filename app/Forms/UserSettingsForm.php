<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UserSettingsForm extends Form
{
	public function buildForm()
	{
		$this->add('tradelink', 'text');
		$this->add('email', 'text');

		if (config('vip-admin.enforce-terms', false))
			$this->add('terms', 'checkbox');

		$user = $this->getData('user');
		if ($user && $user->affiliate)
			$this->add('affiliate_code', 'text');
	}
}
