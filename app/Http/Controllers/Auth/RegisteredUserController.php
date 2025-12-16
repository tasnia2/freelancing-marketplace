<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            // Step 1: Validation
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', Rules\Password::defaults()], 
                'role' => ['required', 'in:freelancer,client'],
                'phone' => ['nullable', 'string', 'max:20'],
                'location' => ['nullable', 'string', 'max:255'],
                'bio' => ['nullable', 'string'],
                'profile_picture' => ['nullable', 'image', 'max:2048'],
            ]);

            // Step 2: Create user
            $avatarPath = null;
            if ($request->hasFile('profile_picture')) {
                $avatarPath = $request->file('profile_picture')->store('avatars', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'phone' => $request->phone,
                'location' => $request->location,
                'bio' => $request->bio,
                'avatar' => $avatarPath,
                'title' => $request->role === 'freelancer' ? 'New Freelancer' : null,
                'hourly_rate' => $request->role === 'freelancer' ? 25 : null,
                'company' => $request->role === 'client' ? ($request->company ?? 'My Company') : null,
            ]);

            // Step 3: Create wallet ONLY IF wallet table exists
            try {
                if (\Schema::hasTable('wallets')) {
                    $user->wallet()->create([
                        'balance' => 1000,
                        'currency' => 'USD',
                        'pending_balance' => 0
                    ]);
                }
            } catch (\Exception $e) {
                // Wallet creation failed, but continue
            }

            // Step 4: Create profile ONLY IF profiles table exists
            try {
                if (\Schema::hasTable('profiles')) {
                    $user->profile()->create([
                        'headline' => $request->role === 'freelancer' ? 'New Freelancer' : 'Business Owner',
                        'description' => $request->bio ?? 'Welcome to my profile!',
                        'skills' => $request->role === 'freelancer' ? json_encode(['Web Development', 'Laravel']) : null,
                    ]);
                }
            } catch (\Exception $e) {
                // Profile creation failed, but continue
            }

            // Step 5: Events and login
            event(new Registered($user));
            Auth::login($user);

            // FIXED: Redirect based on user role
            // In store() method, change the redirect to:
            //  if ($user->role === 'client') {
            //  return redirect()->route('client.dashboard');
            // } elseif ($user->role === 'freelancer') {
            //  return redirect()->route('freelancer.dashboard');
            //   }            
            // // Fallback to general dashboard (for admin roles or other cases)
            // return redirect()->route('dashboard');
            // Clear any remembered redirect
        $request->session()->forget('url.intended');
        event(new Registered($user));
        Auth::login($user);

        $request->session()->forget('url.intended');



         return redirect('/');

            
        } catch (\Exception $e) {
            // Show error to user
            return back()
                ->withErrors(['error' => 'Registration failed. Please try again.'])
                ->withInput();
        }
    }
}
