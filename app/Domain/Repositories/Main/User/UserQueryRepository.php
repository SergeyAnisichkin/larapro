<?php

namespace App\Domain\Repositories\Main\User;

use App\Models\User;

class UserQueryRepository
{
    public function findById(int $id): ?string
    {
        return '';
    }

    public function isExistingEmail(string $email): bool
    {
        return User::query()->where('email', $email)->exists();
    }
}