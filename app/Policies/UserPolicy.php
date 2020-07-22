<?php

namespace App\Policies;

use App\User;

class UserPolicy extends BasePolicy
{
    public function search(User $user, User $other)
    {
        return false;
    }

    public function list(User $user)
    {
        return false;
    }

    public function view(User $user, User $other)
    {
        return $user->id === $other->id;
    }

    public function admin(User $user, User $other)
    {
        return false;
    }

    public function affiliate(User $user, User $other)
    {
        return false;
    }

    public function refactor(User $user, User $other)
    {
        return false;
    }
}
