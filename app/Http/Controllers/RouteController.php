<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignRoutePointsRequest;
use App\Http\Requests\AssignUsersToRouteRequest;
use App\Http\Requests\CreateRouteRequest;
use App\Http\Requests\DeleteRoutePointsRequest;
use App\Http\Requests\DetachUsersFromRouteRequest;
use App\Http\Requests\UpdateArrivalTimeForRouteRequest;
use App\Http\Requests\UpdateRouteRequest;
use App\Models\Route;
use App\Models\User;
use App\Services\RouteService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    protected RouteService $routeService;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    public function paginate(Request $request): JsonResponse
    {
        $data = $this->routeService->paginate($request->all());

        return response()->json($data);
    }

    /**
     * @throws AuthorizationException
     */
    public function getRoute(int $routeId): JsonResponse
    {
        $route = $this->routeService->getRoute($routeId);

        $this->authorize('show', [Route::class, $route]);

        return response()->json(['data' => $route]);
    }

    /**
     * @throws AuthorizationException
     */
    public function createRoute(CreateRouteRequest $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $route = $this->routeService->createRoute($request->all());

        return response()->json(['data' => $route]);
    }

    /**
     * @throws AuthorizationException
     */
    public function updateRoute(int $routeId, UpdateRouteRequest $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $route = $this->routeService->updateRoute($routeId, $request->all());

        return response()->json(['data' => $route]);
    }

    /**
     * @throws AuthorizationException
     */
    public function deleteRoute(int $routeId): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $status = $this->routeService->deleteRoute($routeId);

        return response()->json(['status' => $status]);
    }

    /**
     * @throws Exception
     */
    public function assignRoutePoints(AssignRoutePointsRequest $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $routeId = $request->input('route_id');
        $routePoints = $request->input('route_points');

        $data = $this->routeService->assignRoutePoints($routeId, $routePoints);

        return response()->json(['data' => $data]);
    }

    /**
     * @throws Exception
     */
    public function deleteRoutePoints(DeleteRoutePointsRequest $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $routeId = $request->input('route_id');
        $routePoints = $request->input('route_points');

        $data = $this->routeService->deleteRoutePoints($routeId, $routePoints);

        return response()->json(['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function updateArrivalTimeForRoute(UpdateArrivalTimeForRouteRequest $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $routeId = $request->input('route_id');
        $routePointId = $request->input('route_point_id');
        $order = $request->input('order');
        $arrivalTime = $request->input('arrival_time');

        $status = $this->routeService->updateArrivalTimeForRoute($routeId, $routePointId, $order, $arrivalTime);

        return response()->json(['status' => $status]);
    }

    /**
     * @throws AuthorizationException
     */
    public function assignUsersToRoute(AssignUsersToRouteRequest $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $routeId = $request->input('route_id');
        $userIds = $request->input('user_ids');

        $usersAssigned = $this->routeService->assignUsersToRoute($routeId, $userIds);

        return response()->json(['data' => $usersAssigned]);
    }

    /**
     * @throws AuthorizationException
     */
    public function detachUsersFromRoute(DetachUsersFromRouteRequest $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $routeId = $request->input('route_id');
        $userIds = $request->input('user_ids');

        $usersDetached = $this->routeService->detachUsersFromRoute($routeId, $userIds);

        return response()->json(['data' => $usersDetached]);
    }

}
