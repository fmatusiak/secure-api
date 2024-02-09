<?php

namespace App\Services;

use App\Models\Route;
use App\Models\RoutePoint;
use App\Repositories\RouteRoutePointRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class RouteRoutePointService
{
    private RouteRoutePointRepository $routePointRepository;

    public function __construct(RouteRoutePointRepository $routePointRepository)
    {
        $this->routePointRepository = $routePointRepository;
    }

    public function paginate(array $input): LengthAwarePaginator
    {
        return $this->routePointRepository->paginate($input);
    }

    public function getRoutePointsByRoute(Route $route, array $input): LengthAwarePaginator
    {
        return $this->routePointRepository->getRoutePointsByRoute($route, $input);
    }

    public function getRoutesByRoutePoint(RoutePoint $routePoint, array $input): LengthAwarePaginator
    {
        return $this->routePointRepository->getRoutesByRoutePoint($routePoint, $input);
    }
}
