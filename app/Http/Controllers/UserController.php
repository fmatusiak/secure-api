<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function paginate(Request $request): JsonResponse
    {
        $data = $this->userService->paginate($request->all());

        return response()->json($data);
    }

    /**
     * @throws AuthorizationException
     */
    public function createUser(CreateUserRequest $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $user = $this->userService->createUser($request->all());

        return response()->json(['data' => $user]);
    }

    /**
     * @throws AuthorizationException
     */
    public function updateUser(int $userId, UpdateUserRequest $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $user = $this->userService->updateUser($userId, $request->all());

        return response()->json(['data' => $user]);
    }

    /**
     * @throws AuthorizationException
     */
    public function getUser(int $userId): JsonResponse
    {
        $user = $this->userService->getUser($userId);

        $this->authorize('show', [User::class, $user]);

        return response()->json(['data' => $user]);
    }

    /**
     * @throws AuthorizationException
     */
    public function deleteUser(int $userId): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $status = $this->userService->deleteUser($userId);

        return response()->json(['status' => $status]);
    }
}
