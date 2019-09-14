<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class OrderForm extends Form
{
	public function buildForm()
	{
		$this->add('starts_at', 'datetimepicker');
		$this->add('ends_at', 'datetimepicker');
		$this->add('paid', 'checkbox');
		$this->add('canceled', 'checkbox');
		$this->add('auto_activates', 'checkbox');
		$this->add('recheck_attempts', 'number');
	}
}
