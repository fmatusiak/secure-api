<?php

namespace App\Helpers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    public static function getCurrentUser(): ?Authenticatable
    {
        return Auth::user();
    }
}
