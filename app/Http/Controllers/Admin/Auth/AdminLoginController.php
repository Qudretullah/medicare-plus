<?php

namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    // Admin login page show karega
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    // Admin email aur password check karega
    public function login(Request $request)
    {
        // Step 1: Input validation
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Step 2: Sirf admin ko login allow karna
        $adminEmail = config('admin.email');

        if (
            !$adminEmail ||
            strcasecmp($credentials['email'], $adminEmail) !== 0
        ) {
            throw ValidationException::withMessages([
                'email' => 'Invalid admin credentials.',
            ]);
        }

        // Step 3: Database mein credentials verify karna
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid admin credentials.',
            ]);
        }

        // Step 4: Login session secure karna
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    // Admin logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
