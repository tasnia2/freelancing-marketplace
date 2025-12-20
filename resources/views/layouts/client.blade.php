<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Client Dashboard | WorkNest')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-dark: #1B3C53;
            --primary: #234C6A;
            --primary-light: #456882;
            --light-bg: #E3E3E3;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Custom Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes slideIn {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Custom Classes */
        .animate-slide-in {
            animation: slideIn 0.6s ease-out forwards;
        }

        .stats-card {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #1B3C53, #234C6A, #456882);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }

        .stats-card:nth-child(2) {
            background: linear-gradient(135deg, #456882, #3A5A72, #2D4B5F);
            background-size: 200% 200%;
        }

        .stats-card:nth-child(3) {
            background: linear-gradient(135deg, #234C6A, #1B3C53, #152935);
            background-size: 200% 200%;
        }

        .floating-card {
            transition: var(--transition);
            box-shadow: 0 4px 20px rgba(27, 60, 83, 0.08);
        }

        .floating-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 20px 40px rgba(27, 60, 83, 0.15);
        }

        .gradient-border {
            position: relative;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #1B3C53, #456882) border-box;
            border: 2px solid transparent;
        }

        .dark .gradient-border {
            background: linear-gradient(#1f2937, #1f2937) padding-box,
                        linear-gradient(135deg, #1B3C53, #456882) border-box;
        }

        .notification-dot {
            animation: pulseGlow 2s infinite;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
        }

        .progress-bar {
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
            animation: shimmer 2s infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glass-effect {
            background: rgba(31, 41, 55, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #1B3C53, #456882);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #234C6A, #3A5A72);
        }
        
        /* Search suggestions */
        #searchSuggestions {
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="text-gray-800 dark:bg-gray-900 dark:text-white transition-colors duration-300">
    
    <!-- Navigation Bar -->
    <nav class="glass-effect fixed top-0 left-0 right-0 z-50 border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#1B3C53] to-[#456882] flex items-center justify-center">
                            <i class="fas fa-handshake text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-[#1B3C53] to-[#456882] bg-clip-text text-transparent">
                            WorkNest
                        </span>
                    </div>
                </div>

                <!-- Search Bar (Optional - can be included in specific pages) -->
                @hasSection('search-bar')
                    @yield('search-bar')
                @endif

                <!-- Navigation Links -->
                <div class="flex items-center space-x-6">
                   {{-- Update lines 215-232 in client.layout.blade.php --}}
<a href="{{ route('client.dashboard') }}" class="hidden lg:flex items-center space-x-1 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors {{ request()->routeIs('client.dashboard') ? 'text-[#234C6A] dark:text-[#456882] font-semibold' : '' }}">
    <i class="fas fa-home"></i>
    <span>Dashboard</span>
</a>

<a href="{{ route('client.jobs') }}" class="hidden lg:flex items-center space-x-1 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors {{ request()->routeIs('client.jobs*') ? 'text-[#234C6A] dark:text-[#456882] font-semibold' : '' }}">
    <i class="fas fa-briefcase"></i>
    <span>My Jobs</span>
</a>

<a href="{{ route('client.contracts') }}" class="hidden lg:flex items-center space-x-1 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors {{ request()->routeIs('client.contracts*') ? 'text-[#234C6A] dark:text-[#456882] font-semibold' : '' }}">
    <i class="fas fa-file-contract"></i>
    <span>Contracts</span>
</a>

<a href="{{ route('client.freelancers') }}" class="hidden lg:flex items-center space-x-1 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors {{ request()->routeIs('client.freelancers*') ? 'text-[#234C6A] dark:text-[#456882] font-semibold' : '' }}">
    <i class="fas fa-users"></i>
    <span>Find Talent</span>
</a>

                    <!-- Notifications -->
                    <div class="relative">
                        <button id="notificationBtn" class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                            @auth
                                @php
                                    $unreadCount = auth()->user()->unreadNotifications()->count();
                                @endphp
                                @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center notification-dot">
                                    {{ min($unreadCount, 9) }}{{ $unreadCount > 9 ? '+' : '' }}
                                </span>
                                @endif
                            @endauth
                        </button>
                        
                    
                    </div>

                    <!-- Messages -->
                    <div class="relative">
                        <a href="{{ route('messages.index') }}" class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                            <i class="fas fa-envelope text-xl"></i>
                            @php
                                $unreadMessages = \App\Models\Message::where('receiver_id', auth()->id())
                                    ->whereNull('read_at')
                                    ->count();
                            @endphp
                            @if($unreadMessages > 0)
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-green-500 rounded-full"></span>
                            @endif
                        </a>
                    </div>

                    <!-- User Menu -->
                    <div class="relative">
                        <button id="userMenuBtn" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#1B3C53] to-[#456882] flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Client</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-user mr-3 text-gray-400"></i>
                                Profile
                            {{-- In the user dropdown section --}}
<a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
    <i class="fas fa-user mr-3 text-gray-400"></i>
    Profile
</a>
<a href="{{ route('client.settings') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
    <i class="fas fa-cog mr-3 text-gray-400"></i>
    Settings
</a>
<a href="{{ route('client.financial') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
    <i class="fas fa-credit-card mr-3 text-gray-400"></i>
    Financial
</a>
                            <hr class="my-2 border-gray-200 dark:border-gray-700">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button id="mobileMenuBtn" class="md:hidden p-2 text-gray-600 dark:text-gray-300">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4 py-3 space-y-3">
                {{-- In the mobile menu section --}}
<a href="{{ route('client.dashboard') }}" class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] py-2">
    <i class="fas fa-home w-5"></i>
    <span>Dashboard</span>
</a>
<a href="{{ route('client.jobs') }}" class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] py-2">
    <i class="fas fa-briefcase w-5"></i>
    <span>My Jobs</span>
</a>
<a href="{{ route('client.contracts') }}" class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] py-2">
    <i class="fas fa-file-contract w-5"></i>
    <span>Contracts</span>
</a>
<a href="{{ route('client.freelancers') }}" class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] py-2">
    <i class="fas fa-users w-5"></i>
    <span>Find Talent</span>
</a>
                <hr class="border-gray-200 dark:border-gray-700">
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] py-2">
                    <i class="fas fa-user w-5"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('client.settings') }}" class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] py-2">
                    <i class="fas fa-cog w-5"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20 pb-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            @hasSection('page-header')
                @yield('page-header')
            @else
                <!-- Default Header -->
                <div class="mb-8 animate-slide-in">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-[#1B3C53] via-[#234C6A] to-[#456882] bg-clip-text text-transparent">
                                @yield('page-title', 'Contract')
                            </h1>
                           
                        </div>
                        <div class="flex items-center space-x-4">
                            @hasSection('header-actions')
                                @yield('header-actions')
                            @endif
                            <div class="relative">
                                <button id="themeToggle" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-sun dark:hidden"></i>
                                    <i class="fas fa-moon hidden dark:block"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-400 mr-3"></i>
                        <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 mr-3"></i>
                        <span class="text-red-800 dark:text-red-200">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Main Content Area -->
            @yield('content')
        </div>
    </main>

    <!-- Footer (Optional - can be disabled in specific pages) -->
    @hasSection('hide-footer')
    @else
    <footer class="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#1B3C53] to-[#456882] flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800 dark:text-white">WorkNest</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        Connecting businesses with top freelance talent worldwide.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-semibold text-gray-800 dark:text-white mb-4">For Clients</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#456882]">How to Hire</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#456882]">Pricing</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#456882]">Client Resources</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold text-gray-800 dark:text-white mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#456882]">About Us</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#456882]">Careers</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#456882]">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold text-gray-800 dark:text-white mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#456882]">Help Center</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#456882]">Community</a></li>
                        <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-[#456882]">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-800 mt-8 pt-8 text-center text-sm text-gray-600 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} WorkNest. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @endif

    <!-- JavaScript -->
    <script>
        // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle dropdowns
            setupDropdown('notificationBtn', 'notificationDropdown');
            setupDropdown('userMenuBtn', 'userDropdown');
            
            // Mobile menu toggle
            document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
                document.getElementById('mobileMenu').classList.toggle('hidden');
            });
            
            // Theme toggle
            document.getElementById('themeToggle')?.addEventListener('click', function() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            });
            
            // Check saved theme
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            }
            
            // Setup hover animations
            setupHoverAnimations();
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.relative')) {
                    hideAllDropdowns();
                }
            });
        });

        // Function to setup dropdown toggles
        function setupDropdown(buttonId, dropdownId) {
            const button = document.getElementById(buttonId);
            const dropdown = document.getElementById(dropdownId);
            
            if (button && dropdown) {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                    
                    // Close other dropdowns
                    const allDropdowns = document.querySelectorAll('[id$="Dropdown"]');
                    allDropdowns.forEach(d => {
                        if (d.id !== dropdownId && !d.classList.contains('hidden')) {
                            d.classList.add('hidden');
                        }
                    });
                });
            }
        }

        function hideAllDropdowns() {
            document.querySelectorAll('[id$="Dropdown"]').forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
        }

        // Setup hover animations
        function setupHoverAnimations() {
            document.querySelectorAll('.floating-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.01)';
                    this.style.boxShadow = '0 20px 40px rgba(27, 60, 83, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = '0 10px 20px rgba(27, 60, 83, 0.08)';
                });
            });
        }

        // Show toast message
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } transform translate-x-full transition-transform duration-300 z-50`;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 10);
            
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Mark all notifications as read
        function markAllAsRead() {
            fetch('/api/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    document.querySelectorAll('.notification-dot').forEach(dot => dot.remove());
                    showToast('All notifications marked as read', 'success');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to mark notifications as read', 'error');
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>