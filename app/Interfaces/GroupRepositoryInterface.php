<?php

namespace App\Interfaces;

use App\Models\Group;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface GroupRepositoryInterface
{
    public function paginate(array $input): LengthAwarePaginator;

    public function getUserGroups(User $user, array $input): LengthAwarePaginator;

    public function getUsersByGroup(Group $group, array $input): LengthAwarePaginator;
}
