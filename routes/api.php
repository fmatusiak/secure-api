<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\RoutePointController;
use App\Http\Controllers\RouteRoutePointController;
use App\Http\Controllers\RouteUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('routes')->group(function () {
        Route::get('/', [RouteController::class, 'paginate']);
        Route::get('{routeId}', [RouteController::class, 'getRoute']);
        Route::post('/', [RouteController::class, 'createRoute']);
        Route::put('{routeId}', [RouteController::class, 'updateRoute']);
        Route::delete('{routeId}', [RouteController::class, 'deleteRoute']);

        Route::post('assign-points', [RouteController::class, 'assignRoutePoints']);
        Route::post('delete-points', [RouteController::class, 'deleteRoutePoints']);
        Route::post('update-arrival-time', [RouteController::class, 'updateArrivalTimeForRoute']);

        Route::post('assign-users', [RouteController::class, 'assignUsersToRoute']);
        Route::post('detach-users', [RouteController::class, 'detachUsersFromRoute']);

        Route::get('{routeId}/users', [RouteUserController::class, 'getRouteUsers']);
    });

    Route::prefix('route-points')->group(function () {
        Route::get('/', [RoutePointController::class, 'paginate']);
        Route::get('{routePointId}', [RoutePointController::class, 'getRoutePoint']);
        Route::post('/', [RoutePointController::class, 'createRoutePoint']);
        Route::put('{routePointId}', [RoutePointController::class, 'updateRoutePoint']);
        Route::delete('{routePointId}', [RoutePointController::class, 'deleteRoutePoint']);
    });

    Route::prefix('user-routes')->group(function () {
        Route::get('/', [RouteUserController::class, 'paginate']);
    });

    Route::prefix('route-route-points')->group(function () {
        Route::get('/', [RouteRoutePointController::class, 'paginate']);
        Route::get('route/{routeId}', [RouteRoutePointController::class, 'getRoutePointsByRoute']);
        Route::get('route-point/{routePointId}', [RouteRoutePointController::class, 'getRoutesByRoutePoint']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'paginate']);
        Route::get('{userId}', [UserController::class, 'getUser']);
        Route::post('/', [UserController::class, 'createUser']);
        Route::patch('{userId}', [UserController::class, 'updateUser']);
        Route::delete('{userId}', [UserController::class, 'deleteUser']);

        Route::get('{userId}/routes', [RouteUserController::class, 'getUserRoutes']);
        Route::get('{userId}/groups', [GroupController::class, 'getUserGroups']);
        Route::get('{userId}/assigned-users', [GroupController::class, 'getUsersAssignedToGroupByUser']);
    });

    Route::prefix('user-groups')->group(function () {
        Route::get('/',[GroupController::class,'paginate']);
        Route::get('{groupId}',[GroupController::class,'getGroup']);
        Route::post('/',[GroupController::class,'createGroup']);
        Route::put('{groupId}',[GroupController::class,'updateGroup']);
        Route::delete('{groupId}',[GroupController::class,'deleteGroup']);

        Route::get('{groupId}/users',[GroupController::class,'getUsersByGroup']);
    });

    Route::post('/logout', [LogoutController::class, 'logout']);
});

Route::post('/login', [LoginController::class, 'login']);
