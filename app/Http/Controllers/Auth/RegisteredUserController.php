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
        \Log::info('=== REGISTRATION START ===');
        
        // Step 1: Validation
        \Log::info('Step 1: Validating...');
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
        \Log::info('Step 1: Validation PASSED');
        
        // Step 2: Create user
        \Log::info('Step 2: Creating user...');
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
        \Log::info('Step 2: User created - ID: ' . $user->id);
        
        // Step 3: Create wallet (COMMENT OUT TEMPORARILY)
        \Log::info('Step 3: Skipping wallet creation for now...');
        /*
        $user->wallet()->create([
            'balance' => 1000,
            'currency' => 'USD',
            'pending_balance' => 0
        ]);
        \Log::info('Step 3: Wallet created');
        */
        
        // Step 4: Create profile (COMMENT OUT TEMPORARILY)
        \Log::info('Step 4: Skipping profile creation for now...');
        /*
        $user->profile()->create([
            'headline' => $request->role === 'freelancer' ? 'New Freelancer' : 'Business Owner',
            'description' => $request->bio ?? 'Welcome to my profile!',
            'skills' => $request->role === 'freelancer' ? json_encode(['Web Development', 'Laravel']) : null,
        ]);
        \Log::info('Step 4: Profile created');
        */
        
        // Step 5: Events and login
        \Log::info('Step 5: Firing event and logging in...');
        event(new Registered($user));
        Auth::login($user);
        \Log::info('Step 5: User logged in');
        
        \Log::info('=== REGISTRATION SUCCESS ===');
        
        return redirect(route('dashboard', absolute: false));
        
    } catch (\Exception $e) {
        \Log::error('Registration failed: ' . $e->getMessage());
        \Log::error('Error at: ' . $e->getFile() . ':' . $e->getLine());
        \Log::error('Trace: ' . $e->getTraceAsString());
        
        // Show error to user
        return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
    }
}
}
