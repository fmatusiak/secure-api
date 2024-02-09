<?php

namespace App\Exceptions;

use Exception;

class RoutePointNotFoundException extends Exception
{
    public function __construct($message = 'Route point not found', $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
