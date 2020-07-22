<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Warnings;

use HugoJF\ModelWarnings\Contracts\Warning;

class MissingEmailAlert extends Warning
{
    public function triggered()
    {
        return empty($this->context->email);
    }

    /**
     * @inheritDoc
     */
    public function buildMessage()
    {
        return [
            'message' => 'Email ainda não foi fornecido!',
            'level'   => 'warning',
            'url'     => route('settings'),
        ];
    }
}
