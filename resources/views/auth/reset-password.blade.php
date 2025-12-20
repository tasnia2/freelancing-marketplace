@extends('layouts.guest')

@section('title', 'Set New Password - Work Nest')

@section('content')
<div class="text-white">
    <!-- Form Header -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-white mb-2">Set New Password</h2>
        <p class="text-gray-300 text-sm">Create a new password for your account</p>
    </div>

    <!-- Success Message -->
    @if (session('status'))
        <div class="mb-5 p-4 rounded-md bg-green-900/30 border border-green-700">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-300">
                        {{ session('status') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Reset Password Form -->
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $token ?? old('token') }}">

        <!-- Email -->
        <div class="mb-5">
            <label class="block text-sm font-medium text-white mb-2">Email Address</label>
            <input type="email" name="email" required
                   class="w-full px-4 py-3 bg-white border border-gray-700 rounded-lg text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                   placeholder="you@example.com"
                   value="{{ $email ?? old('email') }}">
            @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label class="block text-sm font-medium text-white mb-2">New Password</label>
            <input type="password" name="password" required
                   class="w-full px-4 py-3 bg-white border border-gray-700 rounded-lg text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-white mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full px-4 py-3 bg-white border border-gray-700 rounded-lg text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   placeholder="••••••••">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 mb-5">
            Reset Password
        </button>

        <!-- Back to Login Link -->
        <div class="text-center">
            <p class="text-gray-300 text-sm">
                <a href="{{ route('login') }}" class="text-purple-300 font-semibold hover:text-purple-100 hover:underline">
                    Back to Login
                </a>
            </p>
        </div>
    </form>
</div>
@endsection