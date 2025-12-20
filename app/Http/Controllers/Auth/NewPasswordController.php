<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request)
    {
        // If coming from forgot password, use session token
        $token = $request->route('token');
        $email = $request->email ?: session('password_reset_email');
        
        return view('auth.reset-password', [
            'request' => $request,
            'token' => $token,
            'email' => $email
        ]);
    }

    /**
     * Handle an incoming new password request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // For demo: Accept ANY token (no validation)
        // In real app, you would validate the token
        
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user) {
            // If user doesn't exist, create a demo one
            $user = new \App\Models\User();
            $user->email = $request->email;
            $user->name = 'Demo User';
        }

        // Update or set password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear session
        session()->forget(['password_reset_token', 'password_reset_email']);

        return redirect()->route('login')
            ->with('status', 'Password reset successfully! You can now login.');
    }
}