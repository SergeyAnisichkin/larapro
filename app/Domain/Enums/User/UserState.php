<?php

declare(strict_types=1);

namespace App\Domain\Enums\User;

enum UserState: string
{
    case UN_VERIFIED = 'UN_VERIFIED';
    case VERIFIED = 'VERIFIED';
    case BANNED = 'BANNED';
}
