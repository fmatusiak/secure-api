<?php

namespace App\Http\Controllers;

use App\Services\LogoutService;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    public function logout(LogoutService $logoutService): JsonResponse
    {
        $logoutService->logout();

        return response()->json(['status' => true]);
    }
}
