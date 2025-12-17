<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $user->load('profile');
        
        if ($user->role === 'freelancer') {
            return view('dashboard.freelancer.profile-edit', compact('user'));
        }
        
        return view('dashboard.client.profile-edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'company' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'location' => ['nullable', 'string', 'max:255'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'website' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'github' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['string', 'max:50'],
        ]);
        
        // Update user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $user->phone,
            'company' => $validated['company'] ?? $user->company,
            'title' => $validated['title'] ?? $user->title,
            'bio' => $validated['bio'] ?? $user->bio,
            'location' => $validated['location'] ?? $user->location,
            'hourly_rate' => $validated['hourly_rate'] ?? $user->hourly_rate,
        ]);
        
        // Update or create profile
        $profileData = [
            'headline' => $validated['title'] ?? $user->title,
            'description' => $validated['bio'] ?? $user->bio,
            'skills' => $validated['skills'] ?? [],
            'website' => $validated['website'] ?? null,
            'linkedin' => $validated['linkedin'] ?? null,
            'github' => $validated['github'] ?? null,
            'twitter' => $validated['twitter'] ?? null,
        ];
        
        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }
        
        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully!');
    }
    
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $user = Auth::user();
        
        // Delete old avatar if exists
        if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
            Storage::delete('public/' . $user->avatar);
        }
        
        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);
        
        return response()->json([
            'success' => true,
            'avatar_url' => Storage::url($path)
        ]);
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->back()->with('success', 'Password updated successfully!');
    }
    
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);
        
        $user = $request->user();
        
        Auth::logout();
        
        $user->delete();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Your account has been permanently deleted.');
    }
    
    public function freelancerEdit()
    {
        $user = Auth::user();
        $user->load('profile');
        
        return view('dashboard.freelancer.profile-edit', compact('user'));
    }
    public function show()
{
    $user = Auth::user();
    
    if ($user->role === 'freelancer') {
        return view('dashboard.freelancer.profile-show', compact('user'));
    }
    
    return view('profile.show', compact('user'));
}
}
