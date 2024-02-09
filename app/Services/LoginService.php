<?php

namespace App\Services;

use App\Dtos\UserDto;
use App\Exceptions\InvalidLoginException;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws InvalidLoginException
     */
    public function login(string $login, string $password): array
    {
        if (Auth::attempt(['login' => $login, 'password' => $password])) {
            $userId = Auth::id();

            $userLogged = $this->userRepository->findOrFail($userId);

            $token = $userLogged->createToken('token-name')->plainTextToken;

            $userDto = new UserDto($userLogged);

            $userDtoArray = $userDto->toArray();

            return ['user' => $userDtoArray, 'token' => $token];
        }

        throw new InvalidLoginException();
    }
}
