<?php

namespace App\Http\Controllers;

use App\Domain\Dto\User\UserSignUpDto;
use App\Domain\Validators\User\UserCreateValidator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private readonly UserCreateValidator $userCreateValidator)
    {
    }

    public function getSignUpPage(): View
    {
        return view('auth-sign.sign-up');
    }

    public function signUpUser(Request $request): View|RedirectResponse
    {
        $userDto = UserSignUpDto::fromArray($request->all());

        $isSuccessValidation = $this->userCreateValidator->validate($userDto);

        if ($isSuccessValidation) {
            return view('auth-sign.sign-up');
        }

        return redirect()->back()
            ->with('error', $this->userCreateValidator->getErrorMessage())
            ->withInput();
    }
}
