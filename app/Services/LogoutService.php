<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class LogoutService
{
    public function logout(): void
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();
    }
}
