@extends('layouts.client')

@section('title', 'My Profile - WorkNest')

@section('header')
<div class="flex justify-between items-center">
    <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
        My Profile
    </h2>
    <div class="flex space-x-3">
        <a href="{{ route('profile.edit') }}" 
           class="px-4 py-2 bg-gradient-to-r from-[#456882] to-[#234C6A] text-white rounded-xl hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 flex items-center">
            <i class="fas fa-edit mr-2"></i> Edit Profile
        </a>
        <a href="{{ route('dashboard') }}" 
           class="px-4 py-2 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="py-6 animate-fade-in">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-[#1B3C53] to-[#456882] rounded-2xl p-8 text-white shadow-2xl mb-8">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                <!-- Profile Picture -->
                <div class="relative">
                    <div class="w-40 h-40 rounded-full border-4 border-white/30 overflow-hidden shadow-2xl">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->getAvatarUrl() }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-[#E3E3E3] to-gray-300 flex items-center justify-center text-[#1B3C53] text-5xl font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-2 -right-2 bg-white text-[#1B3C53] w-12 h-12 rounded-full flex items-center justify-center shadow-lg">
                        @if(auth()->user()->role == 'client')
                            <i class="fas fa-briefcase text-xl"></i>
                        @else
                            <i class="fas fa-laptop-code text-xl"></i>
                        @endif
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">{{ auth()->user()->getDisplayName() }}</h1>
                            <div class="flex items-center justify-center md:justify-start space-x-4">
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm">
                                    {{ auth()->user()->isClient() ? 'Client' : 'Freelancer' }}
                                </span>
                                @if(auth()->user()->isFreelancer() && auth()->user()->title)
                                    <span class="px-3 py-1 bg-white/10 rounded-full text-sm">
                                        {{ auth()->user()->title }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Stats -->
                        <div class="mt-4 md:mt-0">
                            @if(auth()->user()->isFreelancer())
                                <div class="text-3xl font-bold">${{ auth()->user()->hourly_rate ?? '0' }}/hr</div>
                                <div class="text-white/80">Hourly Rate</div>
                            @else
                                <div class="text-3xl font-bold">{{ auth()->user()->jobsPosted()->count() }}</div>
                                <div class="text-white/80">Jobs Posted</div>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div class="flex items-center">
                            <i class="fas fa-envelope w-6 mr-3 text-white/80"></i>
                            <span>{{ auth()->user()->email }}</span>
                        </div>
                        @if(auth()->user()->phone)
                            <div class="flex items-center">
                                <i class="fas fa-phone w-6 mr-3 text-white/80"></i>
                                <span>{{ auth()->user()->phone }}</span>
                            </div>
                        @endif
                        @if(auth()->user()->location)
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt w-6 mr-3 text-white/80"></i>
                                <span>{{ auth()->user()->location }}</span>
                            </div>
                        @endif
                        @if(auth()->user()->isClient() && auth()->user()->company)
                            <div class="flex items-center">
                                <i class="fas fa-building w-6 mr-3 text-white/80"></i>
                                <span>{{ auth()->user()->company }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Completeness -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Profile Completeness</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        {{ auth()->user()->getProfileCompletenessPercentageRoleBased() }}% complete
                    </p>
                </div>
                <div class="text-2xl font-bold text-[#456882] dark:text-[#234C6A]">
                    {{ auth()->user()->getProfileCompletenessPercentageRoleBased() }}%
                </div>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                <div class="bg-gradient-to-r from-[#1B3C53] to-[#456882] h-3 rounded-full transition-all duration-1000" 
                 @style(['width: ' . auth()->user()->getProfileCompletenessPercentageRoleBased() . '%'])></div>
              </div>
            
            <!-- Missing Fields -->
            @php
                $missingFields = [];
                if (auth()->user()->isFreelancer()) {
                    if (empty(auth()->user()->title)) $missingFields[] = 'Professional Title';
                    if (empty(auth()->user()->hourly_rate)) $missingFields[] = 'Hourly Rate';
                    if (empty(auth()->user()->bio)) $missingFields[] = 'Bio';
                    if (empty(auth()->user()->location)) $missingFields[] = 'Location';
                } else {
                    if (empty(auth()->user()->company)) $missingFields[] = 'Company Name';
                    if (empty(auth()->user()->location)) $missingFields[] = 'Location';
                }
                if (empty(auth()->user()->avatar)) $missingFields[] = 'Profile Picture';
            @endphp
            
            @if(count($missingFields) > 0)
                <div class="mt-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Complete these to get 100%:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($missingFields as $field)
                            <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 rounded-full text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $field }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Bio Section -->
        @if(auth()->user()->bio)
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-user-circle mr-2 text-[#456882]"></i>
                    About Me
                </h3>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                    {{ auth()->user()->bio }}
                </p>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @if(auth()->user()->isClient())
                <div class="bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-[#1B3C53] dark:text-white mb-2">
                        {{ auth()->user()->jobsPosted()->count() }}
                    </div>
                    <div class="text-gray-700 dark:text-gray-300">Jobs Posted</div>
                </div>
                <div class="bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-[#234C6A] dark:text-white mb-2">
                        {{ auth()->user()->jobsPosted()->where('status', 'in_progress')->count() }}
                    </div>
                    <div class="text-gray-700 dark:text-gray-300">Active Jobs</div>
                </div>
                <div class="bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-[#456882] dark:text-white mb-2">
                        {{ auth()->user()->jobsPosted()->where('status', 'completed')->count() }}
                    </div>
                    <div class="text-gray-700 dark:text-gray-300">Completed Jobs</div>
                </div>
            @else
                <div class="bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-[#1B3C53] dark:text-white mb-2">
                        {{ auth()->user()->proposals()->count() }}
                    </div>
                    <div class="text-gray-700 dark:text-gray-300">Proposals Sent</div>
                </div>
                <div class="bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-[#234C6A] dark:text-white mb-2">
                        {{ auth()->user()->acceptedProposals()->count() }}
                    </div>
                    <div class="text-gray-700 dark:text-gray-300">Jobs Won</div>
                </div>
                <div class="bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-6 text-center">
                    <div class="text-3xl font-bold text-[#456882] dark:text-white mb-2">
                        ${{ number_format(auth()->user()->getTotalEarningsAttribute(), 0) }}
                    </div>
                    <div class="text-gray-700 dark:text-gray-300">Total Earned</div>
                </div>
            @endif
        </div>

        <!-- Account Information -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                <i class="fas fa-info-circle mr-2 text-[#456882]"></i>
                Account Information
            </h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">Member Since</span>
                    <span class="font-medium text-gray-800 dark:text-white">
                        {{ auth()->user()->created_at->format('F d, Y') }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">Account Type</span>
                    <span class="font-medium text-gray-800 dark:text-white capitalize">
                        {{ auth()->user()->role }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">Email Verified</span>
                    <span class="font-medium {{ auth()->user()->email_verified_at ? 'text-green-600' : 'text-red-600' }}">
                        {{ auth()->user()->email_verified_at ? 'Verified' : 'Not Verified' }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-gray-600 dark:text-gray-400">Last Updated</span>
                    <span class="font-medium text-gray-800 dark:text-white">
                        {{ auth()->user()->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush