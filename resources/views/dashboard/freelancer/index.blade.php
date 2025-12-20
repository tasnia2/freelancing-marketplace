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
                        // Enhanced purple palette with more aesthetic shades
                        primary: {
                            25: '#fbf7ff',
                            50: '#f5efff',
                            100: '#eae0ff',
                            200: '#d6c7ff',
                            300: '#b89aff',
                            400: '#9b7cff',
                            500: '#8b5cf6',  // Main brand purple
                            600: '#7c3aed',  // Vibrant purple
                            700: '#8c75b2ff',  // Deep purple
                            800: '#9e85c5ff',  // Royal purple
                            900: '#4c1d95',  // Dark purple
                            950: '#2e1065',  // Midnight purple
                            gradient: 'linear-gradient(135deg, #9b7cff 0%, #7c3aed 50%, #5b21b6 100%)',
                            light: '#f5efff',
                            accent: '#e879f9' // Fuschia accent
                        },
                        secondary: {
                            // Gold/Yellow tones for contrast
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
                        'fade-in-up': 'fade-in-up 0.5s ease-out',
                        'fade-in': 'fade-in 0.8s ease-out',
                        'slide-in-left': 'slide-in-left 0.6s ease-out',
                        'slide-in-right': 'slide-in-right 0.6s ease-out',
                        'bounce-slow': 'bounce 3s infinite',
                        'spin-slow': 'spin 3s linear infinite',
                        'ping-slow': 'ping 3s cubic-bezier(0, 0, 0.2, 1) infinite',
                        'wave': 'wave 1.5s ease-in-out infinite',
                        'shimmer': 'shimmer 2s infinite',
                        'gradient-x': 'gradient-x 15s ease infinite',
                        'card-float': 'card-float 8s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(5deg)' }
                        },
                        'pulse-glow': {
                            '0%, 100%': { 
                                opacity: 1,
                                boxShadow: '0 0 20px rgba(139, 92, 246, 0.3)'
                            },
                            '50%': { 
                                opacity: 0.8,
                                boxShadow: '0 0 40px rgba(139, 92, 246, 0.6)'
                            }
                        },
                        'fade-in-up': {
                            '0%': { 
                                transform: 'translateY(30px) scale(0.95)', 
                                opacity: 0 
                            },
                            '100%': { 
                                transform: 'translateY(0) scale(1)', 
                                opacity: 1 
                            }
                        },
                        'fade-in': {
                            '0%': { opacity: 0 },
                            '100%': { opacity: 1 }
                        },
                        'slide-in-left': {
                            '0%': { 
                                transform: 'translateX(-30px)', 
                                opacity: 0 
                            },
                            '100%': { 
                                transform: 'translateX(0)', 
                                opacity: 1 
                            }
                        },
                        'slide-in-right': {
                            '0%': { 
                                transform: 'translateX(30px)', 
                                opacity: 0 
                            },
                            '100%': { 
                                transform: 'translateX(0)', 
                                opacity: 1 
                            }
                        },
                        wave: {
                            '0%': { transform: 'translateX(0)' },
                            '50%': { transform: 'translateX(-10px)' },
                            '100%': { transform: 'translateX(0)' }
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-200% center' },
                            '100%': { backgroundPosition: '200% center' }
                        },
                        'gradient-x': {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' }
                        },
                        'card-float': {
                            '0%, 100%': { 
                                transform: 'translateY(0) rotate(0deg)' 
                            },
                            '50%': { 
                                transform: 'translateY(-15px) rotate(2deg)' 
                            }
                        }
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
                        'purple-gradient': 'linear-gradient(135deg, #9b7cff 0%, #7c3aed 50%, #5b21b6 100%)',
                        'glass-gradient': 'linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%)',
                        'card-gradient': 'linear-gradient(145deg, #ffffff 0%, #f5efff 100%)',
                        'dark-card-gradient': 'linear-gradient(145deg, #1e293b 0%, #2e1065 100%)',
                        'shimmer-gradient': 'linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.1) 50%, transparent 100%)'
                    },
                    backdropBlur: {
                        'xs': '2px',
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
        /* Enhanced Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: linear-gradient(180deg, #f5efff 0%, #eae0ff 100%);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #9b7cff 0%, #a588d7ff 50%, #8d66ccff 100%);
            border-radius: 10px;
            border: 2px solid #f5efff;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #7c3aed 0%, #9b7cff 50%, #7c3aed 100%);
            box-shadow: 0 0 20px rgba(155, 124, 255, 0.6);
        }
        
        .dark ::-webkit-scrollbar-track {
            background: linear-gradient(180deg, #1e293b 0%, #2e1065 100%);
        }
        
        .dark ::-webkit-scrollbar-thumb {
            border-color: #1e293b;
        }
        
        /* Smooth transitions */
        * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Enhanced Glass effect */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(155, 124, 255, 0.1);
        }
        
        .dark .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(90deg, #9b7cff 0%, #7c3aed 50%, #5b21b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% auto;
            animation: gradient-x 3s ease infinite;
        }
        
        /* Enhanced Card hover effects */
        .hover-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .hover-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(155, 124, 255, 0.25);
        }
        
        .hover-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }
        
        .hover-card:hover::before {
            left: 100%;
        }
        
        .dark .hover-card:hover {
            box-shadow: 0 25px 50px -12px rgba(155, 124, 255, 0.15);
        }
        
        /* Progress bar animation */
        .progress-bar {
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(90deg, #9b7cff 0%, #7c3aed 50%, #5b21b6 100%);
            background-size: 200% 100%;
            animation: gradient-x 2s ease infinite;
        }
        
        /* Notification badge */
        .notification-badge {
            animation: pulse-glow 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        
        /* Online status indicator */
        .online-indicator {
            box-shadow: 0 0 0 3px rgba(207, 125, 228, 0.3);
            animation: pulse-glow 2s infinite;
        }
        
        /* Shimmer effect */
        .shimmer-effect {
            background: linear-gradient(90deg, #f5efff 25%, #eae0ff 50%, #f5efff 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }
        
        .dark .shimmer-effect {
            background: linear-gradient(90deg, #1e293b 25%, #2e1065 50%, #1e293b 75%);
        }
        
        /* Gradient border */
        .gradient-border {
            position: relative;
            border-radius: 16px;
        }
        
        .gradient-border::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #9b7cff, #7c3aed, #5b21b6, #9b7cff);
            border-radius: 18px;
            z-index: -1;
            background-size: 400% 400%;
            animation: gradient-x 3s ease infinite;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .gradient-border:hover::before {
            opacity: 1;
        }
        
        /* Floating animation for decorative elements */
        .floating-element {
            animation: float 8s ease-in-out infinite;
        }
        
        /* Background particles */
        .particles-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
            opacity: 0.3;
        }
        
        .particle {
            position: absolute;
            background: linear-gradient(45deg, #9b7cff, #e879f9);
            border-radius: 50%;
            opacity: 0.4;
            animation: float 15s infinite linear;
        }
        
        /* Enhanced button styles */
        .btn-primary {
            background: linear-gradient(135deg, #9b7cff 0%, #7c3aed 100%);
            background-size: 200% 200%;
            animation: gradient-x 3s ease infinite;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(155, 124, 255, 0.4);
            background-position: right center;
        }
        
        /* Card glow effect */
        .card-glow {
            box-shadow: 0 0 40px rgba(155, 124, 255, 0.15);
        }
        
        .dark .card-glow {
            box-shadow: 0 0 40px rgba(155, 124, 255, 0.1);
        }
        
        /* Neon text effect */
        .neon-text {
            text-shadow: 0 0 10px rgba(155, 124, 255, 0.7),
                         0 0 20px rgba(155, 124, 255, 0.5),
                         0 0 30px rgba(155, 124, 255, 0.3);
        }
        
        /* Loading spinner */
        .loading-spinner {
            border: 3px solid #f5efff;
            border-top: 3px solid #7c3aed;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        /* Wave animation */
        .wave-animation {
            animation: wave 2s ease-in-out infinite;
        }
        
        /* Blob background */
        .blob-bg {
            position: absolute;
            background: linear-gradient(45deg, #9b7cff, #e879f9);
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.15;
            z-index: -1;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-25 via-white to-purple-50 dark:from-gray-950 dark:via-gray-900 dark:to-primary-950 min-h-screen relative overflow-x-hidden" x-data="dashboard()">
    
    <!-- Animated Background Elements -->
    <div class="particles-container">
        <div class="particle floating-element" style="width: 100px; height: 100px; top: 10%; left: 5%; animation-delay: 0s;"></div>
        <div class="particle floating-element" style="width: 150px; height: 150px; top: 60%; right: 10%; animation-delay: 1s;"></div>
        <div class="particle floating-element" style="width: 80px; height: 80px; bottom: 20%; left: 15%; animation-delay: 2s;"></div>
        <div class="blob-bg" style="width: 500px; height: 500px; top: -200px; right: -200px;"></div>
        <div class="blob-bg" style="width: 400px; height: 400px; bottom: -150px; left: -150px;"></div>
    </div>
    
    <!-- Loading Overlay -->
    <div x-show="loading" class="fixed inset-0 bg-white/90 dark:bg-gray-950/90 z-50 flex items-center justify-center" x-transition>
        <div class="text-center animate-fade-in">
            <div class="w-20 h-20 border-4 border-primary-100 dark:border-primary-900 border-t-primary-600 rounded-full animate-spin mx-auto"></div>
            <div class="mt-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Welcome to WorkNest</h3>
                <p class="text-gray-600 dark:text-gray-300">Preparing your creative workspace...</p>
                <div class="mt-4 flex justify-center space-x-2">
                    <div class="w-2 h-2 bg-primary-400 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                    <div class="w-2 h-2 bg-primary-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-2 h-2 bg-primary-600 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Notification Toast -->
    <div x-show="showToast" x-transition.opacity.scale 
         class="fixed top-4 right-4 z-50 max-w-sm w-full animate-slide-in-right">
        <div class="glass rounded-2xl shadow-2xl p-4 border-l-4 border-green-500">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white"></i>
                    </div>
                </div>
                <div class="ml-3 flex-1">
                    <p class="font-bold text-gray-900 dark:text-white" x-text="toastMessage"></p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Just now</p>
                </div>
                <button @click="showToast = false" class="ml-4 text-gray-400 hover:text-gray-500 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions Panel -->
    <div x-show="showQuickActions" @click.away="showQuickActions = false"
         class="fixed right-4 bottom-20 z-40 animate-fade-in-up">
        <div class="glass rounded-2xl shadow-2xl p-4 w-64 gradient-border">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center mr-2">
                    <i class="fas fa-bolt text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800 dark:text-white">Quick Actions</h3>
            </div>
            <div class="space-y-2">
                <a href="{{ route('jobs.index') }}" 
                   class="flex items-center p-3 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-xl transition-all hover:translate-x-2">
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-search text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Browse Jobs</span>
                </a>
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center p-3 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-xl transition-all hover:translate-x-2">
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user-edit text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Update Profile</span>
                </a>
                <a href="#" 
                   class="flex items-center p-3 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-xl transition-all hover:translate-x-2">
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-wallet text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Withdraw Earnings</span>
                </a>
                <button @click="toggleTheme" 
                        class="flex items-center p-3 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-xl transition-all hover:translate-x-2 w-full">
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-moon text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Toggle Theme</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Main Layout -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden lg:flex flex-col w-64 bg-gradient-to-b from-white via-white to-primary-50 dark:from-gray-900 dark:via-gray-900 dark:to-primary-950 border-r border-gray-200 dark:border-gray-800 relative z-20">
            <!-- Decorative sidebar accent -->
            <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-primary-500 via-primary-600 to-primary-700"></div>
            
            <!-- Logo -->
            <div class="p-6">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 flex items-center justify-center group-hover:rotate-12 transition-all duration-500 shadow-lg">
                        <i class="fas fa-handshake text-white text-xl"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-gray-900 dark:text-white block leading-tight">Work<span class="gradient-text">Nest</span></span>
                    </div>
                </a>
            </div>
            
            <!-- User Profile -->
            <div class="px-6 pb-6 border-b border-gray-200 dark:border-gray-800">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl overflow-hidden border-4 border-white dark:border-gray-800 shadow-lg">
                            <img src="{{ auth()->user()->getAvatarUrl() }}" 
                                 alt="{{ auth()->user()->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="absolute bottom-0 right-0 w-4 h-4 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full border-2 border-white dark:border-gray-800 online-indicator"></div>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 dark:text-white text-lg">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ auth()->user()->title ?? 'Freelancer' }}</p>
                        <div class="flex items-center mt-1">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-xs {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">(4.8)</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 animate-slide-in-left">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg hover:shadow-xl transition-all">
                    <i class="fas fa-home"></i>
                    <span class="font-medium">Dashboard</span>
                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                </a>
                
                <a href="{{ route('jobs.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-xl hover:translate-x-2 transition-all">
                    <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-search text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span class="font-medium">Browse Jobs</span>
                    <span class="ml-auto bg-gradient-to-r from-primary-500 to-primary-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        {{ $stats['new_jobs_today'] ?? 12 }}
                    </span>
                </a>
                
                <a href="{{ route('freelancer.proposals') }}" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-xl hover:translate-x-2 transition-all">
                    <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-paper-plane text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span class="font-medium">My Proposals</span>
                    <span class="ml-auto bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        {{ auth()->user()->proposals()->where('status', 'pending')->count() }}
                    </span>
                </a>
                
                <a href="{{ route('freelancer.contracts') }}" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-xl hover:translate-x-2 transition-all">
                    <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-contract text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span class="font-medium">Contracts</span>
                    <span class="ml-auto bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        {{ $stats['active_contracts'] ?? 0 }}
                    </span>
                </a>
                
                <a href="{{ route('messages.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-xl hover:translate-x-2 transition-all">
                    <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-comments text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span class="font-medium">Messages</span>
                    <span class="ml-auto bg-gradient-to-r from-red-500 to-pink-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        {{ auth()->user()->unreadMessagesCount() ?? 5 }}
                    </span>
                </a>
                
                <a href="{{ route('freelancer.saved-jobs') }}" 
   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-xl hover:translate-x-2 transition-all">
                    <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heart text-primary-600 dark:text-primary-400"></i>
                    </div>
    <span>Saved Jobs</span>
    <span class="ml-auto bg-primary-100 text-primary-600 text-xs font-bold px-2 py-1 rounded-full">
        {{ auth()->user()->savedJobs()->count() }}
    </span>
</a>
                
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-xl hover:translate-x-2 transition-all">
                    <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-edit text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span class="font-medium">Edit Profile</span>
                </a>
            </nav>
            
            <!-- Profile Completeness -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-800">
                <div class="mb-3">
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Profile Strength</span>
                        <span class="text-sm font-black text-primary-600">{{ auth()->user()->getProfileCompletenessPercentage() }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-800 rounded-full h-2.5 overflow-hidden">
                        <div class="h-2.5 rounded-full progress-bar" 
                             style="width: '{{ auth()->user()->getProfileCompletenessPercentage() }}%'"></div>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="group flex items-center justify-between text-sm text-primary-600 hover:text-primary-700 font-medium">
                    <span>Complete your profile</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>
            
            <!-- Wallet Balance -->
            <div class="m-4 p-4 bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 text-white rounded-2xl shadow-xl hover:scale-105 transition-transform duration-300">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-sm opacity-90">Available Balance</p>
                        <h3 class="text-2xl font-black">${{ number_format(auth()->user()->wallet->balance ?? auth()->user()->wallet()->first()->balance ?? 1250, 2) }}</h3>
                    </div>
                </div>
                <button class="w-full mt-3 px-4 py-2.5 bg-white text-primary-600 rounded-xl text-sm font-bold hover:bg-gray-100 hover:shadow-lg transition-all">
                    <i class="fas fa-download mr-2"></i> Withdraw Funds
                </button>
            </div>
        </aside>
        
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navigation -->
            <header class="glass border-b border-gray-200 dark:border-gray-800 sticky top-0 z-30">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Left: Mobile menu button & search -->
                        <div class="flex items-center space-x-4">
                            <button @click="mobileMenuOpen = true" 
                                    class="lg:hidden p-2 rounded-xl text-gray-400 hover:text-gray-500 hover:bg-primary-50 dark:hover:bg-gray-800">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            
                            <!-- Search -->
                            <div class="hidden md:block relative max-w-md flex-1">
                                <div class="relative group">
                                    <input type="text" 
                                           placeholder="Search jobs, clients, messages..."
                                           class="w-full pl-12 pr-4 py-3 border border-gray-300 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 shadow-sm">
                                    <i class="fas fa-search absolute left-4 top-3.5 text-gray-400 group-focus-within:text-primary-500"></i>
                                    <div class="absolute right-3 top-3">
                                        <kbd class="px-2 py-1 text-xs bg-gray-100 dark:bg-gray-700 rounded">⌘K</kbd>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: Notifications, Messages, User menu -->
                        <div class="flex items-center space-x-3">
                            <!-- Theme Toggle -->
                            <button @click="toggleTheme" 
                                    class="p-2.5 rounded-xl bg-primary-50 dark:bg-gray-800 hover:bg-primary-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-moon text-primary-600 dark:text-yellow-300 text-lg"></i>
                            </button>
                            
                            <!-- Quick Actions -->
                            <button @click="showQuickActions = !showQuickActions" 
                                    class="p-2.5 rounded-xl bg-primary-50 dark:bg-gray-800 hover:bg-primary-100 dark:hover:bg-gray-700 transition-colors relative">
                                <i class="fas fa-bolt text-primary-600 text-lg"></i>
                            </button>
                            
                           <!-- Notifications -->
                    <div class="relative">
                        <button id="notificationBtn" class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                            @if(count($notifications) > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center notification-dot">
                                {{ min(count($notifications), 9) }}{{ count($notifications) > 9 ? '+' : '' }}
                            </span>
                            @endif
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-semibold text-gray-800 dark:text-white">Notifications</h3>
                                    <a href="#" class="text-sm text-[#456882] hover:text-[#1B3C53]">Mark all as read</a>
                                </div>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                @forelse($notifications->take(5) as $notification)
                                <div class="p-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ !$notification->read ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $notification->type === 'new_proposal' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }}">
                                            <i class="{{ $notification->type === 'new_proposal' ? 'fas fa-file-alt' : 'fas fa-bell' }} text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $notification->title }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="p-8 text-center text-gray-500">
                                    <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                    <p>No notifications</p>
                                </div>
                                @endforelse
                            </div>
                            <a href="#" class="block p-3 text-center text-sm text-[#456882] hover:text-[#1B3C53] border-t border-gray-100 dark:border-gray-700">
                                View all notifications
                            </a>
                        </div>
                    </div>

                                
                                <!-- Notifications Dropdown -->
                                <div x-show="open" @click.away="open = false"
                                     class="absolute right-0 mt-2 w-96 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl z-50 glass animate-fade-in-up">
                                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                        <h3 class="font-bold text-gray-800 dark:text-white text-lg">Notifications</h3>
                                        <a href="#" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                            Mark all as read
                                        </a>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        <!-- Notification items -->
                                        <div class="p-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                                                        <i class="fas fa-briefcase text-white"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <p class="font-bold text-gray-900 dark:text-white">New Job Match</p>
                                                        <span class="text-xs text-gray-500">2m ago</span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Web Developer needed for e-commerce site</p>
                                                    <div class="flex items-center mt-2">
                                                        <span class="text-xs px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full">Frontend</span>
                                                        <span class="text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full ml-2">Remote</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- More notifications... -->
                                    </div>
                                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                                        <a href="#" class="block text-center text-primary-600 hover:text-primary-700 font-bold py-2">
                                            View all notifications
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Messages -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="p-2.5 rounded-xl bg-primary-50 dark:bg-gray-800 hover:bg-primary-100 dark:hover:bg-gray-700 transition-colors relative">
                                    <i class="fas fa-envelope text-gray-700 dark:text-gray-300 text-lg"></i>
                                    @if(auth()->user()->unreadMessagesCount() > 0)
                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                        {{ auth()->user()->unreadMessagesCount() }}
                                    </span>
                                    @endif
                                </button>
                                
                                <!-- Messages Dropdown -->
                                <div x-show="open" @click.away="open = false"
                                     class="absolute right-0 mt-2 w-96 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl z-50 glass animate-fade-in-up">
                                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                        <h3 class="font-bold text-gray-800 dark:text-white text-lg">Messages</h3>
                                        <a href="#" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                            View all
                                        </a>
                                    </div>
                                    <!-- Message items -->
                                </div>
                            </div>
                            
                            <!-- User Menu - INSTANT DROPDOWN (NO ANIMATIONS) -->
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
        <div class="relative">
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary-500">
                <img src="{{ auth()->user()->getAvatarUrl() }}" 
                     alt="{{ auth()->user()->name }}"
                     class="w-full h-full object-cover">
            </div>
        </div>
        <span class="hidden md:block text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
        <i class="fas fa-chevron-down text-gray-500"></i>
    </button>
    
    <!-- INSTANT DROPDOWN - NO TRANSITIONS/ANIMATIONS -->
    <div x-show="open" @click.away="open = false" style="display: none;"
         x-cloak
         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 z-50 border border-gray-200 dark:border-gray-700">
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
            <i class="fas fa-user mr-2"></i> Profile
        </a>
        
        <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
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
            <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 animate-fade-in">
                <!-- Welcome & Stats -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-2 animate-fade-in-up">
                                Welcome back, <span class="gradient-text">{{ auth()->user()->name }}</span>! 👋
                            </h1>
                            <p class="text-gray-600 dark:text-gray-300 text-lg">
                                Here's what's happening with your freelance business today.
                                <span class="block text-sm text-primary-600 dark:text-primary-400 mt-1">
                                    <i class="fas fa-chart-line mr-2"></i>Your earnings are up 24% this week
                                </span>
                            </p>
                        </div>
                        <div class="hidden lg:block">
                            <div class="text-right">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Today is</p>
                                <p class="text-xl font-bold text-gray-800 dark:text-white">{{ now()->format('l, F j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Earnings Card -->
                        <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl p-6 text-white hover-card card-glow">
                            <div class="absolute top-4 right-4 opacity-20">
                                <i class="fas fa-wallet text-4xl"></i>
                            </div>
                            <div>
                                <p class="text-primary-100 text-sm font-medium">Total Earnings</p>
                                <h3 class="text-3xl font-black mt-2">${{ number_format($stats['total_earnings'] ?? 0, 2) }}</h3>
                            </div>
                            <div class="flex items-center mt-6">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-arrow-up text-sm"></i>
                                </div>
                                <p class="text-primary-100 text-sm">
                                    <span class="font-bold">12%</span> from last month
                                </p>
                            </div>
                        </div>
                        
                        <!-- Active Proposals -->
                        <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl p-6 text-white hover-card card-glow">
                            <div class="absolute top-4 right-4 opacity-20">
                                <i class="fas fa-paper-plane text-4xl"></i>
                            </div>
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Active Proposals</p>
                                <h3 class="text-3xl font-black mt-2">{{ $stats['active_proposals'] ?? 0 }}</h3>
                            </div>
                            <div class="flex items-center mt-6">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-clock text-sm"></i>
                                </div>
                                <p class="text-blue-100 text-sm">Waiting for client review</p>
                            </div>
                        </div>
                        
                        <!-- Accepted Jobs -->
                        <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl p-6 text-white hover-card card-glow">
                            <div class="absolute top-4 right-4 opacity-20">
                                <i class="fas fa-check-circle text-4xl"></i>
                            </div>
                            <div>
                                <p class="text-green-100 text-sm font-medium">Accepted Jobs</p>
                                <h3 class="text-3xl font-black mt-2">{{ $stats['accepted_proposals'] ?? 0 }}</h3>
                            </div>
                            <div class="flex items-center mt-6">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-briefcase text-sm"></i>
                                </div>
                                <p class="text-green-100 text-sm">Currently working on</p>
                            </div>
                        </div>
                        
                        <!-- Profile Views -->
                        <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl p-6 text-white hover-card card-glow">
                            <div class="absolute top-4 right-4 opacity-20">
                                <i class="fas fa-eye text-4xl"></i>
                            </div>
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Profile Views</p>
                                <h3 class="text-3xl font-black mt-2">{{ $stats['profile_views'] ?? 0 }}</h3>
                            </div>
                            <div class="flex items-center mt-6">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-users text-sm"></i>
                                </div>
                                <p class="text-purple-100 text-sm">
                                    <span class="font-bold">+24</span> this week
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Two Column Layout -->
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Recommended Jobs -->
                        <div class="glass rounded-2xl shadow-xl p-6 hover-card gradient-border">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h2 class="text-xl font-black text-gray-900 dark:text-white">Recommended Jobs</h2>
                                    <p class="text-gray-600 dark:text-gray-300">Based on your skills and preferences</p>
                                </div>
                                <a href="{{ route('jobs.index') }}" 
                                   class="flex items-center text-primary-600 hover:text-primary-700 font-bold group">
                                    View all
                                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                                </a>
                            </div>
                            
                            @if(isset($recommendedJobs) && $recommendedJobs->count() > 0)
                            <div class="space-y-4">
                                @foreach($recommendedJobs as $job)
                                <div class="glass border border-gray-200 dark:border-gray-700 rounded-2xl p-5 hover:bg-primary-50 dark:hover:bg-gray-700/50 transition-all duration-300 hover-card">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center flex-wrap gap-2 mb-3">
                                                @if($job->is_urgent)
                                                <span class="px-3 py-1 bg-gradient-to-r from-red-500 to-pink-600 text-white text-xs font-bold rounded-full">
                                                    <i class="fas fa-bolt mr-1"></i> URGENT
                                                </span>
                                                @endif
                                                @if($job->is_featured)
                                                <span class="px-3 py-1 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold rounded-full">
                                                    <i class="fas fa-star mr-1"></i> FEATURED
                                                </span>
                                                @endif
                                                <span class="px-3 py-1 {{ $job->experience_badge_class }} text-xs font-bold rounded-full">
                                                    {{ strtoupper($job->experience_level) }}
                                                </span>
                                                @if($job->is_remote)
                                                <span class="px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold rounded-full">
                                                    <i class="fas fa-globe mr-1"></i> REMOTE
                                                </span>
                                                @endif
                                            </div>
                                            
                                            <h3 class="font-black text-lg text-gray-900 dark:text-white mb-2">{{ $job->title }}</h3>
                                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                <div class="flex items-center mr-4">
                                                    <div class="w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center mr-2">
                                                        <i class="fas fa-user text-primary-600 dark:text-primary-400 text-xs"></i>
                                                    </div>
                                                    <span>{{ $job->client->name ?? 'Client' }}</span>
                                                </div>
                                                <div class="flex items-center mr-4">
                                                    <div class="w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center mr-2">
                                                        <i class="fas fa-clock text-primary-600 dark:text-primary-400 text-xs"></i>
                                                    </div>
                                                    <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @if($job->skills_required)
                                                    @foreach(array_slice($job->skills_required, 0, 4) as $skill)
                                                    <span class="px-3 py-1.5 bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 rounded-lg text-sm font-medium">
                                                        {{ $skill }}
                                                    </span>
                                                    @endforeach
                                                    @if(count($job->skills_required) > 4)
                                                    <span class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg text-sm">
                                                        +{{ count($job->skills_required) - 4 }} more
                                                    </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="text-right ml-6">
                                            <div class="text-2xl font-black text-gray-900 dark:text-white mb-3">
                                                {{ $job->formatted_budget }}
                                            </div>
                                            <div class="space-y-3">
                                                <button onclick="showApplyModal('{{ $job->id }}', '{{ addslashes($job->title) }}')" 
                                                        class="px-5 py-2.5 btn-primary text-white rounded-xl text-sm font-bold hover:shadow-lg transition-all duration-300">
                                                    <i class="fas fa-paper-plane mr-2"></i> Apply Now
                                                </button>
                                                <button onclick="saveJob('{{ $job->id }}')" 
                                                        class="px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <i class="far fa-bookmark mr-2"></i> Save Job
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($job->deadline)
                                    <div class="flex items-center justify-between mt-5 pt-5 border-t border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center mr-3">
                                                <i class="fas fa-calendar-alt text-primary-600 dark:text-primary-400"></i>
                                            </div>
                                            <span>Deadline: {{ $job->deadline->format('M d, Y') }}</span>
                                            <span class="ml-3 px-2 py-1 bg-{{ $job->is_expired ? 'red' : 'green' }}-100 dark:bg-{{ $job->is_expired ? 'red' : 'green' }}-900/30 text-{{ $job->is_expired ? 'red' : 'green' }}-800 dark:text-{{ $job->is_expired ? 'red' : 'green' }}-300 rounded text-xs font-bold">
                                                {{ $job->time_left }} left
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <span class="mr-4">
                                                <i class="fas fa-eye mr-1"></i> {{ $job->views }} views
                                            </span>
                                            <span>
                                                <i class="fas fa-paper-plane mr-1"></i> {{ $job->proposals_count }} proposals
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-12">
                                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-r from-primary-100 to-primary-200 dark:from-primary-900/20 dark:to-primary-800/20 flex items-center justify-center">
                                    <i class="fas fa-briefcase text-4xl text-primary-500 dark:text-primary-400"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">No recommended jobs yet</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 max-w-md mx-auto">Complete your profile to get personalized job recommendations based on your skills and preferences.</p>
                                <a href="{{ route('profile.edit') }}" 
                                   class="inline-flex items-center px-6 py-3 btn-primary text-white rounded-xl font-bold hover:shadow-lg transition-all">
                                    <i class="fas fa-user-edit mr-2"></i> Complete Profile
                                </a>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Recent Activity -->
                        <div class="glass rounded-2xl shadow-xl p-6 hover-card">
                            <h2 class="text-xl font-black text-gray-900 dark:text-white mb-6">Recent Activity</h2>
                            <div class="space-y-4">
                                <!-- Activity items -->
                                @if(isset($activities) && $activities->count() > 0)
                                    @foreach($activities as $activity)
                                    <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 rounded-xl 
                                                @if($activity->status == 'accepted') bg-gradient-to-r from-green-500 to-teal-500
                                                @elseif($activity->status == 'pending') bg-gradient-to-r from-yellow-500 to-amber-500
                                                @else bg-gradient-to-r from-gray-500 to-gray-700 @endif
                                                flex items-center justify-center shadow-lg">
                                                <i class="fas 
                                                    @if($activity->status == 'accepted') fa-check
                                                    @elseif($activity->status == 'pending') fa-clock
                                                    @else fa-times @endif
                                                    text-white text-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <p class="font-bold text-gray-900 dark:text-white">
                                                    @if($activity->status == 'accepted')
                                                        Proposal Accepted 🎉
                                                    @elseif($activity->status == 'pending')
                                                        Proposal Submitted
                                                    @else
                                                        Proposal Updated
                                                    @endif
                                                </p>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-300">
                                                @if($activity->job)
                                                    Your proposal for "<span class="font-medium text-primary-600 dark:text-primary-400">"{{ $activity->job->title }}"</span>" 
                                                    @if($activity->status == 'accepted') was <span class="font-bold text-green-600">accepted</span>
                                                    @elseif($activity->status == 'pending') is <span class="font-bold text-yellow-600">pending review</span>
                                                    @else was <span class="font-bold text-gray-600">updated</span>
                                                    @endif
                                                @else
                                                    Proposal #{{ $activity->id }}
                                                @endif
                                            </p>
                                            @if($activity->job && $activity->status == 'accepted')
                                            <div class="mt-3">
                                                <a href="#" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                                    <i class="fas fa-external-link-alt mr-1"></i> View Contract Details
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <!-- No activities message -->
                                    <div class="text-center py-10">
                                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                            <i class="fas fa-inbox text-3xl text-gray-400 dark:text-gray-600"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2">No recent activity</h3>
                                        <p class="text-gray-500 dark:text-gray-400 mb-4">Apply to jobs to see your activity here</p>
                                        <a href="{{ route('jobs.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                            <i class="fas fa-search mr-2"></i> Browse Available Jobs
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="space-y-8">
                        <!-- Quick Profile -->
                        <div class="glass rounded-2xl shadow-xl p-6 hover-card">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center mr-3">
                                    <i class="fas fa-chart-line text-white"></i>
                                </div>
                                <h3 class="font-black text-gray-900 dark:text-white">Profile Analytics</h3>
                            </div>
                            <div class="space-y-5">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-gray-700 dark:text-gray-300 font-medium">Response Rate</span>
                                        <span class="font-black text-green-600 text-lg">92%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: 92%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-gray-700 dark:text-gray-300 font-medium">Avg. Response Time</span>
                                        <span class="font-black text-blue-600 text-lg">2.1h</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: 85%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-gray-700 dark:text-gray-300 font-medium">Job Success</span>
                                        <span class="font-black text-purple-600 text-lg">98%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full" style="width: 98%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-gray-700 dark:text-gray-300 font-medium">On-time Delivery</span>
                                        <span class="font-black text-yellow-600 text-lg">96%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 h-2 rounded-full" style="width: 96%"></div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}" 
                               class="block mt-6 text-center px-4 py-3 border-2 border-primary-500 text-primary-600 rounded-xl font-bold hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                <i class="fas fa-chart-line mr-2"></i> View Detailed Analytics
                            </a>
                        </div>
                        
                        <!-- Skills & Endorsements -->
                        <div class="glass rounded-2xl shadow-xl p-6 hover-card">
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center mr-3">
                                        <i class="fas fa-code text-white"></i>
                                    </div>
                                    <h3 class="font-black text-gray-900 dark:text-white">Top Skills</h3>
                                </div>
                                <button class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center hover:bg-primary-200 dark:hover:bg-primary-800/30">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="space-y-4">
                                @foreach(['Laravel', 'PHP', 'Vue.js', 'Tailwind CSS', 'MySQL'] as $skill)
                                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $skill }}</span>
                                    <div class="flex items-center">
                                        <div class="flex mr-3">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-sm {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }} mr-1"></i>
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-lg font-medium">24</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-6">
                                <a href="#" class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center justify-center">
                                    <i class="fas fa-arrow-right mr-2"></i> View All Skills
                                </a>
                            </div>
                        </div>
                        
                        <!-- Earnings Chart -->
                        <div class="glass rounded-2xl shadow-xl p-6 hover-card">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="font-black text-gray-900 dark:text-white">Earnings This Month</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Weekly breakdown</p>
                                </div>
                                <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 rounded-lg text-sm font-bold">
                                    $10,900
                                </span>
                            </div>
                            <div class="h-40 flex items-end space-x-3 mb-6">
    <div class="flex-1 flex flex-col items-center">
        <div class="w-full bg-gradient-to-t from-primary-500 to-primary-300 rounded-t-lg transition-all hover:opacity-90"
             style="height: 48%" data-tooltip="$1,200"></div>
        <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">Mon</span>
    </div>
    <div class="flex-1 flex flex-col items-center">
        <div class="w-full bg-gradient-to-t from-primary-500 to-primary-300 rounded-t-lg transition-all hover:opacity-90"
             style="height: 32%" data-tooltip="$800"></div>
        <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">Tue</span>
    </div>
    <div class="flex-1 flex flex-col items-center">
        <div class="w-full bg-gradient-to-t from-primary-500 to-primary-300 rounded-t-lg transition-all hover:opacity-90"
             style="height: 60%" data-tooltip="$1,500"></div>
        <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">Wed</span>
    </div>
    <div class="flex-1 flex flex-col items-center">
        <div class="w-full bg-gradient-to-t from-primary-500 to-primary-300 rounded-t-lg transition-all hover:opacity-90"
             style="height: 36%" data-tooltip="$900"></div>
        <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">Thu</span>
    </div>
    <div class="flex-1 flex flex-col items-center">
        <div class="w-full bg-gradient-to-t from-primary-500 to-primary-300 rounded-t-lg transition-all hover:opacity-90"
             style="height: 88%" data-tooltip="$2,200"></div>
        <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">Fri</span>
    </div>
    <div class="flex-1 flex flex-col items-center">
        <div class="w-full bg-gradient-to-t from-primary-500 to-primary-300 rounded-t-lg transition-all hover:opacity-90"
             style="height: 72%" data-tooltip="$1,800"></div>
        <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">Sat</span>
    </div>
    <div class="flex-1 flex flex-col items-center">
        <div class="w-full bg-gradient-to-t from-primary-500 to-primary-300 rounded-t-lg transition-all hover:opacity-90"
             style="height: 100%" data-tooltip="$2,500"></div>
        <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">Sun</span>
    </div>
</div>
                            <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-bold text-primary-600 text-lg">$10,900</span> total earnings
                                </p>
                                <p class="text-sm text-green-600 dark:text-green-400 mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i> 24% increase from last month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom Promotional Cards -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Boost Profile Card -->
                    <div class="bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 rounded-2xl p-6 text-white hover-card card-glow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-3">
                                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mr-4">
                                        <i class="fas fa-rocket text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-black text-xl">Boost Profile</h3>
                                        <p class="text-primary-100 text-sm mt-1">Get 3x more job invites</p>
                                    </div>
                                </div>
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                                        Top of search results
                                    </li>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                                        Priority client matching
                                    </li>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                                        Featured badge on profile
                                    </li>
                                </ul>
                            </div>
                            <div class="text-3xl font-black opacity-30">
                                <i class="fas fa-crown"></i>
                            </div>
                        </div>
                        <button class="w-full mt-4 py-3 bg-white text-primary-600 rounded-xl font-bold hover:bg-gray-100 hover:shadow-lg transition-all">
                            Upgrade to Premium
                        </button>
                    </div>
                    
                    <!-- Get Certified Card -->
                    <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 rounded-2xl p-6 text-white hover-card card-glow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-3">
                                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mr-4">
                                        <i class="fas fa-award text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-black text-xl">Get Certified</h3>
                                        <p class="text-blue-100 text-sm mt-1">Stand out from competition</p>
                                    </div>
                                </div>
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                                        Verified skill badges
                                    </li>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                                        Higher earning potential
                                    </li>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                                        Client trust & credibility
                                    </li>
                                </ul>
                            </div>
                            <div class="text-3xl font-black opacity-30">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        </div>
                        <button class="w-full mt-4 py-3 bg-white text-blue-600 rounded-xl font-bold hover:bg-gray-100 hover:shadow-lg transition-all">
                            Take Skill Tests
                        </button>
                    </div>
                    
                    <!-- Invite Friends Card -->
                    <div class="bg-gradient-to-br from-green-500 via-green-600 to-emerald-700 rounded-2xl p-6 text-white hover-card card-glow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-3">
                                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mr-4">
                                        <i class="fas fa-user-plus text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-black text-xl">Invite Friends</h3>
                                        <p class="text-green-100 text-sm mt-1">Earn $50 per referral</p>
                                    </div>
                                </div>
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                                        $50 for each successful referral
                                    </li>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                                        Friend gets $25 starting bonus
                                    </li>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check-circle mr-2 text-green-300"></i>
                                        No limit on referrals
                                    </li>
                                </ul>
                            </div>
                            <div class="text-3xl font-black opacity-30">
                                <i class="fas fa-gift"></i>
                            </div>
                        </div>
                        <button class="w-full mt-4 py-3 bg-white text-green-600 rounded-xl font-bold hover:bg-gray-100 hover:shadow-lg transition-all">
                            Invite Now & Earn
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Floating Action Button -->
    <button @click="showQuickActions = !showQuickActions"
            class="fixed right-6 bottom-6 w-16 h-16 btn-primary text-white rounded-full shadow-2xl flex items-center justify-center hover:shadow-3xl z-30 card-glow animate-bounce-slow">
        <i class="fas fa-bolt text-2xl"></i>
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
                    
                    // Simulate loading with improved animation
                    this.loading = true;
                    setTimeout(() => {
                        this.loading = false;
                        // Show welcome notification
                        setTimeout(() => {
                            this.showNotification('Welcome back to WorkNest! Your dashboard is ready.');
                        }, 500);
                    }, 1500);
                    
                    // Check for new notifications periodically
                    setInterval(() => {
                        // In real app, this would fetch from API
                        console.log('Checking for updates...');
                    }, 30000);
                    
                    // Initialize chart bars
                    this.initChartBars();
                },
                
                initChartBars() {
                    // Animate chart bars on load
                    setTimeout(() => {
                        document.querySelectorAll('[data-height]').forEach(bar => {
                            const height = bar.getAttribute('data-height');
                            bar.style.height = '0%';
                            setTimeout(() => {
                                bar.style.height = height + '%';
                            }, 100);
                        });
                    }, 1000);
                },
                
                toggleTheme() {
                    this.darkMode = !this.darkMode;
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('darkMode', 'true');
                        this.showNotification('Dark mode enabled');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('darkMode', 'false');
                        this.showNotification('Light mode enabled');
                    }
                },
                
                showNotification(message) {
                    this.toastMessage = message;
                    this.showToast = true;
                    setTimeout(() => {
                        this.showToast = false;
                    }, 4000);
                },
                
                applyToJob(jobId) {
                    this.showNotification('Opening application form...');
                    // In real app, this would show application modal
                    document.getElementById('applyForm').action = `/jobs/${jobId}/apply`;
                    document.getElementById('applyModal').classList.remove('hidden');
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
                        this.showNotification(data.message || 'Job saved successfully!');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.showNotification('Error saving job');
                    });
                }
            }
        }
        
        // Initialize animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Tooltip initialization
            const tooltips = document.querySelectorAll('[data-tooltip]');
            tooltips.forEach(el => {
                el.addEventListener('mouseenter', function(e) {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'fixed z-50 px-3 py-2 text-xs font-medium text-white bg-gray-900 rounded-lg shadow-lg';
                    tooltip.textContent = this.getAttribute('data-tooltip');
                    
                    // Position tooltip near cursor
                    tooltip.style.top = (e.clientY - 40) + 'px';
                    tooltip.style.left = (e.clientX - tooltip.offsetWidth/2) + 'px';
                    
                    document.body.appendChild(tooltip);
                    
                    // Store reference for cleanup
                    this._tooltip = tooltip;
                });
                
                el.addEventListener('mouseleave', function() {
                    if (this._tooltip) {
                        this._tooltip.remove();
                        this._tooltip = null;
                    }
                });
                
                el.addEventListener('mousemove', function(e) {
                    if (this._tooltip) {
                        this._tooltip.style.top = (e.clientY - 40) + 'px';
                        this._tooltip.style.left = (e.clientX - this._tooltip.offsetWidth/2) + 'px';
                    }
                });
            });
            
            // Initialize hover effects for cards
            const cards = document.querySelectorAll('.hover-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.zIndex = '10';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.zIndex = '1';
                });
            });
            
            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Add animation class to progress bars
                        const progressBar = entry.target.querySelector('.progress-bar');
                        if (progressBar) {
                            const width = progressBar.style.width || progressBar.getAttribute('style');
                            progressBar.style.width = '0%';
                            setTimeout(() => {
                                progressBar.style.width = width;
                            }, 300);
                        }
                        
                        // Add animation to cards
                        if (entry.target.classList.contains('hover-card')) {
                            entry.target.classList.add('animate-fade-in-up');
                        }
                        
                        // Once animated, unobserve
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            // Observe all cards and progress containers
            document.querySelectorAll('.hover-card, [class*="progress"]').forEach(el => {
                observer.observe(el);
            });
            
            // // Add click animation to buttons
            // document.querySelectorAll('button, a[href]').forEach(btn => {
            //     btn.addEventListener('click', function(e) {
            //         // Add ripple effect
            //         const ripple = document.createElement('span');
            //         const rect = this.getBoundingClientRect();
            //         const size = Math.max(rect.width, rect.height);
            //         const x = e.clientX - rect.left - size/2;
            //         const y = e.clientY - rect.top - size/2;
                    
            //         ripple.style.cssText = `
            //             position: absolute;
            //             border-radius: 50%;
            //             background: rgba(255, 255, 255, 0.7);
            //             transform: scale(0);
            //             animation: ripple 0.6s linear;
            //             width: ${size}px;
            //             height: ${size}px;
            //             top: ${y}px;
            //             left: ${x}px;
            //             pointer-events: none;
            //         `;
                    
            //         this.appendChild(ripple);
                    
            //         setTimeout(() => {
            //             ripple.remove();
            //         }, 600);
            //     });
            // });
            
            // Add ripple animation to CSS
            // const style = document.createElement('style');
            // style.textContent = `
            //     @keyframes ripple {
            //         to {
            //             transform: scale(4);
            //             opacity: 0;
            //         }
            //     }
            // `;
            // document.head.appendChild(style);
        });
    </script>
    
</body>
</html>