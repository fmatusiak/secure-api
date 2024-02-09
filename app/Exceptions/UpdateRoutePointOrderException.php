<?php

namespace App\Exceptions;

use Exception;

class UpdateRoutePointOrderException extends Exception
{
    public function __construct($message = 'Failed to update route point order', $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
