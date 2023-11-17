<?php

declare(strict_types=1);

namespace App\Domain\Dto\User;

use App\Domain\Enums\User\UserAttribute;

final class UserSignUpDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $passwordConfirm,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data[UserAttribute::NAME->value] ?? '',
                $data[UserAttribute::EMAIL->value] ?? '',
                $data[UserAttribute::PASSWORD->value] ?? '',
                $data[UserAttribute::PASSWORD_CONFIRMATION->value] ?? '',
        );
    }
}