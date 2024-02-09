<?php

namespace App\Services;

use App\Models\RoutePoint;
use App\Repositories\RoutePointRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class RoutePointService
{
    private RoutePointRepository $routePointRepository;

    public function __construct(RoutePointRepository $routePointRepository)
    {
        $this->routePointRepository = $routePointRepository;
    }

    public function paginate($input): LengthAwarePaginator
    {
        return $this->routePointRepository->paginate($input);
    }

    public function getRoutePoint($id): RoutePoint
    {
        return $this->routePointRepository->findOrFail($id);
    }

    public function createRoutePoint(array $data): RoutePoint
    {
        return $this->routePointRepository->create($data);
    }

    public function updateRoutePoint($id, array $data): RoutePoint
    {
        return $this->routePointRepository->update($id, $data);
    }

    public function deleteRoutePoint($id): bool
    {
        return $this->routePointRepository->delete($id);
    }
}
