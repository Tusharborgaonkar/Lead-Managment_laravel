<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        // For static UI, always redirect to dashboard
        return redirect()->route('dashboard');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        return redirect()->route('login');
    }
}
