<?php

declare(strict_types=1);

namespace App\Domain\Entities\User;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Enums\User\UserRole;

class UserFactory
{
    public static function getFromSignUpDto(UserSignUpDto $dto): User
    {
        $user = new User($dto->email);
        $user->setName($dto->name);
        $user->setPassword($dto->password);
        $user->addRole(UserRole::USER);

        return $user;
    }
}
