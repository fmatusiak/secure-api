<?php

namespace App\Repositories;

use App\Helpers\AuthHelper;
use App\Interfaces\RouteRoutePointRepositoryInterface;
use App\Models\Route;
use App\Models\RoutePoint;
use App\Models\RouteRoutePoint;
use App\Services\QueryFilteringService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class RouteRoutePointRepository extends CrudRepository implements RouteRoutePointRepositoryInterface
{
    private QueryFilteringService $queryFilteringService;

    public function __construct(RouteRoutePoint $routeRoutePoint, QueryFilteringService $queryFilteringService)
    {
        parent::__construct($routeRoutePoint);
        $this->queryFilteringService = $queryFilteringService;
    }

    public function getRoutePointsByRoute(Route $route, array $input): LengthAwarePaginator
    {
        $perPage = Arr::get($input, 'per_page', 10);
        $columns = Arr::get($input, 'columns', ['*']);

        return $route
            ->routePoints()
            ->paginate($perPage, $columns);
    }

    public function paginate(array $input): LengthAwarePaginator
    {
        $perPage = Arr::get($input, 'per_page', 10);
        $columns = Arr::get($input, 'columns', ['*']);

        $query = $this->model::query();

        $authUser = AuthHelper::getCurrentUser();

        if (!$authUser->isAdmin()) {
            $query = $this->queryFilteringService->filterByRouteUser($authUser, $query);
        }

        return $query
            ->with(['route', 'routePoint'])
            ->paginate($perPage, $columns);
    }

    public function getRoutesByRoutePoint(RoutePoint $routePoint, array $input): LengthAwarePaginator
    {
        $perPage = Arr::get($input, 'per_page', 10);
        $columns = Arr::get($input, 'columns', ['*']);

        $query = $routePoint->routes();

        $authUser = AuthHelper::getCurrentUser();

        if (!$authUser->isAdmin()) {
            $query = $this->queryFilteringService->filterByUser($authUser, $query);
        }

        return $query->paginate($perPage, $columns);
    }
}
