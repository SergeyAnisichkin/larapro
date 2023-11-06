<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function getSignUpPage(): View
    {
        return view('auth.register');
    }
}
