<?php

declare(strict_types=1);

namespace App\Domain\Validators\User;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Enums\User\UserAttribute;
use App\Domain\Repositories\Main\User\UserQueryRepository;
use App\Domain\Services\Common\TextMessageService;
use App\Domain\Services\Common\UuidService;

final class UserCreateValidator
{
    private array $messages = [];

    public function __construct(
        private readonly UserQueryRepository $userQueryRepository,
        private readonly TextMessageService $textService,
        private readonly UuidService $uuidService,
    ) {
    }

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
        $this->validateUuid($userDto);

        return empty($this->messages);
    }

    private function validateName(UserSignUpDto $userDto): void
    {
        $nameLength = strlen($userDto->name);

        if (
            $nameLength < UserAttribute::NAME->getMinLength()
            || $nameLength > UserAttribute::NAME->getMaxLength()
        ) {
            $this->messages[] = $this->textService->getText('validation.user.name_length');
        }
    }

    private function validateEmail(UserSignUpDto $userDto): void
    {
        $isValidEmail = (bool)filter_var($userDto->email, FILTER_VALIDATE_EMAIL);

        if (! $isValidEmail) {
            $this->messages[] = $this->textService->getText('validation.user.email_is_invalid');

            return;
        }

        if ($this->userQueryRepository->isExistingEmail($userDto->email)) {
            $this->messages[] = $this->textService->getText('validation.user.email_already_exists');

            return;
        }

        $emailLength = strlen($userDto->email);

        if (
            $emailLength < UserAttribute::EMAIL->getMinLength()
            || $emailLength > UserAttribute::EMAIL->getMaxLength()
        ) {
            $this->messages[] = $this->textService->getText('validation.user.email_length');
        }
    }

    private function validatePassword(UserSignUpDto $userDto): void
    {
        $passwordLength = strlen($userDto->password);

        if ($userDto->password !== $userDto->passwordConfirm) {
            $this->messages[] = $this->textService->getText('validation.user.password_confirm');
        }

        if (
            $passwordLength < UserAttribute::PASSWORD->getMinLength()
            || $passwordLength > UserAttribute::PASSWORD->getMaxLength()
        ) {
            $this->messages[] = $this->textService->getText('validation.user.password_length');
        }
    }

    private function validateUuid(UserSignUpDto $userDto): void
    {
        if (! $this->uuidService->isUuid($userDto->uuid)) {
            $this->messages[] = $this->textService->getText('validation.user.invalid_uuid');

            return;
        }

        if ($this->userQueryRepository->isExistingUuid($userDto->uuid)) {
            $this->messages[] = $this->textService->getText('validation.user.user_uuid_already_exists');
        }
    }
}