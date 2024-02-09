<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Exception;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * @throws Exception
     */
    public function login(LoginRequest $request, LoginService $loginService): JsonResponse
    {
        $login = $request->input('login');
        $password = $request->input('password');

        $loginResult = $loginService->login($login, $password);

        return response()->json(['data' => $loginResult]);
    }
}
