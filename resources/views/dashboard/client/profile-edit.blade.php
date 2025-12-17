@extends('layouts.client')

@section('title', 'Edit Profile - WorkNest')

@section('header')
<div class="flex justify-between items-center">
    <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
        Edit Profile
    </h2>
    <a href="{{ route('profile') }}" class="text-sm text-[#456882] hover:text-[#1B3C53]">
        ← Back to Profile
    </a>
</div>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Profile Update Form -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl p-6 md:p-8">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')

                <!-- Profile Picture -->
                <div class="flex flex-col items-center mb-8">
                    <div class="relative">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-[#456882] shadow-lg">
                            @if(auth()->user()->profile_picture)
                                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white text-4xl font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <label for="profile_picture" 
                               class="absolute bottom-0 right-0 w-10 h-10 bg-[#456882] text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-[#1B3C53] transition-colors">
                            <i class="fas fa-camera"></i>
                            <input type="file" 
                                   id="profile_picture" 
                                   name="profile_picture" 
                                   class="hidden" 
                                   accept="image/*">
                        </label>
                    </div>
                    <p class="mt-3 text-gray-600 dark:text-gray-400 text-sm">
                        Click camera icon to upload photo
                    </p>
                </div>

                <!-- Personal Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Full Name *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', auth()->user()->name) }}" 
                               required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-[#456882] focus:ring-2 focus:ring-[#456882]/20 transition-all duration-300">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email Address *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', auth()->user()->email) }}" 
                               required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-[#456882] focus:ring-2 focus:ring-[#456882]/20 transition-all duration-300">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Phone Number
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', auth()->user()->phone) }}" 
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-[#456882] focus:ring-2 focus:ring-[#456882]/20 transition-all duration-300">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company -->
                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Company Name
                        </label>
                        <input type="text" 
                               id="company" 
                               name="company" 
                               value="{{ old('company', auth()->user()->company) }}" 
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-[#456882] focus:ring-2 focus:ring-[#456882]/20 transition-all duration-300">
                        @error('company')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Bio / Description
                    </label>
                    <textarea id="bio" 
                              name="bio" 
                              rows="4"
                              class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-[#456882] focus:ring-2 focus:ring-[#456882]/20 transition-all duration-300">{{ old('bio', auth()->user()->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Address
                        </label>
                        <input type="text" 
                               id="address" 
                               name="address" 
                               value="{{ old('address', auth()->user()->address) }}" 
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-[#456882] focus:ring-2 focus:ring-[#456882]/20 transition-all duration-300">
                    </div>
                    
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            City
                        </label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               value="{{ old('city', auth()->user()->city) }}" 
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-[#456882] focus:ring-2 focus:ring-[#456882]/20 transition-all duration-300">
                    </div>
                </div>

                <!-- Social Links -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Social Links</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Website
                            </label>
                            <input type="url" 
                                   id="website" 
                                   name="website" 
                                   value="{{ old('website', auth()->user()->website) }}" 
                                   placeholder="https://"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-[#456882] focus:ring-2 focus:ring-[#456882]/20 transition-all duration-300">
                        </div>
                        
                        <div>
                            <label for="linkedin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                LinkedIn Profile
                            </label>
                            <input type="url" 
                                   id="linkedin" 
                                   name="linkedin" 
                                   value="{{ old('linkedin', auth()->user()->linkedin) }}" 
                                   placeholder="https://linkedin.com/in/"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-[#456882] focus:ring-2 focus:ring-[#456882]/20 transition-all duration-300">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-[#1B3C53] to-[#456882] text-white font-bold rounded-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 flex items-center justify-center group flex-1">
                        <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                        Save Changes
                    </button>
                    
                    <a href="{{ route('profile') }}" 
                       class="px-8 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300 flex items-center justify-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="mt-8 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-red-800 dark:text-red-300 mb-4 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Danger Zone
            </h3>
            
            <div class="space-y-4">
                <!-- Delete Account -->
                <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('delete')
                    
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <h4 class="font-medium text-red-700 dark:text-red-400">Delete Account</h4>
                            <p class="text-sm text-red-600 dark:text-red-300 mt-1">
                                Once deleted, all your data will be permanently removed.
                            </p>
                        </div>
                        <button type="button"
                                onclick="confirmDelete()"
                                class="px-6 py-2 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors duration-300">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Profile picture preview
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.querySelector('.w-32.h-32 img');
                if (img) {
                    img.src = e.target.result;
                } else {
                    const div = document.querySelector('.w-32.h-32 div');
                    if (div) {
                        div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    }
                }
            }
            reader.readAsDataURL(file);
        }
    });

    // Confirm account deletion
    function confirmDelete() {
        if (confirm('Are you sure you want to delete your account? This action cannot be undone!')) {
            document.getElementById('deleteAccountForm').submit();
        }
    }

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        if (email && !isValidEmail(email)) {
            e.preventDefault();
            alert('Please enter a valid email address.');
            return false;
        }
    });

    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
</script>

<style>
    input:focus, textarea:focus {
        outline: none;
    }
    
    .w-32.h-32 {
        transition: transform 0.3s ease;
    }
    
    .w-32.h-32:hover {
        transform: scale(1.05);
    }
    
    .profile-input:focus-within {
        box-shadow: 0 0 0 3px rgba(27, 60, 83, 0.1);
    }
</style>
@endpush