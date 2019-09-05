<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Alerts;

class MissingEmailAlert extends Alert
{

	public function triggered()
	{
		return !isset($this->user->email);
	}

	public function getMessage()
	{
		return "Email ainda não foi fornecido!";
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