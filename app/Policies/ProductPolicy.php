<?php

namespace App\Policies;

use App\Product;
use App\User;

class ProductPolicy extends BasePolicy
{
	public function list(User $user)
	{
		return false;
	}

    public function view(User $user, Product $product)
    {
        return true;
	}

	public function store(User $user)
	{
		return false;
	}

	public function update(User $user, Product $product)
	{
		return false;
	}

	public function destroy(User $user, Product $product)
	{
		return false;
	}
}
