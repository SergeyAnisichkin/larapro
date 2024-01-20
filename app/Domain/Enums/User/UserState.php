<?php

declare(strict_types=1);

namespace App\Domain\Enums\User;

enum UserState: string
{
    case UNVERIFIED = 'UNVERIFIED';
    case VERIFIED = 'VERIFIED';
    case BANNED = 'BANNED';
}
