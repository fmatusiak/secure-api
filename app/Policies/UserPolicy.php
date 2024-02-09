<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function show(User $authUser, User $getUser): bool
    {
        return $this->isAdmin($authUser) || $authUser->getId() === $getUser->getId();
    }

    public function isAdmin(User $authUser): bool
    {
        return $authUser->isAdmin();
    }
}
