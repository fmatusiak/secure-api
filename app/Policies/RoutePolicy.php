<?php

namespace App\Policies;

use App\Models\Route;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoutePolicy
{
    use HandlesAuthorization;

    private UserPolicy $userPolicy;

    public function __construct(UserPolicy $userPolicy)
    {
        $this->userPolicy = $userPolicy;
    }

    public function show(User $authUser, Route $route): bool
    {
        return $route->users->contains($authUser) || $this->userPolicy->isAdmin($authUser);
    }
}
