@extends('layouts.guest')

@section('title', 'Reset Password - Work Nest')

@section('content')
<div class="text-white">
    <!-- Form Header -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-white mb-2">Reset Password</h2>
        <p class="text-gray-300 text-sm">Enter your email to receive a reset link</p>
    </div>

    <!-- Success Message -->
    @if (session('status'))
        <div class="mb-6 p-4 rounded-md bg-green-900/30 border border-green-700">
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

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-md bg-red-900/30 border border-red-700">
            @foreach ($errors->all() as $error)
                <p class="text-sm text-red-300">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Forgot Password Form -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-white mb-2">Email Address</label>
            <input type="email" name="email" required autofocus
                   class="w-full input-field"
                   placeholder="you@example.com"
                   value="{{ old('email') }}">
            @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full btn-primary mb-6">
            Send Reset Link
        </button>

        <!-- Back to Login Link -->
        <div class="text-center mb-6">
            <p class="text-gray-300 text-sm">
                Remember your password?
                <a href="{{ route('login') }}" class="text-purple-300 font-semibold hover:text-purple-100 hover:underline">
                    Back to Login
                </a>
            </p>
        </div>
    </form>

    <!-- Demo Link
    <div class="mt-8 pt-6 border-t border-gray-700">
        <div class="text-center">
            <p class="text-sm text-gray-400 mb-2">For demo purposes only:</p>
            <a href="{{ route('demo.reset') }}" class="text-sm text-purple-300 hover:text-purple-100 font-medium hover:underline">
                Click here to go directly to reset password form
            </a>
        </div>
    </div> -->
</div>
@endsection