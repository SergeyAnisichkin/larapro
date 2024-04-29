<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Entities\User\UserFactory;
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
    private UuidService $uuidService;
    private UserFactory $userFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $userQueryMock = Mockery::mock(UserQueryRepository::class)
            ->shouldReceive('isExistingEmail', 'isExistingUuid')
            ->withAnyArgs()
            ->andReturnFalse()
            ->getMock();

        $this->messageService = app(TextMessageService::class);
        $this->uuidService = app(UuidService::class);
        $this->validator = new UserCreateValidator($userQueryMock, $this->messageService, $this->uuidService);
        $this->userFactory = app(UserFactory::class);
    }

    /**
     * @dataProvider userValidateDataProvider
     */
    public function testUserDtoValidate(array $userData, bool $isValid, string $messageKey): void
    {
        $this->assertEmpty($this->validator->getErrorMessage());
        $userDto = UserSignUpDto::fromArray($userData);

        $this->assertSame($isValid, $this->validator->validate($userDto));

        if (! $isValid) {
            $errorMessage = $this->messageService->getText($messageKey);
            $this->assertSame($errorMessage, $this->validator->getErrorMessage());
        }
    }

    /**
     * @dataProvider userCreateDataProvider
     */
    public function testCreateUserFromDto(array $userData): void
    {
        $userDto = UserSignUpDto::fromArray($userData);

        $user = $this->userFactory->getFromSignUpDto($userDto);

        $this->assertSame($userData['uuid'], $user->getUuid());
        $this->assertSame($userData['email'], $user->getEmail());
    }

    private function userCreateDataProvider(): array
    {
        return [
            [
                'data' => [
                    'name' => 'test name',
                    'email' => '123@test.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                    'uuid' => '1434111c-f8c2-4542-a8ef-996e097223a8',
                ],
            ],
            [
                'data' => [
                    'name' => 'test name more...',
                    'email' => 'testMore@test.com',
                    'password' => '1234567890',
                    'password_confirmation' => '1234567890',
                    'uuid' => '1fcda82f-8044-4875-b573-3f1ba0d2dde0',
                ],
            ],
        ];
    }

    private function userValidateDataProvider(): array
    {
        return [
            [
                'data' => [
                    'name' => 'test name',
                    'email' => '123@test.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                    'uuid' => '1434111c-f8c2-4542-a8ef-996e097223a8',
                ],
                'isValid' => true,
                'messageKey' => '',
            ],
            [
                'data' => [
                    'name' => 'n',
                    'email' => '123@test.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                    'uuid' => '66a91358-3837-461a-93f7-81f2a5c7f845',
                ],
                'isValid' => false,
                'messageKey' => 'validation.user.name_length',
            ],
            [
                'data' => [
                    'name' => 'test name',
                    'email' => '123est.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                    'uuid' => '1434111c-f8c2-4542-a8ef-996e097223a8',
                ],
                'isValid' => false,
                'messageKey' => 'validation.user.email_is_invalid',
            ],
            [
                'data' => [
                    'name' => 'test name',
                    'email' => '123@test.com',
                    'password' => '123456',
                    'password_confirmation' => '123456',
                    'uuid' => '1434111c-f8c2-4542-a8ef-996e097223a8',
                ],
                'isValid' => false,
                'messageKey' => 'validation.user.password_length',
            ],
            [
                'data' => [
                    'name' => 'test name',
                    'email' => '123@test.com',
                    'password' => '12345678',
                    'password_confirmation' => '123',
                    'uuid' => '1434111c-f8c2-4542-a8ef-996e097223a8',
                ],
                'isValid' => false,
                'messageKey' => 'validation.user.password_confirm',
            ],
            [
                'data' => [
                    'name' => 'test name',
                    'email' => '123@test.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                    'uuid' => 'f4f8f1fef50',
                ],
                'isValid' => false,
                'messageKey' => 'validation.user.invalid_uuid',
            ],
        ];
    }
}
