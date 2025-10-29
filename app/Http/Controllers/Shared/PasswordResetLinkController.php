<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function showForgotPassword(): View
    {
        return view('shared.forgot-password');
    }

    public function showVerifyCode(): View
    {
        return view('shared.verification-code');
    }
}
