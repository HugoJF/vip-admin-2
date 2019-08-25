<?php

namespace App\Policies;

use App\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
	use HandlesAuthorization;

	public function before($user, $ability)
	{
		if ($user->banned)
			return false;

		if ($user->admin)
			return true;
	}

	public function list(User $user)
	{
		return true;
	}

	public function view(User $user, Order $order)
	{
		return $user->id === $order->user_id;
	}

	public function create(User $user)
	{
		return true;
	}

	public function activate(User $user, Order $order)
	{
		return $user->id === $order->user_id;
	}

	public function update(User $user, Order $order)
	{
		return false;
	}
}
