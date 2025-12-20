<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Generate a simple token
        $token = 'reset-' . time() . '-' . rand(1000, 9999);
        
        // Redirect directly to reset page with token in URL
        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $request->email
        ]);
    }
}