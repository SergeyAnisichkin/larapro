<?php

declare(strict_types=1);

namespace App\Domain\Repositories\Main\Common;

final class TextRepository
{
    public function findByKey(string $key): string
    {
        return __($key) ?? '';
    }
}