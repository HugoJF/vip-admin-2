<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Alerts;

use App\User;

abstract class Alert
{
	/** @var User */
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	abstract public function triggered();
	abstract public function getMessage();
	abstract public function getLevel();
	abstract public function getUrl();
}