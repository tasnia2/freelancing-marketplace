<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - WorkNest</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                        secondary: {
                            50: '#fefce8',
                            100: '#fef9c3',
                            200: '#fef08a',
                            300: '#fde047',
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                            700: '#a16207',
                            800: '#854d0e',
                            900: '#713f12',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
                        'fade-in-up': 'fade-in-up 0.5s ease-out',
                        'slide-in': 'slide-in 0.5s ease-out',
                        'bounce-slow': 'bounce 3s infinite',
                        'spin-slow': 'spin 3s linear infinite',
                        'ping-slow': 'ping 3s cubic-bezier(0, 0, 0.2, 1) infinite'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        'pulse-glow': {
                            '0%, 100%': { opacity: 1 },
                            '50%': { opacity: 0.7 }
                        },
                        'fade-in-up': {
                            '0%': { transform: 'translateY(30px)', opacity: 0 },
                            '100%': { transform: 'translateY(0)', opacity: 1 }
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #8b5cf6, #7c3aed);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #7c3aed, #8b5cf6);
        }
        
        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        
        /* Glass effect */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .dark .glass {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(90deg, #8b5cf6, #7c3aed, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Card hover effects */
        .hover-card {
            transition: all 0.3s ease;
        }
        
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 92, 246, 0.15);
        }
        
        /* Progress bar animation */
        .progress-bar {
            transition: width 1.5s ease-in-out;
        }
        
        /* Notification badge */
        .notification-badge {
            animation: ping-slow 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        
        /* Online status indicator */
        .online-indicator {
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.3);
            animation: pulse-glow 2s infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen" x-data="dashboard()">
    <!-- Loading Overlay -->
    <div x-show="loading" class="fixed inset-0 bg-white/80 dark:bg-gray-900/80 z-50 flex items-center justify-center" x-transition>
        <div class="text-center">
            <div class="w-16 h-16 border-4 border-primary-500 border-t-transparent rounded-full animate-spin mx-auto"></div>
            <p class="mt-4 text-gray-600 dark:text-gray-300">Loading your dashboard...</p>
        </div>
    </div>
    
    <!-- Notification Toast -->
    <div x-show="showToast" x-transition.opacity 
         class="fixed top-4 right-4 z-50 max-w-sm w-full">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-4 border-l-4 border-green-500">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="font-medium text-gray-900 dark:text-white" x-text="toastMessage"></p>
                </div>
                <button @click="showToast = false" class="ml-auto text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions Panel -->
    <div x-show="showQuickActions" @click.away="showQuickActions = false"
         class="fixed right-4 bottom-20 z-40">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-4 w-64">
            <h3 class="font-bold text-gray-800 dark:text-white mb-3">Quick Actions</h3>
            <div class="space-y-2">
                <a href="{{ route('jobs.index') }}" class="flex items-center p-3 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-search text-primary-500 mr-3"></i>
                    <span>Browse Jobs</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center p-3 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-user-edit text-primary-500 mr-3"></i>
                    <span>Update Profile</span>
                </a>
                <a href="#" class="flex items-center p-3 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-wallet text-primary-500 mr-3"></i>
                    <span>Withdraw Earnings</span>
                </a>
                <button @click="toggleTheme" class="flex items-center p-3 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg w-full">
                    <i class="fas fa-moon text-primary-500 mr-3"></i>
                    <span>Toggle Theme</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Main Layout -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden lg:flex flex-col w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
            <!-- Logo -->
            <div class="p-6">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-handshake text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-primary-600 transition-colors">
                        Work<span class="gradient-text">Nest</span>
                    </span>
                </a>
            </div>
            
            <!-- User Profile -->
            <div class="px-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="{{ auth()->user()->getAvatarUrl() }}" 
                             alt="{{ auth()->user()->name }}"
                             class="w-12 h-12 rounded-full border-2 border-white dark:border-gray-700 shadow">
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800 online-indicator"></div>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-white">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ auth()->user()->title ?? 'Freelancer' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-gradient-to-r from-primary-500 to-primary-600 text-white">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('jobs.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-search"></i>
                    <span>Browse Jobs</span>
                    <span class="ml-auto bg-primary-100 text-primary-600 text-xs font-bold px-2 py-1 rounded-full">
                        {{ $stats['new_jobs_today'] ?? 12 }}
                    </span>
                </a>
                
                <a href="#" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-paper-plane"></i>
                    <span>My Proposals</span>
                    <span class="ml-auto bg-blue-100 text-blue-600 text-xs font-bold px-2 py-1 rounded-full">
                        {{ $stats['active_proposals'] ?? 3 }}
                    </span>
                </a>
                
                <a href="#" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-file-contract"></i>
                    <span>Contracts</span>
                    <span class="ml-auto bg-green-100 text-green-600 text-xs font-bold px-2 py-1 rounded-full">
                        {{ $stats['active_contracts'] ?? 2 }}
                    </span>
                </a>
                
                <a href="#" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-comments"></i>
                    <span>Messages</span>
                    <span class="ml-auto bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded-full">
                        {{ auth()->user()->unreadMessagesCount() ?? 5 }}
                    </span>
                </a>
                
                <a href="#" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-heart"></i>
                    <span>Saved Jobs</span>
                </a>
                
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-user-edit"></i>
                    <span>Edit Profile</span>
                </a>
            </nav>
            
            <!-- Profile Completeness -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="mb-2">
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Profile Strength</span>
                        <span class="text-sm font-bold text-primary-600">{{ auth()->user()->getProfileCompletenessPercentage() }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-primary-400 to-primary-600 h-2 rounded-full progress-bar" 
                             style="width: '{{ auth()->user()->getProfileCompletenessPercentage() }}%'"></div>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                    Complete your profile →
                </a>
            </div>
            
            <!-- Wallet Balance -->
            <div class="p-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-tl-xl rounded-tr-xl">
                <p class="text-sm opacity-90">Available Balance</p>
                <h3 class="text-2xl font-bold">${{ number_format(auth()->user()->wallet->balance ?? auth()->user()->wallet()->first()->balance ?? 1250, 2) }}</h3>
                <button class="mt-2 px-4 py-2 bg-white text-primary-600 rounded-lg text-sm font-medium hover:bg-gray-100">
                    Withdraw Funds
                </button>
            </div>
        </aside>
        
        <!-- Mobile Sidebar -->
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false"
             class="lg:hidden fixed inset-0 z-40">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
            <div class="fixed inset-0 flex">
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-gray-800">
                    <!-- Mobile sidebar content -->
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button @click="mobileMenuOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none">
                            <i class="fas fa-times text-white text-xl"></i>
                        </button>
                    </div>
                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <!-- Mobile navigation items -->
                        <nav class="px-2 space-y-1">
                            <!-- Same navigation as desktop -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navigation -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Left: Mobile menu button & search -->
                        <div class="flex items-center">
                            <button @click="mobileMenuOpen = true" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            
                            <!-- Search -->
                            <div class="hidden md:block ml-4 relative max-w-md">
                                <div class="relative">
                                    <input type="text" 
                                           placeholder="Search jobs, clients, messages..."
                                           class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: Notifications, Messages, User menu -->
                        <div class="flex items-center space-x-4">
                            <!-- Theme Toggle -->
                            <button @click="toggleTheme" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                                <i class="fas fa-moon text-gray-700 dark:text-yellow-300"></i>
                            </button>
                            
                            <!-- Quick Actions -->
                            <button @click="showQuickActions = !showQuickActions" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 relative">
                                <i class="fas fa-bolt text-primary-600"></i>
                            </button>
                            
                            <!-- Notifications -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 relative">
                                    <i class="fas fa-bell text-gray-700 dark:text-gray-300"></i>
                                    @if(auth()->user()->unreadNotificationsCount() > 0)
                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center notification-badge">
                                        {{ auth()->user()->unreadNotificationsCount() }}
                                    </span>
                                    @endif
                                </button>
                                
                                <!-- Notifications Dropdown -->
                                <div x-show="open" @click.away="open = false"
                                     class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-2xl z-50">
                                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                        <h3 class="font-bold text-gray-800 dark:text-white">Notifications</h3>
                                        <a href="#" class="text-sm text-primary-600 hover:text-primary-700">Mark all as read</a>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        <!-- Notification items -->
                                        <div class="p-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                                                        <i class="fas fa-briefcase text-white"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">New Job Match</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Web Developer needed for e-commerce site</p>
                                                    <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- More notifications... -->
                                    </div>
                                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                                        <a href="#" class="block text-center text-primary-600 hover:text-primary-700 font-medium">
                                            View all notifications
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Messages -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 relative">
                                    <i class="fas fa-envelope text-gray-700 dark:text-gray-300"></i>
                                    @if(auth()->user()->unreadMessagesCount() > 0)
                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-blue-500 text-white text-xs rounded-full flex items-center justify-center">
                                        {{ auth()->user()->unreadMessagesCount() }}
                                    </span>
                                    @endif
                                </button>
                                
                                <!-- Messages Dropdown -->
                                <div x-show="open" @click.away="open = false"
                                     class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-2xl z-50">
                                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                        <h3 class="font-bold text-gray-800 dark:text-white">Messages</h3>
                                        <a href="#" class="text-sm text-primary-600 hover:text-primary-700">View all</a>
                                    </div>
                                    <!-- Message items -->
                                </div>
                            </div>
                            
                            <!-- User Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary-500">
                                        <img src="{{ auth()->user()->getAvatarUrl() }}" 
                                             alt="{{ auth()->user()->name }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                    <span class="hidden md:block text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                                    <i class="fas fa-chevron-down text-gray-500"></i>
                                </button>
                                
                                <div x-show="open" @click.away="open = false"
                                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg py-2 z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-user mr-2"></i> Profile
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-cog mr-2"></i> Settings
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-question-circle mr-2"></i> Help
                                    </a>
                                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
                <!-- Welcome & Stats -->
                <div class="mb-8 animate-fade-in-up">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-2">
                        Welcome back, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        Here's what's happening with your freelance business today.
                    </p>
                    
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Earnings Card -->
                        <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-6 text-white hover-card">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-primary-100">Total Earnings</p>
                                    <h3 class="text-2xl font-bold mt-2">${{ number_format($stats['total_earnings'] ?? 0, 2) }}</h3>
                                </div>
                                <i class="fas fa-wallet text-2xl opacity-80"></i>
                            </div>
                            <p class="text-primary-100 text-sm mt-4">
                                <i class="fas fa-arrow-up mr-1"></i> 12% from last month
                            </p>
                        </div>
                        
                        <!-- Active Proposals -->
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white hover-card">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-blue-100">Active Proposals</p>
                                    <h3 class="text-2xl font-bold mt-2">{{ $stats['active_proposals'] ?? 0 }}</h3>
                                </div>
                                <i class="fas fa-paper-plane text-2xl opacity-80"></i>
                            </div>
                            <p class="text-blue-100 text-sm mt-4">Waiting for client review</p>
                        </div>
                        
                        <!-- Accepted Jobs -->
                        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white hover-card">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-green-100">Accepted Jobs</p>
                                    <h3 class="text-2xl font-bold mt-2">{{ $stats['accepted_proposals'] ?? 0 }}</h3>
                                </div>
                                <i class="fas fa-check-circle text-2xl opacity-80"></i>
                            </div>
                            <p class="text-green-100 text-sm mt-4">Currently working on</p>
                        </div>
                        
                        <!-- Profile Views -->
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white hover-card">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-purple-100">Profile Views</p>
                                    <h3 class="text-2xl font-bold mt-2">{{ $stats['profile_views'] ?? 0 }}</h3>
                                </div>
                                <i class="fas fa-eye text-2xl opacity-80"></i>
                            </div>
                            <p class="text-purple-100 text-sm mt-4">+24 this week</p>
                        </div>
                    </div>
                </div>
                
                <!-- Two Column Layout -->
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Recommended Jobs -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 hover-card">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Recommended Jobs</h2>
                                    <p class="text-gray-600 dark:text-gray-300">Based on your skills and preferences</p>
                                </div>
                                <a href="{{ route('jobs.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                    View all <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                            
                            @if(isset($recommendedJobs) && $recommendedJobs->count() > 0)
                            <div class="space-y-4">
                                @foreach($recommendedJobs as $job)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                @if($job->is_urgent)
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">
                                                    <i class="fas fa-bolt mr-1"></i> URGENT
                                                </span>
                                                @endif
                                                @if($job->is_featured)
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full">
                                                    <i class="fas fa-star mr-1"></i> FEATURED
                                                </span>
                                                @endif
                                                <span class="px-2 py-1 {{ $job->experience_badge_class }} text-xs font-medium rounded-full">
                                                    {{ strtoupper($job->experience_level) }}
                                                </span>
                                            </div>
                                            
                                            <h3 class="font-bold text-gray-800 dark:text-white mb-1">{{ $job->title }}</h3>
                                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                <i class="fas fa-user mr-1"></i>
                                                <span>{{ $job->client->name ?? 'Client' }}</span>
                                                <i class="fas fa-clock ml-3 mr-1"></i>
                                                <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                                                @if($job->is_remote)
                                                <i class="fas fa-globe ml-3 mr-1"></i>
                                                <span>Remote</span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @if($job->skills_required)
                                                    @foreach(array_slice($job->skills_required, 0, 4) as $skill)
                                                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-xs">
                                                        {{ $skill }}
                                                    </span>
                                                    @endforeach
                                                    @if(count($job->skills_required) > 4)
                                                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-xs">
                                                        +{{ count($job->skills_required) - 4 }} more
                                                    </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="text-right ml-4">
                                            <div class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                                                {{ $job->formatted_budget }}
                                            </div>
                                            <div class="space-y-2">
                                                <button onclick="applyToJob('{{ $job->id }}')" 
                                                        class="px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg text-sm font-medium hover:shadow-lg transition-all duration-300">
                                                    <i class="fas fa-paper-plane mr-2"></i> Apply Now
                                                </button>
                                                <button onclick="saveJob('{{ $job->id }}')" 
                                                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <i class="far fa-bookmark mr-2"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($job->deadline)
                                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            <span>Deadline: {{ $job->deadline->format('M d, Y') }}</span>
                                            <span class="ml-3 text-{{ $job->is_expired ? 'red' : 'green' }}-600">
                                                ({{ $job->time_left }} left)
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <i class="fas fa-eye mr-1"></i> {{ $job->views }} views
                                            <i class="fas fa-paper-plane ml-3 mr-1"></i> {{ $job->proposals_count }} proposals
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-8">
                                <i class="fas fa-briefcase text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                <p class="text-gray-600 dark:text-gray-300">No recommended jobs at the moment.</p>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Complete your profile to get better job matches.</p>
                                <a href="{{ route('profile.edit') }}" class="inline-block mt-4 px-6 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg hover:shadow-lg">
                                    Complete Profile
                                </a>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Recent Activity -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 hover-card">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Recent Activity</h2>
    <div class="space-y-4">
        <!-- Activity items -->
        @if(isset($activities) && $activities->count() > 0)
            @foreach($activities as $activity)
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-full 
                    @if($activity->status == 'accepted') bg-gradient-to-r from-green-500 to-teal-500
                    @elseif($activity->status == 'pending') bg-gradient-to-r from-yellow-500 to-orange-500
                    @else bg-gradient-to-r from-gray-500 to-gray-700 @endif
                    flex items-center justify-center">
                    <i class="fas 
                        @if($activity->status == 'accepted') fa-check
                        @elseif($activity->status == 'pending') fa-clock
                        @else fa-times @endif
                        text-white"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-800 dark:text-white">
                        @if($activity->status == 'accepted')
                            Proposal Accepted
                        @elseif($activity->status == 'pending')
                            Proposal Submitted
                        @else
                            Proposal Updated
                        @endif
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        @if($activity->job)
                            Your proposal for "{{ $activity->job->title }}" 
                            @if($activity->status == 'accepted') was accepted
                            @elseif($activity->status == 'pending') is pending review
                            @else was updated
                            @endif
                        @else
                            Proposal #{{ $activity->id }}
                        @endif
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                        {{ $activity->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            @endforeach
        @else
            <!-- No activities message -->
            <div class="text-center py-6">
                <i class="fas fa-inbox text-gray-300 text-3xl mb-3"></i>
                <p class="text-gray-500 dark:text-gray-400">No recent activity</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Apply to jobs to see activity here</p>
            </div>
        @endif
        <!-- More activities... -->
    </div>
</div>
                    
                    <!-- Right Column -->
                    <div class="space-y-8">
                        <!-- Quick Profile -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 hover-card">
                            <h3 class="font-bold text-gray-800 dark:text-white mb-4">Profile Snapshot</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-300">Response Rate</span>
                                    <span class="font-bold text-green-600">92%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-300">Avg. Response Time</span>
                                    <span class="font-bold text-blue-600">2.1h</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-300">Job Success</span>
                                    <span class="font-bold text-purple-600">98%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-300">On-time Delivery</span>
                                    <span class="font-bold text-yellow-600">96%</span>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block mt-6 text-center px-4 py-2 border-2 border-primary-500 text-primary-600 rounded-lg font-medium hover:bg-primary-50">
                                <i class="fas fa-chart-line mr-2"></i> View Analytics
                            </a>
                        </div>
                        
                        <!-- Skills & Endorsements -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 hover-card">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-bold text-gray-800 dark:text-white">Top Skills</h3>
                                <button class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                    <i class="fas fa-plus mr-1"></i> Add
                                </button>
                            </div>
                            <div class="space-y-3">
                                @foreach(['Laravel', 'PHP', 'Vue.js', 'Tailwind CSS', 'MySQL'] as $skill)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700 dark:text-gray-300">{{ $skill }}</span>
                                    <div class="flex items-center">
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-{{ $i <= 4 ? 'yellow-400' : 'gray-300' }} text-sm"></i>
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-gray-500 text-sm">24</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Earnings Chart -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 hover-card">
                            <h3 class="font-bold text-gray-800 dark:text-white mb-4">Earnings This Month</h3>
                            <div class="h-40 flex items-end space-x-2 mb-4">
                                <!-- Chart bars -->
                                @foreach([1200, 800, 1500, 900, 2200, 1800, 2500] as $earning)
                                <!-- In your Blade file -->
<div class="flex-1 bg-gradient-to-t from-primary-500 to-primary-300 rounded-t" 
     data-height="{{ intval(($earning / 2500) * 100) }}"></div>

<!-- Add this script at the bottom of your page -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Find all bars with data-height attribute
    document.querySelectorAll('[data-height]').forEach(bar => {
        const height = bar.getAttribute('data-height');
        bar.style.height = height + '%';
    });
});
</script>
                                @endforeach
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-gray-600 dark:text-gray-300">Total: <span class="font-bold text-primary-600">$10,900</span></p>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Bottom Actions -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-6 text-white hover-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-xl">Boost Profile</h3>
                                <p class="text-primary-100 text-sm mt-2">Get 3x more job invites</p>
                            </div>
                            <i class="fas fa-rocket text-3xl opacity-80"></i>
                        </div>
                        <button class="w-full mt-4 py-2 bg-white text-primary-600 rounded-lg font-medium hover:bg-gray-100">
                            Upgrade Now
                        </button>
                    </div>
                    
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white hover-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-xl">Get Certified</h3>
                                <p class="text-blue-100 text-sm mt-2">Stand out from competition</p>
                            </div>
                            <i class="fas fa-award text-3xl opacity-80"></i>
                        </div>
                        <button class="w-full mt-4 py-2 bg-white text-blue-600 rounded-lg font-medium hover:bg-gray-100">
                            Take Tests
                        </button>
                    </div>
                    
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white hover-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-xl">Invite Friends</h3>
                                <p class="text-green-100 text-sm mt-2">Earn $50 per referral</p>
                            </div>
                            <i class="fas fa-user-plus text-3xl opacity-80"></i>
                        </div>
                        <button class="w-full mt-4 py-2 bg-white text-green-600 rounded-lg font-medium hover:bg-gray-100">
                            Invite Now
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Floating Action Button -->
    <button @click="showQuickActions = !showQuickActions"
            class="fixed right-6 bottom-6 w-14 h-14 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-full shadow-2xl flex items-center justify-center hover:shadow-3xl z-30">
        <i class="fas fa-bolt text-xl"></i>
    </button>
    
    <!-- JavaScript -->
    <script>
        function dashboard() {
            return {
                loading: false,
                showToast: false,
                toastMessage: '',
                showQuickActions: false,
                mobileMenuOpen: false,
                darkMode: localStorage.getItem('darkMode') === 'true' || 
                         (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                
                init() {
                    // Set initial theme
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    }
                    
                    // Simulate loading
                    this.loading = true;
                    setTimeout(() => {
                        this.loading = false;
                    }, 1000);
                    
                    // Check for new notifications periodically
                    setInterval(() => {
                        // In real app, this would fetch from API
                        console.log('Checking for updates...');
                    }, 30000);
                },
                
                toggleTheme() {
                    this.darkMode = !this.darkMode;
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('darkMode', 'true');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('darkMode', 'false');
                    }
                },
                
                showNotification(message) {
                    this.toastMessage = message;
                    this.showToast = true;
                    setTimeout(() => {
                        this.showToast = false;
                    }, 3000);
                },
                
                applyToJob(jobId) {
                    this.showNotification('Redirecting to job application...');
                    // In real app, this would show application modal
                    window.location.href = `/jobs/${jobId}/apply`;
                },
                
                saveJob(jobId) {
                    fetch(`/jobs/${jobId}/save`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.showNotification(data.message);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.showNotification('Error saving job');
                    });
                }
            }
        }
        
        // Initialize animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress bars on scroll
            const observerOptions = {
                threshold: 0.5
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const progressBar = entry.target.querySelector('.progress-bar');
                        if (progressBar) {
                            const width = progressBar.style.width;
                            progressBar.style.width = '0';
                            setTimeout(() => {
                                progressBar.style.width = width;
                            }, 300);
                        }
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('.progress-bar').forEach(bar => {
                observer.observe(bar.parentElement.parentElement);
            });
            
            // Initialize tooltips
            const tooltips = document.querySelectorAll('[data-tooltip]');
            tooltips.forEach(el => {
                el.addEventListener('mouseenter', function() {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'absolute z-50 px-3 py-2 text-sm text-white bg-gray-900 rounded-lg shadow-lg';
                    tooltip.textContent = this.getAttribute('data-tooltip');
                    tooltip.style.top = (this.offsetTop - 40) + 'px';
                    tooltip.style.left = (this.offsetLeft + this.offsetWidth/2 - tooltip.offsetWidth/2) + 'px';
                    this.appendChild(tooltip);
                });
                
                el.addEventListener('mouseleave', function() {
                    const tooltip = this.querySelector('.absolute');
                    if (tooltip) tooltip.remove();
                });
            });
        });
    </script>
</body>
</html>