<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RouteService;
use App\Services\RouteUserService;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RouteUserController extends Controller
{
    protected RouteUserService $routeUserService;

    protected UserService $userService;

    protected RouteService $routeService;

    public function __construct(
        RouteUserService $routeUserService,
        UserService      $userService,
        RouteService     $routeService
    )
    {
        $this->routeUserService = $routeUserService;
        $this->userService = $userService;
        $this->routeService = $routeService;
    }

    public function paginate(Request $request): JsonResponse
    {
        $data = $this->routeUserService->paginate($request->all());

        return response()->json($data);
    }

    /**
     * @throws AuthorizationException
     */
    public function getUserRoutes(int $userId, Request $request): JsonResponse
    {
        $user = $this->userService->getUser($userId);

        $this->authorize('show', [User::class, $user]);

        $userRoutes = $this->routeUserService->getUserRoutes($user, $request->all());

        return response()->json($userRoutes);
    }

    /**
     * @throws AuthorizationException
     */
    public function getRouteUsers(int $routeId, Request $request): JsonResponse
    {
        $route = $this->routeService->getRoute($routeId);

        $this->authorize('isAdmin', User::class);

        $routeUsers = $this->routeUserService->getRouteUsers($route, $request->all());

        return response()->json($routeUsers);
    }
}
