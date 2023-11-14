<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function getSignUpPage(): View
    {
        return view('auth-sign.sign-up');
    }

    public function signUpUser(Request $request): View
    {
        dd($request);
        return view('auth-sign.sign-up');
    }
}
