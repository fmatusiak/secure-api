<?php

namespace App;

use Carbon\Carbon;

class DateParser
{
    public function parse(string $date)
    {
        return Carbon::parse($date);
    }
}
