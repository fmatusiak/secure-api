<?php

namespace App\Repositories;

use App\Helpers\AuthHelper;
use App\Helpers\PaginationHelper;
use App\Interfaces\RouteUserInterface;
use App\Models\Route;
use App\Models\RouteUser;
use App\Models\User;
use App\Services\QueryFilteringService;
use Illuminate\Pagination\LengthAwarePaginator;

class RouteUserRepository extends CrudRepository implements RouteUserInterface
{
    private QueryFilteringService $queryFilteringService;

    public function __construct(RouteUser $routeUser, QueryFilteringService $queryFilteringService)
    {
        parent::__construct($routeUser);
        $this->queryFilteringService = $queryFilteringService;
    }

    public function getUserRoutes(User $user, array $input): LengthAwarePaginator
    {
        $perPage = PaginationHelper::getPerPage($input);
        $columns = PaginationHelper::getColumns($input);

        $query = $user->routes()->with(['routePoints', 'users']);

        $authUser = AuthHelper::getCurrentUser();

        if (!$authUser->isAdmin()) {
            $query = $this->queryFilteringService->filterByRelatedUser($authUser, $query);
        }

        return $query->paginate($perPage, $columns);
    }

    public function paginate(array $input): LengthAwarePaginator
    {
        $perPage = PaginationHelper::getPerPage($input);
        $columns = PaginationHelper::getColumns($input);

        $query = $this->model::query();

        $authUser = AuthHelper::getCurrentUser();

        if (!$authUser->isAdmin()) {
            $query = $this->queryFilteringService->filterByRouteUser($authUser, $query);
        }

        return $query
            ->with(['user', 'route'])
            ->paginate($perPage, $columns);
    }

    public function getRouteUsers(Route $route, array $input): LengthAwarePaginator
    {
        $perPage = PaginationHelper::getPerPage($input);
        $columns = PaginationHelper::getColumns($input);

        $authUser = AuthHelper::getCurrentUser();

        $query = $route->users();

        if (!$authUser->isAdmin()) {
            $query = $this->queryFilteringService->filterByRouteUser($authUser, $query);
        }

        return $query->paginate($perPage, $columns);
    }
}
