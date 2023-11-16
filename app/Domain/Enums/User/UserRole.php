<?php

declare(strict_types=1);

namespace App\Domain\Enums\User;

enum UserRole: string
{
    case ADMIN = 'name';
    case USER = 'user';
    case DISABLED = 'disabled';
}
