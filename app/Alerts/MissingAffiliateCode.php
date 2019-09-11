<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Alerts;

class MissingAffiliateCode extends Alert
{
	public function triggered()
	{
		return is_null($this->user->affiliate_code) && $this->user->affiliate;
	}

	public function getMessage()
	{
		return "Você ainda configurou um código de afiliado!";
	}

	public function getLevel()
	{
		return 'info';
	}

	public function getUrl()
	{
		return route('settings');
	}
}