<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:19 AM
 */

namespace App\Services\Forms;

use App\AdminForm;

class AdminForms extends ServiceForms
{
	public function create()
	{
		return $this->builder->create(AdminForm::class, [
			'method' => 'POST',
			'url'    => route('admins.store'),
		]);
	}
}