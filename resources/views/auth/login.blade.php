@extends('layouts.guest')

@section('title', 'Login - Work Nest')

@section('content')
<div class="text-white">
    <!-- Form Header -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-white mb-2">Welcome Back</h2>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-5">
            <label class="block text-sm font-medium text-white mb-2">Email Address</label>
            <input type="email" name="email" required autofocus
                   class="w-full px-4 py-3 bg-white border border-gray-700 rounded-lg text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   placeholder="you@example.com"
                   value="{{ old('email') }}">
            @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-5">
            <div class="flex justify-between items-center mb-2">
                <label class="text-sm font-medium text-white">Password</label>
                <a href="{{ route('password.request') }}" class="text-sm text-purple-300 hover:text-purple-100">
                    Forgot password?
                </a>
            </div>
            <input type="password" name="password" required
                   class="w-full px-4 py-3 bg-white border border-gray-700 rounded-lg text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mb-6">
            <input id="remember" name="remember" type="checkbox" 
                   class="w-4 h-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
            <label for="remember" class="ml-2 text-sm text-white">
                Keep me signed in
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full btn-primary mb-5">
            Sign In
        </button>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-gray-300 text-sm">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-purple-300 font-semibold hover:text-purple-100 hover:underline">
                    Create one
                </a>
            </p>
        </div>
    </form>
</div>
@endsection