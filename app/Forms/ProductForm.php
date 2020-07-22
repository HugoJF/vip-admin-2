<?php

namespace App\Forms;

class ProductForm extends Form
{
    public function buildForm()
    {
        $this->add('title', 'text', [
            'label'      => 'Título',
            'help_block' => $this->buildHelpBlock(''),
        ]);

        $this->add('duration', 'number', [
            'label'      => 'Duração',
            'help_block' => $this->buildHelpBlock('Tempo em dias da duração do VIP'),
            'attr'       => [
                'min' => 0,
                'max' => 90,
            ],
        ]);

        $this->add('cost', 'number', [
            'label'      => 'Custo',
            'help_block' => $this->buildHelpBlock('Custo atual em centavos do período de VIP'),
            'attr'       => [
                'min' => 0,
                'max' => 5000,
            ],
        ]);

        $this->add('original_cost', 'number', [
            'label'      => 'Custo original',
            'help_block' => $this->buildHelpBlock('Custo original em centavos do período de VIP (usado para comparar desconto atual)'),
            'attr'       => [
                'min' => 0,
                'max' => 5000,
            ],
        ]);

        $this->add('description', 'textarea', [
            'label'      => 'Descrição do VIP',
            'help_block' => $this->buildHelpBlock('Descrição do <i>card</i> do VIP'),
        ]);

        $this->add('filter', 'text', [
            'label'      => 'Filtro',
            'help_block' => $this->buildHelpBlock('Filtro para que o produto seja visível'),
        ]);
    }
}
