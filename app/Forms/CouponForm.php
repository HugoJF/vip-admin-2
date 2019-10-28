<?php

namespace App\Forms;

class CouponForm extends Form
{
	public function buildForm()
	{
		$this->add('code', 'text', [
			'label'      => 'Código',
			'help_block' => $this->buildHelpBlock('Código referente ao cupom'),
		]);

		$this->add('discount', 'number', [
			'label'      => 'Desconto',
			'help_block' => $this->buildHelpBlock('Taxa de desconto do cupon'),
			'attr'       => [
				'min'  => 0,
				'step' => 0.01,
				'max'  => 1,
			],
		]);

		$this->add('starts_at', 'datetimepicker', [
			'label'      => 'Inicia em',
			'help_block' => $this->buildHelpBlock('Quando o cupom começa a ser válido'),
		]);

		$this->add('ends_at', 'datetimepicker', [
			'label'      => 'Expira em',
			'help_block' => $this->buildHelpBlock('Quando o cupon expira'),
		]);
	}
}
