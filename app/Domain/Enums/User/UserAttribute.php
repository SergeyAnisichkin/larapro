<?php

declare(strict_types=1);

namespace App\Domain\Enums\User;

enum UserAttribute: string
{
    case NAME = 'name';
    case EMAIL = 'email';
    case PASSWORD = 'password';
    case PASSWORD_CONFIRMATION = 'password_confirmation';
    case UUID = 'uuid';
    case STATE = 'state';

    public function getMinLength(): int
    {
        return match ($this) {
            self::EMAIL => 6,
            self::PASSWORD => 8,
            default => 3,
        };
    }

    public function getMaxLength(): int
    {
        return 120;
    }
}
