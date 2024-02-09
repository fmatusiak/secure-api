<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface RoutePointRepositoryInterface
{
    public function paginate($input): LengthAwarePaginator;
}
