<?php

declare(strict_types=1);

namespace App\Domain\Dto\User;


final class SignUpPageData
{
    public function __construct(
        public readonly string $uuid,
    ) {
    }
}