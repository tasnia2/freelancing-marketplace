@extends('layouts.client')
@section('title', 'Settings')
    @section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    Settings
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Manage your account and preferences
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="saveAllSettings()"
                        class="px-4 py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 flex items-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Save All Changes</span>
                </button>
            </div>
        </div>
    @endsection
    
    @section('content')

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Settings Navigation -->
            <div class="mb-8">
                <div class="flex space-x-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl">
                    <button onclick="showTab('profile')" 
                            id="tabProfile"
                            class="flex-1 px-4 py-3 rounded-lg font-medium transition-all duration-300 settings-tab active">
                        <i class="fas fa-user mr-2"></i>Profile
                    </button>
                    <button onclick="showTab('security')" 
                            id="tabSecurity"
                            class="flex-1 px-4 py-3 rounded-lg font-medium transition-all duration-300 settings-tab">
                        <i class="fas fa-shield-alt mr-2"></i>Security
                    </button>
                    <button onclick="showTab('notifications')" 
                            id="tabNotifications"
                            class="flex-1 px-4 py-3 rounded-lg font-medium transition-all duration-300 settings-tab">
                        <i class="fas fa-bell mr-2"></i>Notifications
                    </button>
                    <button onclick="showTab('billing')" 
                            id="tabBilling"
                            class="flex-1 px-4 py-3 rounded-lg font-medium transition-all duration-300 settings-tab">
                        <i class="fas fa-credit-card mr-2"></i>Billing
                    </button>
                    <button onclick="showTab('preferences')" 
                            id="tabPreferences"
                            class="flex-1 px-4 py-3 rounded-lg font-medium transition-all duration-300 settings-tab">
                        <i class="fas fa-cog mr-2"></i>Preferences
                    </button>
                </div>
            </div>

            <!-- Profile Tab -->
            <div id="tabContentProfile" class="settings-tab-content active">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Profile Information -->
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                                <i class="fas fa-user-circle text-[#1B3C53] mr-2"></i>
                                Profile Information
                            </h3>
                            
                            <form id="profileForm" class="space-y-6">
                                @csrf
                                @method('PUT')
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Full Name *
                                        </label>
                                        <input type="text" 
                                               name="name" 
                                               value="{{ auth()->user()->name }}"
                                               required
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email Address *
                                        </label>
                                        <input type="email" 
                                               name="email" 
                                               value="{{ auth()->user()->email }}"
                                               required
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Company Name
                                    </label>
                                    <input type="text" 
                                           name="company" 
                                           value="{{ auth()->user()->company }}"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                           placeholder="Your company or organization">
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Phone Number
                                        </label>
                                        <input type="tel" 
                                               name="phone" 
                                               value="{{ auth()->user()->phone }}"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Location
                                        </label>
                                        <input type="text" 
                                               name="location" 
                                               value="{{ auth()->user()->location }}"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                               placeholder="City, Country">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Bio / About
                                    </label>
                                    <textarea name="bio" 
                                              rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                              placeholder="Tell us about yourself and your business...">{{ auth()->user()->bio }}</textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Website
                                    </label>
                                    <input type="url" 
                                           name="website" 
                                           value="{{ auth()->user()->profile->website ?? '' }}"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                           placeholder="https://example.com">
                                </div>
                                
                                <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <button type="button" 
                                            onclick="saveProfile()"
                                            class="px-6 py-3 bg-[#234C6A] text-white rounded-lg hover:bg-[#1B3C53] transition-colors font-medium">
                                        <i class="fas fa-save mr-2"></i>Save Profile
                                    </button>
                                    <div id="profileSaveStatus" class="inline-block ml-4"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Profile Picture & Stats -->
                    <div class="space-y-8">
                        <!-- Profile Picture -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Profile Picture</h3>
                            <div class="text-center">
                                <div class="relative inline-block">
                                    <div class="w-32 h-32 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white text-4xl font-bold mb-4 mx-auto">
                                        @if(auth()->user()->avatar)
                                            <img src="{{ auth()->user()->getAvatarUrl() }}" 
                                                 alt="{{ auth()->user()->name }}"
                                                 class="w-full h-full rounded-full object-cover">
                                        @else
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <button onclick="document.getElementById('avatarInput').click()"
                                            class="absolute bottom-2 right-2 w-10 h-10 bg-white dark:bg-gray-700 rounded-full shadow-lg flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-camera text-gray-600 dark:text-gray-400"></i>
                                    </button>
                                    <input type="file" 
                                           id="avatarInput"
                                           class="hidden"
                                           accept="image/*"
                                           onchange="uploadAvatar(this)">
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    Click the camera icon to upload a new photo
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    JPG, PNG up to 2MB
                                </p>
                            </div>
                        </div>
                        
                        <!-- Profile Completeness -->
                        <div class="bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-2xl p-6 text-white">
                            <h3 class="font-semibold mb-4">Profile Completeness</h3>
                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span>{{ auth()->user()->getProfileCompletenessPercentageRoleBased() }}% Complete</span>
                                    <span>{{ auth()->user()->isProfileCompleteRoleBased() ? 'Complete' : 'Incomplete' }}</span>
                                </div>
                                <div class="w-full bg-white/20 rounded-full h-2">
                                    <div class="bg-white h-2 rounded-full" 
                                         style="width: '{{ auth()->user()->getProfileCompletenessPercentageRoleBased() }}%'"></div>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span>Basic Info</span>
                                    <span class="{{ auth()->user()->name && auth()->user()->email ? 'text-green-300' : 'text-red-300' }}">
                                        {{ auth()->user()->name && auth()->user()->email ? '✓' : '✗' }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Company</span>
                                    <span class="{{ auth()->user()->company ? 'text-green-300' : 'text-red-300' }}">
                                        {{ auth()->user()->company ? '✓' : '✗' }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Location</span>
                                    <span class="{{ auth()->user()->location ? 'text-green-300' : 'text-red-300' }}">
                                        {{ auth()->user()->location ? '✓' : '✗' }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Bio</span>
                                    <span class="{{ auth()->user()->bio ? 'text-green-300' : 'text-red-300' }}">
                                        {{ auth()->user()->bio ? '✓' : '✗' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Account Stats -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Account Stats</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-600 dark:text-gray-400">Member Since</span>
                                    <span class="font-medium text-gray-800 dark:text-white">
                                        {{ auth()->user()->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-600 dark:text-gray-400">Total Jobs Posted</span>
                                    <span class="font-medium text-gray-800 dark:text-white">
                                        {{ auth()->user()->jobsPosted()->count() }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-600 dark:text-gray-400">Active Contracts</span>
                                    <span class="font-medium text-gray-800 dark:text-white">
                                        {{ auth()->user()->contracts()->where('status', 'active')->count() }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-600 dark:text-gray-400">Account Status</span>
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Verified
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Tab -->
            <div id="tabContentSecurity" class="settings-tab-content hidden">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-shield-alt text-[#234C6A] mr-2"></i>
                        Security Settings
                    </h3>
                    
                    <div class="space-y-8">
                        <!-- Password Change -->
                        <div>
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Change Password</h4>
                            <form id="passwordForm" class="space-y-4">
                                @csrf
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Current Password *
                                    </label>
                                    <input type="password" 
                                           name="current_password"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            New Password *
                                        </label>
                                        <input type="password" 
                                               name="password"
                                               required
                                               minlength="8"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Confirm New Password *
                                        </label>
                                        <input type="password" 
                                               name="password_confirmation"
                                               required
                                               minlength="8"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                    </div>
                                </div>
                                
                                <div class="pt-4">
                                    <button type="button" 
                                            onclick="changePassword()"
                                            class="px-6 py-3 bg-[#234C6A] text-white rounded-lg hover:bg-[#1B3C53] transition-colors font-medium">
                                        <i class="fas fa-key mr-2"></i>Change Password
                                    </button>
                                    <div id="passwordSaveStatus" class="inline-block ml-4"></div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Two-Factor Authentication -->
                        <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Two-Factor Authentication</h4>
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <div class="font-medium text-gray-800 dark:text-white">2FA Status</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Add an extra layer of security to your account
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           class="sr-only peer"
                                           onchange="toggle2FA(this)">
                                    <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1B3C53]"></div>
                                </label>
                            </div>
                            <div id="2faSetup" class="mt-4 hidden">
                                <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 mr-3"></i>
                                        <div>
                                            <div class="font-medium text-yellow-800 dark:text-yellow-300">2FA Setup Required</div>
                                            <div class="text-sm text-yellow-700 dark:text-yellow-400 mt-1">
                                                Scan the QR code with your authenticator app
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Login Activity -->
                        <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Recent Login Activity</h4>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-400 mr-3">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">Current Session</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ request()->ip() }} • Just now
                                            </div>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Active
                                    </span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-600 flex items-center justify-center text-gray-500 dark:text-gray-400 mr-3">
                                            <i class="fas fa-desktop"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">Windows • Chrome</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                192.168.1.100 • 2 hours ago
                                            </div>
                                        </div>
                                    </div>
                                    <button class="px-3 py-1 text-sm border border-red-300 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                        Revoke
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Danger Zone -->
                        <div class="pt-8 border-t border-red-200 dark:border-red-900">
                            <h4 class="font-medium text-red-600 dark:text-red-400 mb-4">Danger Zone</h4>
                            <div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-medium text-red-800 dark:text-red-300">Delete Account</div>
                                        <div class="text-sm text-red-700 dark:text-red-400 mt-1">
                                            Permanently delete your account and all data
                                        </div>
                                    </div>
                                    <button onclick="showDeleteAccountModal()"
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                        Delete Account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Tab -->
            <div id="tabContentNotifications" class="settings-tab-content hidden">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-bell text-[#456882] mr-2"></i>
                        Notification Preferences
                    </h3>
                    
                    <div class="space-y-8">
                        <!-- Email Notifications -->
                        <div>
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Email Notifications</h4>
                            <div class="space-y-3">
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">New Proposals</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            When freelancers submit proposals to your jobs
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded"
                                           checked>
                                </label>
                                
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Contract Updates</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            When freelancers update contract milestones
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded"
                                           checked>
                                </label>
                                
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Payment Receipts</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            When payments are processed or completed
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded"
                                           checked>
                                </label>
                                
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">New Messages</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            When you receive new messages from freelancers
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded"
                                           checked>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Push Notifications -->
                        <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Push Notifications</h4>
                            <div class="space-y-3">
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Desktop Notifications</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Show browser notifications for important updates
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded"
                                           checked>
                                </label>
                                
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Sound Alerts</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Play sound when receiving new notifications
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded">
                                </label>
                            </div>
                        </div>
                        
                        <!-- Notification Schedule -->
                        <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Notification Schedule</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Quiet Hours Start
                                    </label>
                                    <input type="time" 
                                           value="22:00"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Quiet Hours End
                                    </label>
                                    <input type="time" 
                                           value="08:00"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">
                                Notifications will be muted during quiet hours
                            </p>
                        </div>
                        
                        <!-- Save Notification Settings -->
                        <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                            <button onclick="saveNotificationSettings()"
                                    class="px-6 py-3 bg-[#234C6A] text-white rounded-lg hover:bg-[#1B3C53] transition-colors font-medium">
                                <i class="fas fa-save mr-2"></i>Save Notification Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing Tab -->
            <div id="tabContentBilling" class="settings-tab-content hidden">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-credit-card text-[#234C6A] mr-2"></i>
                        Billing & Payment Methods
                    </h3>
                    
                    <div class="space-y-8">
                        <!-- Current Plan -->
                        <div>
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Current Plan</h4>
                            <div class="p-6 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-xl text-white">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-2xl font-bold">Freelancer Plan</div>
                                        <div class="text-sm opacity-90 mt-1">For businesses hiring freelancers</div>
                                        <div class="mt-4">
                                            <div class="flex items-center">
                                                <i class="fas fa-check mr-2"></i>
                                                <span>Unlimited job posts</span>
                                            </div>
                                            <div class="flex items-center mt-2">
                                                <i class="fas fa-check mr-2"></i>
                                                <span>Unlimited proposals</span>
                                            </div>
                                            <div class="flex items-center mt-2">
                                                <i class="fas fa-check mr-2"></i>
                                                <span>Priority support</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-3xl font-bold">$29<span class="text-lg">/month</span></div>
                                        <div class="text-sm opacity-90 mt-1">Billed annually</div>
                                        <button class="mt-4 px-4 py-2 bg-white text-[#1B3C53] rounded-lg hover:bg-gray-100 transition-colors font-medium">
                                            Upgrade Plan
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-6 pt-6 border-t border-white/20 text-sm">
                                    <div class="flex justify-between">
                                        <span>Next billing date</span>
                                        <span class="font-medium">{{ now()->addMonth()->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Methods -->
                        <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-medium text-gray-800 dark:text-white">Payment Methods</h4>
                                <button onclick="showAddPaymentMethod()"
                                        class="px-4 py-2 bg-[#234C6A] text-white rounded-lg hover:bg-[#1B3C53] transition-colors text-sm">
                                    <i class="fas fa-plus mr-2"></i>Add New
                                </button>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-400 mr-3">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">Visa ending in 4242</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Expires 12/2025 • Primary
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                            Edit
                                        </button>
                                        <button class="px-3 py-1 text-sm border border-red-300 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center text-yellow-600 dark:text-yellow-400 mr-3">
                                            <i class="fab fa-paypal"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">PayPal</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                user@example.com
                                            </div>
                                        </div>
                                    </div>
                                    <button class="px-3 py-1 text-sm border border-red-300 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Billing History -->
                        <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Billing History</h4>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Date</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Description</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Amount</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-white">Jan 15, 2024</td>
                                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-white">Monthly Subscription</td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-800 dark:text-white">$29.00</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                    Paid
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <button class="text-sm text-[#456882] hover:text-[#1B3C53]">
                                                    Download
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-white">Dec 15, 2023</td>
                                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-white">Monthly Subscription</td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-800 dark:text-white">$29.00</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                    Paid
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <button class="text-sm text-[#456882] hover:text-[#1B3C53]">
                                                    Download
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preferences Tab -->
            <div id="tabContentPreferences" class="settings-tab-content hidden">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-cog text-[#1B3C53] mr-2"></i>
                        Application Preferences
                    </h3>
                    
                    <div class="space-y-8">
                        <!-- Language & Region -->
                        <div>
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Language & Region</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Language
                                    </label>
                                    <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                        <option>English (US)</option>
                                        <option>বাংলা (Bangla)</option>
                                        <option>Español</option>
                                        <option>Français</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Time Zone
                                    </label>
                                    <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                        <option>(UTC+06:00) Dhaka</option>
                                        <option>(UTC+05:30) India</option>
                                        <option>(UTC+00:00) London</option>
                                        <option>(UTC-05:00) New York</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Display Preferences -->
                        <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Display Preferences</h4>
                            <div class="space-y-3">
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Dark Mode</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Use dark theme throughout the application
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded"
                                           onchange="toggleDarkMode(this)"
                                           {{ request()->cookie('dark_mode') ? 'checked' : '' }}>
                                </label>
                                
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Compact Mode</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Use compact spacing for lists and tables
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded">
                                </label>
                                
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Animations</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Enable animations and transitions
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded"
                                           checked>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Privacy Settings -->
                        <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-medium text-gray-800 dark:text-white mb-4">Privacy Settings</h4>
                            <div class="space-y-3">
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Public Profile</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Allow freelancers to view your profile and company info
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded"
                                           checked>
                                </label>
                                
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Show Online Status</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Let others see when you're online
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded"
                                           checked>
                                </label>
                                
                                <label class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Data Sharing</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Allow anonymous data sharing for product improvement
                                        </div>
                                    </div>
                                    <input type="checkbox" 
                                           class="w-5 h-5 text-[#1B3C53] focus:ring-[#1B3C53] rounded">
                                </label>
                            </div>
                        </div>
                        
                        <!-- Save Preferences -->
                        <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                            <button onclick="savePreferences()"
                                    class="px-6 py-3 bg-[#234C6A] text-white rounded-lg hover:bg-[#1B3C53] transition-colors font-medium">
                                <i class="fas fa-save mr-2"></i>Save Preferences
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endsection


    @push('scripts')
    <script>
        // Tab switching
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.settings-tab-content').forEach(content => {
                content.classList.remove('active');
                content.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.settings-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById(`tabContent${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`).classList.remove('hidden');
            document.getElementById(`tabContent${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`).classList.add('active');
            
            // Add active class to clicked tab
            document.getElementById(`tab${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`).classList.add('active');
        }
        
        // Save profile
        function saveProfile() {
            const form = document.getElementById('profileForm');
            const formData = new FormData(form);
            const status = document.getElementById('profileSaveStatus');
            
            status.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            status.className = 'text-blue-600 dark:text-blue-400';
            
            fetch('/profile', {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    status.innerHTML = '<i class="fas fa-check mr-2"></i>Saved successfully!';
                    status.className = 'text-green-600 dark:text-green-400';
                    setTimeout(() => status.innerHTML = '', 3000);
                } else {
                    throw new Error(data.message || 'Failed to save');
                }
            })
            .catch(error => {
                status.innerHTML = '<i class="fas fa-times mr-2"></i>' + error.message;
                status.className = 'text-red-600 dark:text-red-400';
            });
        }
        
        // Upload avatar
        function uploadAvatar(input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('avatar', input.files[0]);
                formData.append('_token', '{{ csrf_token() }}');
                
                fetch('/profile/avatar', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to upload avatar');
                    }
                })
                .catch(error => {
                    alert('Error uploading avatar: ' + error.message);
                });
            }
        }
        
        // Change password
        function changePassword() {
            const form = document.getElementById('passwordForm');
            const formData = new FormData(form);
            const status = document.getElementById('passwordSaveStatus');
            
            status.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
            status.className = 'text-blue-600 dark:text-blue-400';
            
            fetch('/profile/password', {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    status.innerHTML = '<i class="fas fa-check mr-2"></i>Password updated!';
                    status.className = 'text-green-600 dark:text-green-400';
                    form.reset();
                    setTimeout(() => status.innerHTML = '', 3000);
                } else {
                    throw new Error(data.message || 'Failed to update password');
                }
            })
            .catch(error => {
                status.innerHTML = '<i class="fas fa-times mr-2"></i>' + error.message;
                status.className = 'text-red-600 dark:text-red-400';
            });
        }
        
        // Toggle 2FA
        function toggle2FA(checkbox) {
            if (checkbox.checked) {
                document.getElementById('2faSetup').classList.remove('hidden');
                // In a real app, you would generate QR code here
            } else {
                document.getElementById('2faSetup').classList.add('hidden');
            }
        }
        
        // Toggle dark mode
        function toggleDarkMode(checkbox) {
            if (checkbox.checked) {
                document.documentElement.classList.add('dark');
                document.cookie = 'dark_mode=true; path=/; max-age=31536000';
            } else {
                document.documentElement.classList.remove('dark');
                document.cookie = 'dark_mode=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
            }
        }
        
        // Show delete account modal
        function showDeleteAccountModal() {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone and all your data will be permanently deleted.')) {
                if (prompt('Type "DELETE" to confirm:') === 'DELETE') {
                    fetch('/profile', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.href = '/';
                        }
                    });
                }
            }
        }
        
        // Save notification settings
        function saveNotificationSettings() {
            alert('Notification settings saved!');
        }
        
        // Save preferences
        function savePreferences() {
            alert('Preferences saved!');
        }
        
        // Show add payment method
        function showAddPaymentMethod() {
            alert('Add payment method feature would open here');
        }
        
        // Save all settings
        function saveAllSettings() {
            const activeTab = document.querySelector('.settings-tab.active').id;
            const tabName = activeTab.replace('tab', '').toLowerCase();
            
            switch(tabName) {
                case 'profile':
                    saveProfile();
                    break;
                case 'security':
                    // Save security settings
                    alert('Security settings saved!');
                    break;
                case 'notifications':
                    saveNotificationSettings();
                    break;
                case 'preferences':
                    savePreferences();
                    break;
            }
        }
        
        // Auto-save form data
        document.addEventListener('DOMContentLoaded', function() {
            // Debounce function for auto-save
            let autoSaveTimeout;
            
            document.querySelectorAll('input, select, textarea').forEach(element => {
                element.addEventListener('change', function() {
                    clearTimeout(autoSaveTimeout);
                    autoSaveTimeout = setTimeout(() => {
                        const form = this.closest('form');
                        if (form && form.id) {
                            const status = form.querySelector('[id$="SaveStatus"]');
                            if (status) {
                                status.innerHTML = '<i class="fas fa-sync-alt fa-spin mr-2"></i>Auto-saving...';
                                status.className = 'text-blue-600 dark:text-blue-400';
                                
                                // Simulate auto-save
                                setTimeout(() => {
                                    status.innerHTML = '<i class="fas fa-check mr-2"></i>Auto-saved';
                                    status.className = 'text-green-600 dark:text-green-400';
                                    setTimeout(() => status.innerHTML = '', 2000);
                                }, 500);
                            }
                        }
                    }, 2000);
                });
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .settings-tab {
            transition: all 0.3s ease;
        }
        
        .settings-tab.active {
            background: white;
            color: #1B3C53;
            box-shadow: 0 4px 12px rgba(27, 60, 83, 0.1);
        }
        
        .dark .settings-tab.active {
            background: #374151;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        .settings-tab-content {
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-card {
            transition: all 0.3s ease;
        }
        
        .form-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(27, 60, 83, 0.1);
        }
        
        .progress-bar-animated {
            position: relative;
            overflow: hidden;
        }
        
        .progress-bar-animated::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .avatar-upload {
            position: relative;
            cursor: pointer;
        }
        
        .avatar-upload:hover::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(27, 60, 83, 0.7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: #1B3C53;
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }
    </style>
    @endpush
