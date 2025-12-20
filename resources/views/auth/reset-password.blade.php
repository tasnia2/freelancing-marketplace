@extends('layouts.guest')

@section('title', 'Set New Password - Work Nest')

@section('content')
<div>
    <!-- Form Header -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-white-800 mb-2">Set New Password</h2>
        <p class="text-white-600 text-sm">Create a new password for your account</p>
    </div>

    <!-- Success Message -->
    @if (session('status'))
        <div class="mb-5 p-4 rounded-md bg-green-50 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
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
            <label class="block text-sm font-medium text-white-700 mb-2">Email Address</label>
            <input type="email" name="email" required
                   class="w-full input-field @error('email') border-red-500 @enderror"
                   placeholder="you@example.com"
                   value="{{ $email ?? old('email') }}">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label class="block text-sm font-medium text-white-700 mb-2">New Password</label>
            <input type="password" name="password" required
                   class="w-full input-field @error('password') border-red-500 @enderror"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-white-300 mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full input-field"
                   placeholder="••••••••">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full btn-primary mb-5">
            Reset Password
        </button>

        <!-- Back to Login Link -->
        <div class="text-center">
            <p class="text-white-300 text-sm">
                <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:underline">
                    Back to Login
                </a>
            </p>
        </div>
    </form>
</div>
@endsection