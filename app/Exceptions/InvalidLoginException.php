<?php

namespace App\Exceptions;

use Exception;

class InvalidLoginException extends Exception
{
    public function __construct($message = "Authentication failed")
    {
        parent::__construct($message);
    }
}
