<?php

namespace App\Helpers;

use Illuminate\Support\Arr;

class PaginationHelper
{
    public static function getPerPage(array $input): int
    {
        return Arr::get($input, 'per_page', 10);
    }

    public static function getColumns(array $input): array
    {
        return Arr::get($input, 'columns', ['*']);
    }
}
