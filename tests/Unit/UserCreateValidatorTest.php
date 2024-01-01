<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Repositories\Main\User\UserQueryRepository;
use App\Domain\Services\Common\TextMessageService;
use App\Domain\Services\Common\UuidService;
use App\Domain\Validators\User\UserCreateValidator;
use Mockery;
use Tests\AbstractUnitTestCase;

class UserCreateValidatorTest extends AbstractUnitTestCase
{
    private TextMessageService $messageService;
    private UserCreateValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $queryMock = Mockery::mock(UserQueryRepository::class)
            ->shouldReceive('isExistingEmail')
            ->withAnyArgs()
            ->andReturnFalse()
            ->getMock();

        $this->messageService = app(TextMessageService::class);
        $uuidService = app(UuidService::class);
        $this->validator = new UserCreateValidator($queryMock, $this->messageService, $uuidService);
    }

    /**
     * @dataProvider userDataProvider
     */
    public function testUserDtoValidate(array $userData, bool $isSuccessValidate, string $messageKey): void
    {
        $this->assertEmpty($this->validator->getErrorMessage());

        $userDto = UserSignUpDto::fromArray($userData);

        $this->assertSame($isSuccessValidate, $this->validator->validate($userDto));

        if (! $isSuccessValidate) {
            $errorMessage = $this->messageService->getText($messageKey);
            $this->assertSame($errorMessage, $this->validator->getErrorMessage());
        }
    }

    private function userDataProvider(): array
    {
        return [
            [
                'data' => [
                    'name' => 'test name',
                    'email' => '123@test.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                    'uuid' => '63db0062-a80a-11eb-a4c0-3aaa5fd72a6b',
                ],
                'isSuccessValidate' => true,
                'messageKey' => '',
            ],
            [
                'data' => [
                    'name' => 'n',
                    'email' => '123@test.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                ],
                'isSuccessValidate' => false,
                'messageKey' => 'validation.user.name_length',
            ],
            [
                'data' => [
                    'name' => 'test name',
                    'email' => '123est.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                ],
                'isSuccessValidate' => false,
                'messageKey' => 'validation.user.email_is_invalid',
            ],
            [
                'data' => [
                    'name' => 'test name',
                    'email' => '123@test.com',
                    'password' => '123456',
                    'password_confirmation' => '123456',
                ],
                'isSuccessValidate' => false,
                'messageKey' => 'validation.user.password_length',
            ],
            [
                'data' => [
                    'name' => 'test name',
                    'email' => '123@test.com',
                    'password' => '12345678',
                    'password_confirmation' => '123',
                ],
                'isSuccessValidate' => false,
                'messageKey' => 'validation.user.password_confirm',
            ],
            [
                'data' => [
                    'name' => 'test name',
                    'email' => '123@test.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                    'uuid' => 'ddff44',
                ],
                'isSuccessValidate' => false,
                'messageKey' => 'validation.user.invalid_uuid',
            ],
        ];
    }
}
