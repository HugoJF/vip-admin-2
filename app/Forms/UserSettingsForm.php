<?php

namespace App\Forms;

class UserSettingsForm extends Form
{
	public function buildForm()
	{
		$user = $this->getData('user');

		$this->add('tradelink', 'text', [
			'label'      => 'Link de troca',
			'help_block' => $this->buildHelpBlock('Esse é o link que utilizamos para enviar os pedidos de troca. Você pode achar sua URL <strong><u><a href="https://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url">clicando aqui</a></u></strong>. (obrigatório apenas na compra com itens de CS:GO)'),
		]);
		$this->add('email', 'text', [
			'label'      => 'E-mail',
			'help_block' => $this->buildHelpBlock('Utilizaremos esse email para enviar <strong>promoções, descontos e notificações</strong> da sua conta no VIP-Admin. (recomendado mas opcional)'),
		]);

		if (config('vip-admin.enforce-terms', false))
			$this->add('terms', 'checkbox', [
				'label'      => 'Concordar com os termos',
				'help_block' => $this->buildHelpBlock('Consulte nosso termos de serviço <a href="' . route('terms') . '">clicando aqui.</a>'),
			]);

		if ($user && $user->affiliate)
			$this->add('affiliate_code', 'text', [
				'label'      => 'Código de afiliado',
				'help_block' => $this->buildHelpBlock('Código que será utilizado no seu link de afiliado. Exemplo: <strong>' . route('affiliate', 'seucodigoaqui') . '</strong>'),
			]);

		$this->add('hidden_flags', 'checkbox', [
			'label'      => 'Remover tags',
			'help_block' => $this->buildHelpBlock('Remover as tags do <i>scoreboard</i> e do <i>chat</i>.'),
		]);
	}
}
