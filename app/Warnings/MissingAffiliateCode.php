<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Warnings;

use HugoJF\ModelWarnings\Contracts\Warning;

class MissingAffiliateCode extends Warning
{
	public function triggered()
	{
		return empty($this->context->affiliate_code) && $this->context->affiliate;
	}

    /**
     * @inheritDoc
     */
    public function buildMessage()
    {
        return [
            'message' => 'Você ainda configurou um código de afiliado!',
            'level'   => 'info',
            'url'     => route('settings'),
        ];
    }
}
