<?php

namespace App\Interfaces;

use App\Models\Route;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface RouteUserInterface
{
    public function paginate(array $input): LengthAwarePaginator;

    public function getUserRoutes(User $user, array $input): LengthAwarePaginator;

    public function getRouteUsers(Route $route, array $input): LengthAwarePaginator;
}
