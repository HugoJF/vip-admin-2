<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class AdminForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('username', 'text')
            ->add('steamid', 'text')
            ->add('flags', 'text')
            ->add('note', 'textarea');
    }
}
