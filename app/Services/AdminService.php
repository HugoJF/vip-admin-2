<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:43 AM
 */

namespace App\Services;

use App\Admin;

class AdminService
{
	public function storeAdmin(array $values)
	{
		$admin = Admin::create($values);

		return $admin;
	}

	public function updateAdmin(Admin $admin, array $values)
	{
		$admin->fill($values);

		$admin->save();

		return $admin;
	}
}