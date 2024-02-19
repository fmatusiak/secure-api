<?php

namespace App\Services;

use App\Models\Group;
use App\Models\User;
use App\Repositories\GroupRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class GroupService
{
    private GroupRepository $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function paginate(array $input): LengthAwarePaginator
    {
        return $this->groupRepository->paginate($input);
    }

    public function getGroup(int $id): Group
    {
        return $this->groupRepository->findOrFail($id);
    }

    public function createGroup(array $data): Group
    {
        return $this->groupRepository->create($data);
    }

    public function updateGroup(int $id, array $data): Group
    {
        return $this->groupRepository->update($id, $data);
    }

    public function deleteGroup(int $id): bool
    {
        return $this->groupRepository->delete($id);
    }

    public function getUserGroups(User $user, array $input): LengthAwarePaginator
    {
        return $this->groupRepository->getUserGroups($user, $input);
    }

    public function getUsersByGroup(Group $group, array $input): LengthAwarePaginator
    {
        return $this->groupRepository->getUsersByGroup($group, $input);
    }
}
