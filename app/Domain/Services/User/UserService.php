<?php

declare(strict_types=1);

namespace App\Domain\Services\User;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Entities\User\UserFactory;
use App\Domain\Repositories\Main\User\UserCommandRepository;

final class UserService
{
    public function __construct(
        private readonly UserCommandRepository $userCommandRepository,
    ) {
    }

    public function create(UserSignUpDto $userDto): int
    {
        $user = UserFactory::getFromSignUpDto($userDto);

        return $this->userCommandRepository->create($user);
    }
}