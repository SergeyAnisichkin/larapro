<?php

namespace App\Domain\Repositories\Main\User;

use App\Models\User;

class UserQueryRepository
{
    public function findById(int $id): ?User
    {
        return User::query()->find($id);
    }

    public function isExistingEmail(string $email): bool
    {
        return User::query()->where('email', $email)->exists();
    }

    public function isExistingUuid(string $uuid): bool
    {
        return User::query()->where('uuid', $uuid)->exists();
    }
}