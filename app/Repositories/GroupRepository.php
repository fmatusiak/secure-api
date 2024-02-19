<?php

namespace App\Repositories;

use App\Helpers\AuthHelper;
use App\Interfaces\GroupRepositoryInterface;
use App\Models\Group;
use App\Models\User;
use App\Services\QueryFilteringService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class GroupRepository extends CrudRepository implements GroupRepositoryInterface
{
    private QueryFilteringService $queryFilteringService;

    public function __construct(Group $group, QueryFilteringService $queryFilteringService)
    {
        parent::__construct($group);
        $this->queryFilteringService = $queryFilteringService;
    }

    public function getUserGroups(User $user, array $input): LengthAwarePaginator
    {
        $perPage = Arr::get($input, 'per_page', 10);
        $columns = Arr::get($input, 'columns', ['*']);

        return $user
            ->groups()
            ->paginate($perPage, $columns);
    }

    public function paginate(array $input): LengthAwarePaginator
    {
        $perPage = Arr::get($input, 'per_page', 10);
        $columns = Arr::get($input, 'columns', ['*']);

        $query = Group::query();

        $authUser = AuthHelper::getCurrentUser();

        if (!$authUser->isAdmin()) {
            $query = $this->queryFilteringService->filterByRelatedUser($authUser, $query);
        }

        if ($name = Arr::get($input, 'name')) {
            $query = $query->where('name', 'like', '%' . $name . '%');
        }

        if ($description = Arr::get($input, 'description')) {
            $query = $query->where('description', 'like', '%' . $description . '%');
        }

        return $query
            ->with('users')
            ->paginate($perPage, $columns);
    }

    public function getUsersByGroup(Group $group, array $input): LengthAwarePaginator
    {
        $perPage = Arr::get($input, 'per_page', 10);
        $columns = Arr::get($input, 'columns', ['*']);

        return $group
            ->users()
            ->paginate($perPage, $columns);
    }
}
