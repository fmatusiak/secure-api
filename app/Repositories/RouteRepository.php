<?php

namespace App\Repositories;

use App\DateParser;
use App\Exceptions\AdjacentRoutePointException;
use App\Exceptions\DuplicateRoutePointException;
use App\Helpers\AuthHelper;
use App\Interfaces\RouteRepositoryInterface;
use App\Models\Route;
use App\Models\RouteRoutePoint;
use App\Services\QueryFilteringService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RouteRepository extends CrudRepository implements RouteRepositoryInterface
{
    private QueryFilteringService $queryFilteringService;
    private DateParser $dateParser;

    public function __construct(Route $route, QueryFilteringService $queryFilteringService, DateParser $dateParser)
    {
        parent::__construct($route);
        $this->queryFilteringService = $queryFilteringService;
        $this->dateParser = $dateParser;
    }

    public function paginate(array $input): LengthAwarePaginator
    {
        $perPage = Arr::get($input, 'per_page', 10);
        $columns = Arr::get($input, 'columns', ['*']);

        $query = $this->model::query();

        $authUser = AuthHelper::getCurrentUser();

        if (!$authUser->isAdmin()) {
            $query = $this->queryFilteringService->filterByRelatedUser($authUser, $query);
        }

        if ($name = Arr::get($input, 'name')) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        return $query->paginate($perPage, $columns);
    }

    public function assignRoutePoints(int $routeId, array $routePoints): Collection
    {
        try {
            DB::beginTransaction();

            $route = $this->findOrFail($routeId);

            $route->routePoints()->detach();

            foreach ($routePoints as $routePoint) {
                $routePointId = $routePoint['id'];
                $order = $routePoint['order'];
                $arrivalTime = Arr::get($routePoint, 'arrival_time');

                $this->checkAddRoutePoint($routeId, $routePointId, $order);

                if ($arrivalTime) {
                    $carbonArrivalTime = $this->dateParser->parse($arrivalTime);
                    $arrivalTime = $carbonArrivalTime->format('H:i:s');
                }

                $route->routePoints()->attach($routePointId, ['order' => $order, 'arrival_time' => $arrivalTime]);
            }

            DB::commit();

            return $route->routePoints;
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * @throws DuplicateRoutePointException
     * @throws AdjacentRoutePointException
     */
    private function checkAddRoutePoint($routeId, $routePointId, $order): void
    {
        $this->ensureUniqueRoutePoint($routeId, $routePointId, $order);
        $this->ensureNoAdjacentRoutePoint($routeId, $routePointId, $order);
        $this->ensureNoSameOrder($routeId, $order);
    }

    /**
     * @throws DuplicateRoutePointException
     */
    private function ensureUniqueRoutePoint($routeId, $routePointId, $order): void
    {
        if ($this->routePointExists($routeId, $routePointId, $order)) {
            throw new DuplicateRoutePointException('You cannot add the same route point with the same order');
        }
    }

    private function routePointExists($routeId, $routePointId, $order): bool
    {
        return RouteRoutePoint::where([
            ['route_id', $routeId],
            ['route_point_id', $routePointId],
            ['order', $order]
        ])->exists();
    }

    /**
     * @throws AdjacentRoutePointException
     */
    private function ensureNoAdjacentRoutePoint($routeId, $routePointId, $order): void
    {
        $existingRoutePoints = $this->getRouteRoutePoints($routeId, $routePointId);

        if ($existingRoutePoints->contains('order', $order + 1) || $existingRoutePoints->contains('order', $order - 1)) {
            throw new AdjacentRoutePointException('You cannot add the same route point side by side');
        }
    }

    private function getRouteRoutePoints(int $routeId, int $routePointId): Collection
    {
        return RouteRoutePoint::where([
            ['route_id', $routeId],
            ['route_point_id', $routePointId],
        ])->get();
    }

    /**
     * @throws DuplicateRoutePointException
     */
    private function ensureNoSameOrder($routeId, $order): void
    {
        if ($this->routePointExistsWithSameOrder($routeId, $order)) {
            throw new DuplicateRoutePointException('Cannot add the route point with the same order in other route point');
        }
    }

    private function routePointExistsWithSameOrder($routeId, $order): bool
    {
        return RouteRoutePoint::where([
            ['route_id', $routeId],
            ['order', $order]
        ])->exists();
    }

    public function updateArrivalTimeForRoute(int $routeId, int $routePointId, int $order, string $arrivalTime): bool
    {
        $arrivalTime = $this->dateParser->parse($arrivalTime);

        return RouteRoutePoint::where([
            ['route_id', $routeId],
            ['route_point_id', $routePointId],
        ])->update(['arrival_time' => $arrivalTime]);
    }

    public function deleteRoutePoints(int $routeId, array $routePoints): bool
    {
        try {
            DB::beginTransaction();

            foreach ($routePoints as $routePoint) {
                $this->deleteSingleRoutePoint($routeId, $routePoint);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    private function deleteSingleRoutePoint(int $routeId, array $routePoint): bool
    {
        $routePointId = $routePoint['id'];
        $order = $routePoint['order'];

        try {
            DB::beginTransaction();

            $routeRoutePoint = RouteRoutePoint::where([
                ['route_id', $routeId],
                ['route_point_id', $routePointId],
                ['order', $order],
            ])->first();

            if (!$routeRoutePoint) {
                DB::rollBack();
                return false;
            }

            if (!$routeRoutePoint->delete()) {
                DB::rollBack();
                return false;
            }

            RouteRoutePoint::where([
                ['route_id', $routeId],
                ['order', '>', $order],
            ])->decrement('order');

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function assignUsersToRoute(int $routeId, array $userIds): Collection
    {
        $route = $this->findOrFail($routeId);

        $route->users()->attach($userIds);

        return $route->users;
    }

    public function detachUsersFromRoute(int $routeId, array $userIds): Collection
    {
        $route = $this->findOrFail($routeId);

        $route->users()->detach($userIds);

        return $route->users;
    }
}
