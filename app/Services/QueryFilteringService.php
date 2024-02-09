<?php

namespace App\Services;

use App\Models\User;

class QueryFilteringService
{
    public function filterByRelatedRouteUser(?User $user, $query)
    {
        return $query->whereHas('route', function ($query) use ($user) {
            $this->filterByRelatedUser($user, $query);
        });
    }

    public function filterByRelatedUser(?User $user, $query)
    {
        return $query->whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    public function filterByUser(?User $user, $query)
    {
        return $query->where('id', $user->id);
    }

    public function filterByRouteUser(?User $user, $query)
    {
        return $query->where('user_id', $user->id);
    }
}
