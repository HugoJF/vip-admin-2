<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class TokenForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('id', 'text')
            ->add('duration', 'number')
            ->add('note', 'textarea')
            ->add('expires_at', 'datetimepicker');
    }
}
