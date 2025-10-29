<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function showAlumniLogin(): View
    {
        return view('alumni.login');
    }

    public function showAdminLogin(): View
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $isAdminLogin = $request->is('admin/*');
        $expectedRole = $isAdminLogin ? 'admin' : 'alumni';

        if (Auth::attempt(array_merge($credentials, ['role' => $expectedRole]))) {
            $request->session()->regenerate();

            return $isAdminLogin
                ? redirect()->route('admin.dashboard')
                : redirect()->route('alumni.home');
        }

        return back()->withErrors(['email' => "Invalid {$expectedRole} credentials"]);
    }

    public function logout(Request $request)
    {
        $role = optional(Auth::user())->role;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return match ($role) {
            'admin' => redirect()->route('admin.login'),
            'alumni' => redirect()->route('alumni.login'),
            default => redirect('/'),
        };
    }
}
