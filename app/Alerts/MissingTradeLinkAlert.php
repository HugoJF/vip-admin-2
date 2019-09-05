<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Alerts;

class MissingTradeLinkAlert extends Alert
{

	public function triggered()
	{
		return !isset($this->user->tradelink);
	}

	public function getMessage()
	{
		return "Tradelink ainda não foi fornecido!";
	}

	public function getLevel()
	{
		return 'warning';
	}

	public function getUrl()
	{
		return '#';
	}
}