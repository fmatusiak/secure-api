<?php

namespace App\Dtos;

use App\Models\User;

class UserDto
{
    private int $id;
    private string $login;
    private ?string $email;
    private ?string $firstName;
    private ?string $lastName;
    private bool $isAdmin;

    public function __construct(User $user)
    {
        $this->setUserDto($user);
    }

    private function setUserDto(User $user): void
    {
        $this->setId($user->id);
        $this->setLogin($user->login);
        $this->setFirstName($user->first_name);
        $this->setLastName($user->last_name);
        $this->setIsAdmin($user->is_admin);
        $this->setEmail($user->email);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'login' => $this->getLogin(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'is_admin' => $this->isAdmin(),
            'email' => $this->getEmail(),
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }


}
