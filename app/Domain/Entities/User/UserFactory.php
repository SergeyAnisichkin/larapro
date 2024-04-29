<?php

declare(strict_types=1);

namespace App\Domain\Entities\User;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Enums\User\UserRole;
use App\Domain\Enums\User\UserState;

class UserFactory
{
    public function getFromSignUpDto(UserSignUpDto $dto): User
    {
        $user = new User($dto->email, $dto->uuid);
        $user->setName($dto->name);
        $user->setPassword($dto->password);
        $user->addRole(UserRole::USER);
        $user->setState(UserState::UNVERIFIED);

        return $user;
    }
}
