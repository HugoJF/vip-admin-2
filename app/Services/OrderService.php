<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/25/2019
 * Time: 9:46 AM
 */

namespace App\Services;

class OrderService
{
	public function validateDuration($duration)
	{
		return array_key_exists($duration, config('vip-admin.durations'));
	}
}