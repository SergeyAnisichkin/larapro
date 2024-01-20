<?php

declare(strict_types=1);

namespace App\Domain\Services\User;

use App\Domain\Dto\User\SignUpPageData;
use App\Domain\Services\Common\UuidService;

final class UserAuthPageDataService
{
    public function __construct(
        private readonly UuidService $uuidService,
    ) {
    }

    public function getSignUpPageData(): SignUpPageData
    {
        return new SignUpPageData(
            $this->uuidService->getUuid(),
        );
    }
}