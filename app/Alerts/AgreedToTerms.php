<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Alerts;

class AgreedToTerms extends Alert
{

	public function triggered()
	{
		return $this->user->terms !== true;
	}

	public function getMessage()
	{
		return "Você ainda não revisou e concordou com os termos!";
	}

	public function getLevel()
	{
		return 'danger';
	}

	public function getUrl()
	{
		return route('settings');
	}
}