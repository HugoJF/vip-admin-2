<?php

namespace App\Forms;

class OrderForm extends Form
{
	public function buildForm()
	{
		$this->add('starts_at', 'datetimepicker', [
			'label'      => 'Período de início do VIP',
			'help_block' => $this->buildHelpBlock('Data em que o período de VIP começa a ser válido.'),
		]);

		$this->add('ends_at', 'datetimepicker', [
			'label'      => 'Período de término do VIP',
			'help_block' => $this->buildHelpBlock('Data em que o período de VIP deixa de ser válido.'),
		]);

		$this->add('paid', 'checkbox', [
			'label'      => 'Pago',
			'help_block' => $this->buildHelpBlock('Se o pedido foi pago ou não (é sempre sobrescrito pela verificação automática).'),
		]);

		$this->add('canceled', 'checkbox', [
			'label'      => 'Cancelado',
			'help_block' => $this->buildHelpBlock('Se o pedido foi manualmente cancelado.'),
		]);

		$this->add('auto_activates', 'checkbox', [
			'label'      => 'Auto-ativação',
			'help_block' => $this->buildHelpBlock('Se o pedido automaticamente se ativa assim que pago.'),
		]);

		$this->add('recheck_attempts', 'number', [
			'label'      => 'Quantidade de verificações',
			'help_block' => $this->buildHelpBlock('Quantidade de consultas foram feitas na API de pagamentos.'),
		]);
	}
}
