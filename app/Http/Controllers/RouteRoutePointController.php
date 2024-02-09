<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RoutePoint;
use App\Services\RoutePointService;
use App\Services\RouteRoutePointService;
use App\Services\RouteService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RouteRoutePointController extends Controller
{
    protected RouteRoutePointService $routeRoutePointService;
    protected RouteService $routeService;
    protected RoutePointService $routePointService;

    public function __construct(RouteRoutePointService $routeRoutePointService)
    {
        $this->routeRoutePointService = $routeRoutePointService;
    }

    public function paginate(Request $request): JsonResponse
    {
        $data = $this->routeRoutePointService->paginate($request->all());

        return response()->json($data);
    }

    /**
     * @throws AuthorizationException
     */
    public function getRoutePointsByRoute(int $routeId, Request $request): JsonResponse
    {
        $route = $this->routeService->getRoute($routeId);

        $this->authorize('show', [Route::class, $route]);

        $routePoints = $this->routeRoutePointService->getRoutePointsByRoute($route, $request->all());

        return response()->json($routePoints);
    }

    /**
     * @throws AuthorizationException
     */
    public function getRoutesByRoutePoint(int $routePointId, Request $request): JsonResponse
    {
        $routePoint = $this->routePointService->getRoutePoint($routePointId);

        $this->authorize('show', [RoutePoint::class, $routePoint]);

        $routes = $this->routeRoutePointService->getRoutesByRoutePoint($routePoint, $request->all());

        return response()->json($routes);
    }

}
