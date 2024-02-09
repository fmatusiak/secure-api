<?php

namespace App\Services;

use App\Models\Route;
use App\Models\User;
use App\Repositories\RouteUserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class RouteUserService
{
    private RouteUserRepository $routeUserRepository;

    public function __construct(RouteUserRepository $routeUserRepository)
    {
        $this->routeUserRepository = $routeUserRepository;
    }

    public function paginate(array $input): LengthAwarePaginator
    {
        return $this->routeUserRepository->paginate($input);
    }

    public function getUserRoutes(User $user, array $input): LengthAwarePaginator
    {
        return $this->routeUserRepository->getUserRoutes($user, $input);
    }

    public function getRouteUsers(Route $route, array $input): LengthAwarePaginator
    {
        return $this->routeUserRepository->getRouteUsers($route, $input);
    }
}
