<?php

namespace App\Repositories;

use App\Helpers\AuthHelper;
use App\Helpers\PaginationHelper;
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

    public function getUsersByGroup(Group $group, array $input): LengthAwarePaginator
    {
        $perPage = PaginationHelper::getPerPage($input);
        $columns = PaginationHelper::getColumns($input);

        return $group
            ->users()
            ->paginate($perPage, $columns);
    }

    public function paginate(array $input): LengthAwarePaginator
    {
        $perPage = PaginationHelper::getPerPage($input);
        $columns = PaginationHelper::getColumns($input);

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

    public function getUsersAssignedToGroupByUser(User $user, array $input): LengthAwarePaginator
    {
        $perPage = PaginationHelper::getPerPage($input);
        $columns = PaginationHelper::getColumns($input);

        $groupsPaginator = $this->getUserGroups($user, $input);
        $groupIds = $groupsPaginator->pluck('id');

        $userQuery = User::query();

        return $userQuery->whereHas('groups', function ($query) use ($groupIds) {
            $query->whereIn('group_id', $groupIds);
        })
            ->whereNot('id', $user->getId())
            ->distinct()
            ->paginate($perPage, $columns);
    }

    public function getUserGroups(User $user, array $input): LengthAwarePaginator
    {
        $perPage = PaginationHelper::getPerPage($input);
        $columns = PaginationHelper::getColumns($input);

        return $user
            ->groups()
            ->paginate($perPage, $columns);
    }
}
