<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class OrderTransferForm extends Form
{
    public function buildForm()
    {
        $this->add('steamid', 'text');
    }
}
