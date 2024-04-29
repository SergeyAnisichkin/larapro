<?php

declare(strict_types=1);

namespace App\Domain\Services\User;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Entities\User\UserFactory;
use App\Domain\Events\User\UserCreated;
use App\Domain\Repositories\Main\User\UserCommandRepository;

final class UserService
{
    public function __construct(
        private readonly UserCommandRepository $userCommandRepository,
        private readonly UserFactory $userFactory,
    ) {
    }

    public function create(UserSignUpDto $userDto): int
    {
        $user = $this->userFactory->getFromSignUpDto($userDto);
        $userId = $this->userCommandRepository->create($user);

        $userCreatedEvent = new UserCreated($user);
        $user->addEvent($userCreatedEvent);
        // todo add dispatcher events for aggregate

        return $userId;
    }
}