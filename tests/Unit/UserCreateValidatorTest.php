<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Validators\User\UserCreateValidator;
use PHPUnit\Framework\TestCase;

class UserCreateValidatorTest extends TestCase
{
    private UserCreateValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = app(UserCreateValidator::class);
    }

    /**
     * @dataProvider userDataProvider
     */
    public function testSuccessValidate(array $userData, bool $isSuccessValidate): void
    {
        $this->assertEmpty($this->validator->getErrorMessage());

        $userDto = UserSignUpDto::fromArray($userData);

        $this->assertSame($isSuccessValidate, $this->validator->validate($userDto));

    }

    private function userDataProvider(): array
    {
        return [
            [
                'data' => [
                    'name' => '',
                    'email' => '123@test.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',

                ],
                'isSuccessValidate' => false,
            ],

        ];
    }
}
