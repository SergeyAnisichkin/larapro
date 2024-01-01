<?php

declare(strict_types=1);

namespace App\Domain\Services\Common;

use App\Domain\Repositories\Main\Common\UuidRepository;

class UuidService
{
    public function __construct(
        private readonly UuidRepository $uuidRepository,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuidRepository->getUuid();
    }

    public function isUuid($uuid): bool
    {
        return $this->uuidRepository->isUuid($uuid);
    }
}