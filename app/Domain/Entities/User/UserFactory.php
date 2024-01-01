<?php

declare(strict_types=1);

namespace App\Domain\Entities\User;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Enums\User\UserRole;
use App\Domain\Enums\User\UserState;
use App\Domain\Services\Common\UuidService;

class UserFactory
{
    public function __construct(
        private readonly UuidService $uuidService,
    ) {
    }

    public function getFromSignUpDto(UserSignUpDto $dto): User
    {
        $uuid = empty($dto->uuid) ? $this->uuidService->getUuid() : $dto->uuid;

        $user = new User($dto->email, $uuid);
        $user->setName($dto->name);
        $user->setPassword($dto->password);
        $user->addRole(UserRole::USER);
        $user->setState(UserState::UN_VERIFIED);

        return $user;
    }
}
