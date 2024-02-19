<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;

class GroupPolicy
{
    private UserPolicy $userPolicy;

    public function __construct(UserPolicy $userPolicy)
    {
        $this->userPolicy = $userPolicy;
    }

    public function show(User $authUser, Group $group): bool
    {
        return $group->isAssignedToUser($authUser) || $this->userPolicy->isAdmin($authUser);
    }
}
