<?php

namespace App\Policies;

use App\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy extends BasePolicy
{
    public function search(User $user, Order $order)
    {
        return $order->user_id === $user->id;
    }

	public function list(User $user)
	{
		return true;
	}

	public function view(User $user, Order $order)
	{
		return $user->id === $order->user_id;
	}

	public function store(User $user)
	{
		return true;
	}

	public function update(User $user, Order $order)
	{
		return false;
	}

	public function transfer(User $user, Order $order)
	{
		return $user->id === $order->user_id;
	}

	public function activate(User $user, Order $order)
	{
		return $user->id === $order->user_id;
	}
}
