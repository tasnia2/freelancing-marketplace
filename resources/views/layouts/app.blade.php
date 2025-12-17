<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" x-init="
    darkMode = localStorage.getItem('darkMode') === 'true' || 
               (window.matchMedia('(prefers-color-scheme: dark)').matches && !localStorage.getItem('darkMode'));
    $watch('darkMode', value => {
        localStorage.setItem('darkMode', value);
        document.documentElement.classList.toggle('dark', value);
    })
">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'WorkNest'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                        freelance: '#8b5cf6',
                        client: '#10b981',
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'slide-in': 'slideIn 0.5s ease-out',
                        'pulse-glow': 'pulseGlow 2s infinite',
                        'bounce-slow': 'bounceSlow 2s infinite',
                    }
                }
            }
        }
    </script>
    
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .dark .glass-effect {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes slideIn {
            0% { transform: translateY(-20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            50% { box-shadow: 0 0 30px rgba(59, 130, 246, 0.8); }
        }
        
        @keyframes bounceSlow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        .auth-gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .dark .auth-gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #7c3aed 100%);
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300"
      :class="{ 'dark': darkMode }">
    
    <!-- Background elements for auth pages -->
    @if(request()->is('login') || request()->is('register') || request()->is('forgot-password') || request()->is('reset-password/*'))
    <div class="fixed inset-0 auth-gradient-bg -z-10"></div>
    <div class="fixed top-10 left-10 w-64 h-64 bg-white/10 rounded-full blur-3xl -z-5"></div>
    <div class="fixed bottom-10 right-10 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl -z-5"></div>
    @endif

    <!-- Dark mode toggle -->
    <div class="fixed top-4 right-4 z-50">
        <button @click="darkMode = !darkMode"
                class="p-3 rounded-full glass-effect shadow-lg transition-transform hover:scale-110">
            <i x-show="!darkMode" class="fas fa-moon text-gray-700"></i>
            <i x-show="darkMode" class="fas fa-sun text-yellow-400"></i>
        </button>
    </div>

    <!-- Page Content -->
    <div class="min-h-screen">
        @if(request()->is('dashboard*') || request()->is('profile*'))
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        @else
            <div class="flex items-center justify-center min-h-screen p-4">
                {{ $slot }}
            </div>
        @endif
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>
