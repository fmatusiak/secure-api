<?php

namespace App\Interfaces;

use App\Models\Route;
use App\Models\RoutePoint;
use Illuminate\Pagination\LengthAwarePaginator;

interface RouteRoutePointRepositoryInterface
{
    public function paginate(array $input): LengthAwarePaginator;

    public function getRoutePointsByRoute(Route $route, array $input): LengthAwarePaginator;

    public function getRoutesByRoutePoint(RoutePoint $routePoint, array $input): LengthAwarePaginator;
}
