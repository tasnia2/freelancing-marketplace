<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" 
      x-init="
        $watch('darkMode', value => {
            localStorage.setItem('darkMode', value);
            document.documentElement.classList.toggle('dark', value);
        });
        if (darkMode) document.documentElement.classList.add('dark');
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
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Laravel Echo -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@latest/dist/echo.iife.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.0.2/pusher.min.js"></script>
    
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
                        dark: {
                            800: '#1B3C53',
                            700: '#234C6A',
                            600: '#456882',
                            100: '#E3E3E3'
                        }
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'slide-in': 'slideIn 0.5s ease-out',
                        'pulse-glow': 'pulseGlow 2s infinite',
                        'bounce-slow': 'bounceSlow 2s infinite',
                        'fade-in': 'fadeIn 0.3s ease-in',
                        'slide-up': 'slideUp 0.3s ease-out',
                    }
                }
            }
        }
        
        // Initialize Echo for real-time
        window.Echo = new Echo({
            // broadcaster: 'pusher',
            // key: '{{ env('PUSHER_APP_KEY', 'your-pusher-key') }}',
            // cluster: '{{ env('PUSHER_APP_CLUSTER', 'mt1') }}',
            forceTLS: true,
            encrypted: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                }
            }
        });
    </script>
    
    <style>
        :root {
            --primary-dark: #1B3C53;
            --primary: #234C6A;
            --primary-light: #456882;
            --light-bg: #E3E3E3;
        }
        
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
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .auth-gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .dark .auth-gradient-bg {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        }
        
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .dark .scrollbar-thin::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300"
      :class="{ 'dark': darkMode }">
    
    @if(request()->is('login') || request()->is('register') || request()->is('forgot-password') || request()->is('reset-password/*'))
    <div class="fixed inset-0 auth-gradient-bg -z-10"></div>
    <div class="fixed top-10 left-10 w-64 h-64 bg-white/10 rounded-full blur-3xl -z-5"></div>
    <div class="fixed bottom-10 right-10 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl -z-5"></div>
    @endif

    <!-- Dark mode toggle -->
    <div class="fixed top-4 right-20 z-50">
        <button @click="darkMode = !darkMode"
                class="p-3 rounded-full glass-effect shadow-lg transition-transform hover:scale-110">
            <i x-show="!darkMode" class="fas fa-moon text-gray-700 dark:text-gray-300"></i>
            <i x-show="darkMode" class="fas fa-sun text-yellow-400"></i>
        </button>
    </div>

    <!-- Notification Bell -->
    @auth
    <div class="fixed top-4 right-4 z-50">
        @include('components.notification-bell')
    </div>
    @endauth

    <!-- Page Content -->
    <div class="min-h-screen">
        @if(auth()->check() && (request()->is('dashboard*') || request()->is('client/*') || request()->is('freelancer/*') || request()->is('profile*')))
            @include('layouts.navigation')

            <!-- Page Heading -->
           @yield('header')


            <!-- Page Content -->
            <main class="animate-fade-in">
                @yield('content')
            </main>

          @stack('scripts')
          @stack('styles')

        @else
            <div class="flex items-center justify-center min-h-screen p-4">
                @yield('content')
            </div>
        @endif
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="fixed bottom-4 left-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-up">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-3"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed bottom-4 left-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-up">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-3"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    @stack('scripts')
</body>
</html>