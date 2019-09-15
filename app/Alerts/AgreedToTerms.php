<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/28/2019
 * Time: 7:28 PM
 */

namespace App\Alerts;

use App\User;

class AgreedToTerms extends Alert
{
	protected $enforcing;

	public function __construct(User $user)
	{
		parent::__construct($user);
		$this->enforcing = config('vip-admin.enforce-terms', false);
	}

	public function triggered()
	{
		return $this->enforcing && $this->user->terms !== true;
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