<?php

declare(strict_types=1);

namespace App\Domain\Validators\User;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Enums\User\UserAttribute;

class UserCreateValidator
{
    private array $messages = [];

    public function getErrorMessage(): string
    {
        $result = implode($this->messages);
        $this->messages = [];

        return $result;
    }

    public function validate(UserSignUpDto $userDto): bool
    {
        $this->validateName($userDto);
        $this->validateEmail($userDto);
        $this->validatePassword($userDto);

        return empty($this->messages);
    }

    private function validateName(UserSignUpDto $userDto): void
    {
        $nameLength = strlen($userDto->name);

        if ($nameLength < UserAttribute::NAME->getMinLength()) {
            $this->messages[] = __('validation.user.name_length');

            return;
        }

        if ($nameLength > UserAttribute::NAME->getMaxLength()) {
            $this->messages[] = __('validation.user.name_length');
        }
    }

    private function validateEmail(UserSignUpDto $userDto): void
    {
        $isValidEmail = (bool)filter_var($userDto->email, FILTER_VALIDATE_EMAIL);

        if (! $isValidEmail) {
            $this->messages[] = __('validation.user.email_is_invalid');
        }

        $emailLength = strlen($userDto->email);

        if ($emailLength < UserAttribute::EMAIL->getMinLength()) {
            $this->messages[] = __('validation.user.email_length');

            return;
        }

        if ($emailLength > UserAttribute::EMAIL->getMaxLength()) {
            $this->messages[] = __('validation.user.email_length');
        }
    }

    private function validatePassword(UserSignUpDto $userDto): void
    {
        $passwordLength = strlen($userDto->password);

        if ($passwordLength < UserAttribute::PASSWORD->getMinLength()) {
            $this->messages[] = __('validation.user.password_length');

            return;
        }

        if ($passwordLength > UserAttribute::PASSWORD->getMaxLength()) {
            $this->messages[] = __('validation.user.password_length');
        }
    }
}