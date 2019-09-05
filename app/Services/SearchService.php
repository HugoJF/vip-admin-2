<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9/5/2019
 * Time: 12:37 AM
 */

namespace App\Services;

use App\Order;
use App\User;

class SearchService
{
	public function searchUsers($user, $term)
	{
		return $user->admin ? User::search($term)->get() : null;
	}

	public function searchOrders($user, $term)
	{
		$orders = $user->admin ? Order::query() : $user->orders();

		return $orders->search($term)->get();
	}
}