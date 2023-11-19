<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Repositories\Main\User\UserQueryRepository;
use App\Domain\Services\Common\TextMessageService;
use App\Domain\Validators\User\UserCreateValidator;
use Mockery;
use Tests\AbstractUnitTestCase;

class UserCreateValidatorTest extends AbstractUnitTestCase
{
    private UserCreateValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $queryMock = Mockery::mock(UserQueryRepository::class)
            ->shouldReceive('isExistingEmail')
            ->withAnyArgs()
            ->andReturnFalse()
            ->getMock();
        $textMock = Mockery::mock(TextMessageService::class)
            ->shouldReceive('getText')
            ->withAnyArgs()
            ->andReturn('test')
            ->getMock();

        $this->validator = new UserCreateValidator($queryMock, $textMock);


    }

    /**
     * @dataProvider userDataProvider
     */
    public function testUserDtoValidate(array $userData, bool $isSuccessValidate): void
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
