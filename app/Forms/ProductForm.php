<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ProductForm extends Form
{
	public function buildForm()
	{
		$this->add('title', 'text');
		$this->add('duration', 'number', [
			'attr' => [
				'min' => 0,
				'max' => 90,
			],
		]);
		$this->add('cost', 'number', [
			'attr' => [
				'min' => 0,
				'max' => 5000,
			],
		]);
		$this->add('discount', 'number', [
			'attr' => [
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
			],
		]);
		$this->add('description', 'textarea');
	}
}
