<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Services\User\UserAuthPageDataService;
use App\Domain\Services\User\UserService;
use App\Domain\Validators\User\UserCreateValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserCreateValidator $userCreateValidator,
        private readonly UserService $userService,
        private readonly UserAuthPageDataService $authPageDataService,
    ) {
    }

    public function getSignUpPage(): View
    {
        $data = $this->authPageDataService->getSignUpPageData();

        return view('auth-sign.sign-up', ['data' => $data]);
    }

    public function signUpUser(Request $request): View|RedirectResponse
    {
        $userDto = UserSignUpDto::fromArray($request->all());
        $isValid = $this->userCreateValidator->validate($userDto);

        if ($isValid) {
            $userId = $this->userService->create($userDto);
            Auth::loginUsingId($userId);

            return view('shop.user.index');
        }

        return redirect()->back()
            ->with('error', $this->userCreateValidator->getErrorMessage())
            ->withInput();
    }
}
