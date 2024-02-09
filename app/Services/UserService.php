<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function paginate(array $input): LengthAwarePaginator
    {
        return $this->userRepository->paginate($input);
    }

    public function createUser(array $input): User
    {
        return $this->userRepository->create($input);
    }

    public function updateUser(int $id, array $data): User
    {
        return $this->userRepository->update($id, $data);
    }

    public function getUser(int $id): User
    {
        return $this->userRepository->findOrFail($id);
    }

    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
}
