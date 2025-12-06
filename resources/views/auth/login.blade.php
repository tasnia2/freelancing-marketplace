@extends('layouts.guest')

@section('title', 'Login - Work Nest')

@section('content')
<div>
    <!-- Form Header -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Welcome Back</h2>
        <p class="text-gray-600 text-sm">Sign in to your account</p>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" name="email" required autofocus
                   class="w-full input-field"
                   placeholder="you@example.com"
                   value="{{ old('email') }}">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-5">
            <div class="flex justify-between items-center mb-2">
                <label class="text-sm font-medium text-gray-700">Password</label>
                <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-800">
                    Forgot password?
                </a>
            </div>
            <input type="password" name="password" required
                   class="w-full input-field"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mb-6">
            <input id="remember" name="remember" type="checkbox" 
                   class="w-4 h-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
            <label for="remember" class="ml-2 text-sm text-gray-700">
                Keep me signed in
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full btn-primary mb-5">
            Sign In
        </button>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-gray-600 text-sm">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:underline">
                    Create one
                </a>
            </p>
        </div>
    </form>
</div>
@endsection