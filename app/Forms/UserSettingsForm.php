<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UserSettingsForm extends Form
{
	public function buildForm()
	{
		$this->add('tradelink', 'text');
		$this->add('email', 'text');
		$this->add('terms', 'checkbox');
		$this->add('affiliate_code', 'text');
	}
}
