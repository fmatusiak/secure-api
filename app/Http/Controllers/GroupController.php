<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use App\Models\User;
use App\Services\GroupService;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    protected GroupService $groupService;
    protected UserService $userService;

    public function __construct(GroupService $groupService, UserService $userService)
    {
        $this->groupService = $groupService;
        $this->userService = $userService;
    }

    public function paginate(Request $request): JsonResponse
    {
        $data = $this->groupService->paginate($request->all());

        return response()->json($data);
    }

    /**
     * @throws AuthorizationException
     */
    public function createGroup(CreateGroupRequest $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $group = $this->groupService->createGroup($request->all());

        return response()->json(['data' => $group]);
    }

    /**
     * @throws AuthorizationException
     */
    public function updateGroup(int $id, UpdateGroupRequest $request): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $group = $this->groupService->updateGroup($id, $request->all());

        return response()->json(['data' => $group]);
    }

    /**
     * @throws AuthorizationException
     */
    public function deleteGroup(int $id): JsonResponse
    {
        $this->authorize('isAdmin', User::class);

        $status = $this->groupService->deleteGroup($id);

        return response()->json(['status' => $status]);
    }

    /**
     * @throws AuthorizationException
     */
    public function getUserGroups(int $userId, Request $request): JsonResponse
    {
        $user = $this->userService->getUser($userId);

        $this->authorize('show', [User::class, $user]);

        $data = $this->groupService->getUserGroups($user, $request->all());

        return response()->json($data);
    }

    /**
     * @throws AuthorizationException
     */
    public function getUsersByGroup(int $groupId, Request $request): JsonResponse
    {
        $group = $this->groupService->getGroup($groupId);

        $this->authorize('show', [Group::class, $group]);

        $data = $this->groupService->getUsersByGroup($group, $request->all());

        return response()->json($data);
    }

    /**
     * @throws AuthorizationException
     */
    public function getGroup(int $id): JsonResponse
    {
        $group = $this->groupService->getGroup($id);

        $this->authorize('show', [Group::class, $group]);

        return response()->json(['data' => $group]);
    }
}
