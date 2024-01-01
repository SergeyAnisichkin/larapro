<?php

declare(strict_types=1);

namespace App\Domain\Repositories\Main\Common;

use Ramsey\Uuid\Uuid;

final class UuidRepository
{
    public function getUuid(): string
    {
        return Uuid::uuid1()->toString();
    }

    public function isUuid(string $uuid): bool
    {
        return Uuid::isValid($uuid);
    }
}