<?php

declare(strict_types=1);

namespace App\Domain\Entities\User;

use App\Domain\Enums\User\UserRole;

class User
{
    private string $name;
    private string $password;
    private array $roles;
    private int $id;

    public function __construct(
        private readonly string $email,
    ) {
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function addRole(UserRole $role): void
    {
        $this->roles[] = $role;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}