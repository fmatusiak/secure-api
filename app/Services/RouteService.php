<?php

namespace App\Services;

use App\Models\Route;
use App\Repositories\RouteRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RouteService
{
    private RouteRepository $routeRepository;

    public function __construct(RouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    public function paginate(array $input): LengthAwarePaginator
    {
        return $this->routeRepository->paginate($input);
    }

    public function getRoute(int $id): Route
    {
        return $this->routeRepository->findOrFail($id);
    }

    public function createRoute(array $data): Route
    {
        return $this->routeRepository->create($data);
    }

    public function updateRoute(int $id, array $data): Route
    {
        return $this->routeRepository->update($id, $data);
    }

    public function deleteRoute(int $id): bool
    {
        return $this->routeRepository->delete($id);
    }

    /**
     * @throws Exception
     */
    public function assignRoutePoints(int $routeId, array $routePoints): Collection
    {
        return $this->routeRepository->assignRoutePoints($routeId, $routePoints);
    }

    /**
     * @throws Exception
     */
    public function deleteRoutePoints(int $routeId, array $routePoints): bool
    {
        return $this->routeRepository->deleteRoutePoints($routeId, $routePoints);
    }

    public function updateArrivalTimeForRoute(int $routeId, int $routePointId, int $order, string $arrivalTime): bool
    {
        return $this->routeRepository->updateArrivalTimeForRoute($routeId, $routePointId, $order, $arrivalTime);
    }

    public function assignUsersToRoute(int $routeId, array $userIds): Collection
    {
        return $this->routeRepository->assignUsersToRoute($routeId, $userIds);
    }

    public function detachUsersFromRoute(int $routeId, array $userIds): Collection
    {
        return $this->routeRepository->detachUsersFromRoute($routeId, $userIds);
    }

}
