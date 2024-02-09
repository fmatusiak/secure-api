<?php

namespace Tests\Feature;

use App\DateParser;
use App\Exceptions\AdjacentRoutePointException;
use App\Exceptions\DuplicateRoutePointException;
use App\Models\Route;
use App\Models\RoutePoint;
use App\Services\RouteService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteAssignmentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testAssignRoutePointsWithDifferentOrder()
    {
        $route = Route::factory()->create();
        $routePoints = RoutePoint::factory()->count(10)->create();
        $routeService = $this->app[RouteService::class];
        $routeId = $route->id;
        $routePointsToAssignRoute = [];
        $order = 1;

        foreach ($routePoints as $routePoint) {
            $hours = $this->faker->numberBetween(0, 2);
            $minutes = $this->faker->numberBetween(0, 59);
            $seconds = $this->faker->numberBetween(0, 59);

            $generateTime = Carbon::create(null, null, null, $hours, $minutes, $seconds);
            $arrivalTime = $generateTime->toString();

            $routePointsToAssignRoute[] = [
                'id' => $routePoint->id,
                'order' => $order++,
                'arrival_time' => $arrivalTime,
            ];
        }

        $resultAssignRoutePoints = $routeService->assignRoutePoints($routeId, $routePointsToAssignRoute);
        $this->assertEquals(count($routePoints), $resultAssignRoutePoints->count());

        $dateParser = new DateParser();

        foreach ($routePointsToAssignRoute as $routePointToAssignRoute) {
            $dataToCheck = [
                'route_id' => $routeId,
                'route_point_id' => $routePointToAssignRoute['id'],
                'order' => $routePointToAssignRoute['order'],
                'arrival_time' => $dateParser->parse($routePointToAssignRoute['arrival_time'])->format('H:i:s'),
            ];

            $this->assertDatabaseHas('route_route_points', $dataToCheck);
        }
    }

    public function testAssignRoutePointsWithThisSameRoutePointAndOrder()
    {
        $route = Route::factory()->create();
        $routePoints = RoutePoint::factory()->count(1)->create();
        $routeService = $this->app[RouteService::class];
        $routeId = $route->id;
        $routePointsToAssignRoute = [];

        $order = 1;

        foreach ($routePoints as $routePoint) {
            $hours = $this->faker->numberBetween(0, 2);
            $minutes = $this->faker->numberBetween(0, 59);
            $seconds = $this->faker->numberBetween(0, 59);

            $generateTime = Carbon::create(null, null, null, $hours, $minutes, $seconds);
            $arrivalTime = $generateTime->toString();

            $routePointsToAssignRoute[] = [
                'id' => $routePoint->id,
                'order' => $order,
                'arrival_time' => $arrivalTime,
            ];
        }

        $thisSameRoutePoint = $routePointsToAssignRoute[0];
        $routePointsToAssignRoute[] = $thisSameRoutePoint;

        $this->expectException(DuplicateRoutePointException::class);
        $routeService->assignRoutePoints($routeId, $routePointsToAssignRoute);
    }

    public function testAssignRoutePointsWithAdjacentSameRoutePointsOrderPlusOne()
    {
        $route = Route::factory()->create();
        $routePoints = RoutePoint::factory()->count(2)->create();
        $routeService = $this->app[RouteService::class];
        $routeId = $route->id;
        $routePointsToAssignRoute = [];

        $order = 1;

        foreach ($routePoints as $routePoint) {
            $hours = $this->faker->numberBetween(0, 2);
            $minutes = $this->faker->numberBetween(0, 59);
            $seconds = $this->faker->numberBetween(0, 59);

            $generateTime = Carbon::create(null, null, null, $hours, $minutes, $seconds);
            $arrivalTime = $generateTime->toString();

            $routePointsToAssignRoute[] = [
                'id' => $routePoint->id,
                'order' => $order,
                'arrival_time' => $arrivalTime,
            ];

            $order++;
        }

        $additionalRoutePoint = $routePointsToAssignRoute[1];
        $additionalRoutePoint['order'] = $additionalRoutePoint['order'] + 1;

        $routePointsToAssignRoute[] = $additionalRoutePoint;

        $this->expectException(AdjacentRoutePointException::class);
        $routeService->assignRoutePoints($routeId, $routePointsToAssignRoute);
    }

    public function testAssignRoutePointsWithAdjacentSameRoutePointsOrderMinusOne()
    {
        $route = Route::factory()->create();
        $routePoints = RoutePoint::factory()->count(2)->create();
        $routeService = $this->app[RouteService::class];
        $routeId = $route->id;
        $routePointsToAssignRoute = [];

        $order = 1;

        foreach ($routePoints as $routePoint) {
            $hours = $this->faker->numberBetween(0, 2);
            $minutes = $this->faker->numberBetween(0, 59);
            $seconds = $this->faker->numberBetween(0, 59);

            $generateTime = Carbon::create(null, null, null, $hours, $minutes, $seconds);
            $arrivalTime = $generateTime->toString();

            $routePointsToAssignRoute[] = [
                'id' => $routePoint->id,
                'order' => $order,
                'arrival_time' => $arrivalTime,
            ];

            $order++;
        }

        $additionalRoutePoint = $routePointsToAssignRoute[1];
        $additionalRoutePoint['order'] = $additionalRoutePoint['order'] - 1;

        $routePointsToAssignRoute[] = $additionalRoutePoint;

        $this->expectException(AdjacentRoutePointException::class);
        $routeService->assignRoutePoints($routeId, $routePointsToAssignRoute);
    }

    public function testAssignRoutePointsWithSameRoutePointsInDifferentOrder()
    {
        $route = Route::factory()->create();
        $routePoints = RoutePoint::factory()->count(10)->create();

        $routeService = $this->app[RouteService::class];
        $routeId = $route->id;
        $routePointsToAssignRoute = [];

        $order = 1;

        foreach ($routePoints as $routePoint) {
            $hours = $this->faker->numberBetween(0, 2);
            $minutes = $this->faker->numberBetween(0, 59);
            $seconds = $this->faker->numberBetween(0, 59);

            $generateTime = Carbon::create(null, null, null, $hours, $minutes, $seconds);
            $arrivalTime = $generateTime->toString();

            $routePointsToAssignRoute[] = [
                'id' => $routePoint->id,
                'order' => $order,
                'arrival_time' => $arrivalTime,
            ];

            $order++;
        }

        $existingRoutePoint = $routePointsToAssignRoute[6];
        $existingRoutePoint['order'] = 11;

        $routePointsToAssignRoute[] = $existingRoutePoint;

        $resultAssignRoutePoints = $routeService->assignRoutePoints($routeId, $routePointsToAssignRoute);

        $this->assertEquals(11, $resultAssignRoutePoints->count());
    }

}
