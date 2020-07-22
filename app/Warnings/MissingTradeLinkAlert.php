<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Warnings;

use HugoJF\ModelWarnings\Contracts\Warning;

class MissingTradeLinkAlert extends Warning
{
	public function triggered()
	{
		return empty($this->context->tradelink);
	}

    /**
     * @inheritDoc
     */
    public function buildMessage()
    {
        return [
            'message' => 'Tradelink ainda não foi fornecido!',
            'level'   => 'warning',
            'url'     => route('settings'),
        ];
    }
}
