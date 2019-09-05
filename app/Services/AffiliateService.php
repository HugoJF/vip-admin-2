<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:43 AM
 */

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Cookie;

class AffiliateService
{
	public function attachAffiliateCode($code)
	{
		$user = User::whereAffiliateCode($code)->first();

		if ($user) {
			Cookie::queue('affiliate', $user->id);

			return true;
		} else {
			return false;
		}
	}
}