<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RouteRepositoryInterface
{
    public function assignRoutePoints(int $routeId, array $routePoints): Collection;

    public function deleteRoutePoints(int $routeId, array $routePoints): bool;

    public function updateArrivalTimeForRoute(int $routeId, int $routePointId, int $order, string $arrivalTime): bool;

    public function paginate(array $input): LengthAwarePaginator;

    public function assignUsersToRoute(int $routeId, array $userIds): Collection;

    public function detachUsersFromRoute(int $routeId, array $userIds): Collection;
}
