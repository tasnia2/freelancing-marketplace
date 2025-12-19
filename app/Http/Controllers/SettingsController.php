<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isFreelancer()) {
            return view('settings.freelancer.index', compact('user'));
        }
        
        return view('settings.client.index', compact('user'));
    }
    
    public function loadTab($tab)
    {
        $user = Auth::user();
        
        if (request()->ajax()) {
            if ($user->isFreelancer()) {
                return $this->loadFreelancerTab($tab, $user);
            } else {
                return $this->loadClientTab($tab, $user);
            }
        }
        
        abort(404);
    }
    
    private function loadFreelancerTab($tab, $user)
    {
        $view = "settings.freelancer.tabs.{$tab}";
        
        if (!view()->exists($view)) {
            return '<div class="text-center py-8 text-gray-500">Tab not found</div>';
        }
        
        return view($view, compact('user'))->render();
    }
    
    private function loadClientTab($tab, $user)
    {
        $view = "settings.client.tabs.{$tab}";
        
        if (!view()->exists($view)) {
            return '<div class="text-center py-8 text-gray-500">Tab not found</div>';
        }
        
        return view($view, compact('user'))->render();
    }
    
    public function updateAccount(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'language' => 'nullable|string|in:en,es,fr,de',
            'timezone' => 'nullable|timezone',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        $user->update($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Account settings updated successfully',
            'data' => $validator->validated()
        ]);
    }
    
    public function updateFreelancerProfile(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isFreelancer()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'hourly_rate' => 'nullable|numeric|min:0',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
            'bio' => 'nullable|string|max:1000',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }
        
        $user->update([
            'title' => $request->title,
            'hourly_rate' => $request->hourly_rate,
            'bio' => $request->bio,
        ]);
        
        // Update profile skills
        if ($user->profile) {
            $user->profile->update(['skills' => $request->skills]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully'
        ]);
    }
    
    public function updateClientCompany(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isClient()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        
        $validator = Validator::make($request->all(), [
            'company' => 'required|string|max:255',
            'company_size' => 'nullable|in:1-10,11-50,51-200,201-500,501-1000,1000+',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'tax_id' => 'nullable|string|max:50',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }
        
        $user->update($validator->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Company profile updated successfully'
        ]);
    }
    
    public function updateAvailability(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isFreelancer()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        
        $validator = Validator::make($request->all(), [
            'availability_status' => 'required|in:available,busy,unavailable',
            'weekly_hours' => 'nullable|integer|min:1|max:168',
            'response_time_hours' => 'nullable|integer|min:1|max:168',
            'min_rate' => 'nullable|numeric|min:0',
            'max_rate' => 'nullable|numeric|min:0|gt:min_rate',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }
        
        // Store in user meta or separate table
        $user->meta()->updateOrCreate(
            ['key' => 'availability_settings'],
            ['value' => json_encode($validator->validated())]
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Availability settings updated'
        ]);
    }
    
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'email_job_alerts' => 'boolean',
            'email_proposal_updates' => 'boolean',
            'email_messages' => 'boolean',
            'email_payments' => 'boolean',
            'push_notifications' => 'boolean',
            'sms_important' => 'boolean',
            'notification_frequency' => 'in:instant,daily,weekly',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }
        
        $user->meta()->updateOrCreate(
            ['key' => 'notification_settings'],
            ['value' => json_encode($validator->validated())]
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Notification preferences updated'
        ]);
    }
    
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }
        
        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully'
        ]);
    }
    
    public function deleteAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|current_password',
            'confirmation' => 'required|in:DELETE',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }
        
        $user = $request->user();
        Auth::logout();
        $user->delete();
        
        return response()->json([
            'success' => true,
            'redirect' => url('/')
        ]);
    }
}