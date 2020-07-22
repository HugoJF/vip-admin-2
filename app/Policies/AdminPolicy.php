<?php

namespace App\Policies;

use App\Admin;
use App\User;

class AdminPolicy extends BasePolicy
{
    public function list(User $user, Admin $admin)
    {
        return false;
    }

    public function store(User $user, Admin $admin)
    {
        return false;
    }

    public function update(User $user, Admin $admin)
    {
        return false;
    }

    public function destroy(User $user, Admin $admin)
    {
        return false;
    }
}
