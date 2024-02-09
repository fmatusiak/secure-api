<?php

namespace App\Policies;

use App\Models\RoutePoint;
use App\Models\User;

class RoutePointPolicy
{
    private UserPolicy $userPolicy;

    public function __construct(UserPolicy $userPolicy)
    {
        $this->userPolicy = $userPolicy;
    }

    public function show(User $authUser, RoutePoint $routePoint): bool
    {
        return $this->userPolicy->isAdmin($authUser) || $routePoint->isAssignedToUser($authUser);
    }
}
