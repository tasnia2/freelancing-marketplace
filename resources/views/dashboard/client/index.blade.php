<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard | WorkNest</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Tailwind CSS (using CDN for now, you can replace with your build) -->
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
        /* Add to your existing CSS */
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

/* Style for search select dropdown */
select[name="type"] {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.5rem center;
    background-size: 1em;
    padding-right: 2.5rem;
}

.dark select[name="type"] {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
}

/* Search suggestions scrollbar */
#suggestionsList::-webkit-scrollbar {
    width: 6px;
}

#suggestionsList::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#suggestionsList::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.dark #suggestionsList::-webkit-scrollbar-track {
    background: #374151;
}

.dark #suggestionsList::-webkit-scrollbar-thumb {
    background: #4b5563;
}
    </style>
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
                         <!-- <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 flex items-center justify-center group-hover:rotate-12 transition-all duration-500 shadow-lg">
                        <i class="fas fa-handshake text-white text-xl"></i>
                        </div> -->
                        <span class="text-2xl font-bold bg-gradient-to-r from-[#1B3C53] to-[#456882] bg-clip-text text-transparent">
                            WorkNest
                        </span>
                    </div>
                </div>

                <!-- Search Bar -->
<div class="hidden md:flex flex-1 max-w-lg mx-6">
    <div class="relative w-full">
        <form action="{{ route('search.results') }}" method="GET" class="relative">
            <input type="text" 
                   name="q"
                   placeholder="Search jobs, freelancers, skills..." 
                   class="w-full pl-10 pr-24 py-2 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-[#456882] transition-all"
                   value="{{ request('q') }}"
                   id="searchInput">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            
            <!-- Search Options -->
            <div class="absolute right-1 top-1/2 transform -translate-y-1/2 flex items-center space-x-2">
                <select name="type" 
                        class="text-sm bg-transparent border-none focus:outline-none text-gray-500 dark:text-gray-400 appearance-none pr-6 cursor-pointer">
                    <option value="all">All</option>
                    <option value="jobs" {{ request('type') == 'jobs' ? 'selected' : '' }}>Jobs</option>
                    <option value="freelancers" {{ request('type') == 'freelancers' ? 'selected' : '' }}>Freelancers</option>
                    <option value="skills" {{ request('type') == 'skills' ? 'selected' : '' }}>Skills</option>
                </select>
                <button type="submit" 
                        class="px-3 py-1 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white text-sm rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all">
                    Search
                </button>
            </div>
        </form>
        
        <!-- Quick Browse Link
        <div class="absolute -bottom-8 left-0 right-0 flex justify-center">
            <a href="{{ route('client.freelancers') }}" 
               class="text-xs text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white flex items-center space-x-1 bg-white dark:bg-gray-800 px-3 py-1 rounded-lg shadow-sm hover:shadow transition-all">
                <i class="fas fa-users"></i>
                <span>Browse Talent</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div> -->
        
        <!-- Search Suggestions Dropdown -->
        <div id="searchSuggestions" class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 hidden z-50">
            <div class="p-3 border-b border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Recent Searches</span>
                    <button onclick="clearRecentSearches()" class="text-xs text-gray-400 hover:text-gray-600">Clear</button>
                </div>
            </div>
            <div id="suggestionsList" class="max-h-60 overflow-y-auto">
                <!-- Suggestions will be loaded here via JavaScript -->
            </div>
            <div class="p-3 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('client.freelancers') }}" class="flex items-center justify-between text-sm text-[#456882] hover:text-[#1B3C53]">
                    <span class="flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        Browse all freelancers
                    </span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-6">
                    <a href="#" class="hidden lg:flex items-center space-x-1 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    
                    <a href="{{ route('client.jobs') }}" class="hidden lg:flex items-center space-x-1 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                        <i class="fas fa-briefcase"></i>
                        <span>My Jobs</span>
                    </a>
                    
                    <a href="{{ route('client.contracts') }}" class="hidden lg:flex items-center space-x-1 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                        <i class="fas fa-file-contract"></i>
                        <span>Contracts</span>
                    </a>
                    
                    <!-- <a href="#" class="hidden lg:flex items-center space-x-1 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                        <i class="fas fa-search"></i>
                        <span>Find Talent</span>
                    </a> -->

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

                    <!-- Messages -->
                    <div class="relative">
                        <a href="{{ route('messages.index') }}" class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                            <i class="fas fa-envelope text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-green-500 rounded-full"></span>
                        </a>
                    </div>

                    <!-- User Menu -->
                    <div class="relative">
                        <button id="userMenuBtn" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#1B3C53] to-[#456882] flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Client</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 py-2">
                            <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-user mr-3 text-gray-400"></i>
                                Profile
                            </a>
                            <a href="{{ route('client.settings') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-cog mr-3 text-gray-400"></i>
                                Settings
                            </a>
                            <!-- <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-credit-card mr-3 text-gray-400"></i>
                                Billing
                            </a> -->
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
                <a href="#" class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] py-2">
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
                <!-- <a href="#" class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 hover:text-[#234C6A] dark:hover:text-[#456882] py-2">
                    <i class="fas fa-search w-5"></i>
                    <span>Find Talent</span>
                </a> -->
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20 pb-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <!-- Welcome Section -->
            <div class="mb-8 animate-slide-in">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-[#1B3C53] via-[#234C6A] to-[#456882] bg-clip-text text-transparent">
                            Welcome back, {{ Auth::user()->name }}!
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Here's what's happening with your projects today.</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative group">
                            <button class="px-4 py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-xl hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                                <i class="fas fa-plus"></i>
                                <span>Post New Job</span>
                            </button>
                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                Hire freelancers
                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                    <div class="w-2 h-2 bg-gray-800 rotate-45"></div>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <button id="themeToggle" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-sun dark:hidden"></i>
                                <i class="fas fa-moon hidden dark:block"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach([
                    [
                        'title' => 'Posted Jobs',
                        'value' => $stats['posted_jobs'],
                        'icon' => 'briefcase',
                        'color' => 'from-[#1B3C53] to-[#234C6A]',
                        'detail' => ['label' => 'Active', 'value' => $stats['active_jobs']]
                    ],
                    [
                        'title' => 'Total Proposals',
                        'value' => $stats['total_proposals'],
                        'icon' => 'file-alt',
                        'color' => 'from-[#456882] to-[#3A5A72]',
                        'detail' => ['label' => 'Pending', 'value' => $stats['pending_proposals']]
                    ],
                    [
                        'title' => 'Total Spent',
                        'value' => '$' . number_format($stats['total_spent'], 0),
                        'icon' => 'wallet',
                        'color' => 'from-[#234C6A] to-[#1B3C53]',
                        'detail' => ['label' => 'Hired Freelancers', 'value' => $stats['hired_freelancers']]
                    ]
                ] as $card)
                <div class="stats-card rounded-2xl p-6 text-white shadow-xl floating-card">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[#E3E3E3] text-sm">{{ $card['title'] }}</p>
                            <h3 class="text-3xl font-bold mt-2">{{ $card['value'] }}</h3>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                            <i class="fas fa-{{ $card['icon'] }} text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#E3E3E3]">{{ $card['detail']['label'] }}</span>
                            <span class="font-semibold">{{ $card['detail']['value'] }}</span>
                        </div>
                    </div>
                    <!-- Floating particles -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
                    <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-white/5 rounded-full blur-lg"></div>
                </div>
                @endforeach
            </div>

            <!-- Charts and Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Job Activity Chart -->
                <div class="lg:col-span-2 gradient-border rounded-2xl p-6 shadow-lg floating-card bg-white dark:bg-gray-800">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-[#1B3C53] to-[#234C6A] flex items-center justify-center text-white mr-3">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            Job Activity (Last 6 Months)
                        </h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 text-sm rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">Monthly</button>
                            <button class="px-3 py-1 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">Quarterly</button>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="jobChart"></canvas>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="gradient-border rounded-2xl p-6 shadow-lg floating-card bg-white dark:bg-gray-800">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-[#456882] to-[#3A5A72] flex items-center justify-center text-white mr-3">
                            <i class="fas fa-bolt"></i>
                        </div>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        @foreach([
                            ['route' => 'client.jobs.create', 'icon' => 'plus', 'title' => 'Post New Job', 'desc' => 'Hire freelancers', 'color' => '#1B3C53'],
                            ['route' => 'client.proposals', 'icon' => 'file-alt', 'title' => 'Review Proposals', 'desc' => $stats['pending_proposals'] . ' pending', 'color' => '#234C6A'],
                            ['route' => 'client.contracts', 'icon' => 'file-contract', 'title' => 'Active Contracts', 'desc' => count($activeContracts) . ' ongoing', 'color' => '#456882'],
                            ['route' => 'client.freelancers', 'icon' => 'search', 'title' => 'Find Freelancers', 'desc' => 'Browse talent', 'color' => 'from-[#1B3C53] to-[#456882]']
                        ] as $action)
                        <a href="{{ route($action['route']) }}" 
                           class="flex items-center p-3 bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-xl hover:from-[#456882] hover:to-[#234C6A] hover:text-white transition-all duration-300 group relative overflow-hidden">
                            <div class="relative z-10 flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white mr-3 transition-all duration-300 group-hover:bg-white group-hover:scale-110"
                                     style="background:' {{ str_contains($action['color'], 'from') ? 'linear-gradient(135deg, ' . $action['color'] . ')' : $action['color'] }}'">
                                    <i class="fas fa-{{ $action['icon'] }}"></i>
                                </div>
                                <div>
                                    <p class="font-medium transition-colors duration-300">{{ $action['title'] }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-300 transition-colors duration-300">{{ $action['desc'] }}</p>
                                </div>
                            </div>
                            <!-- Hover effect background -->
                            <div class="absolute inset-0 bg-gradient-to-r from-[#456882] to-[#234C6A] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Activity Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Recent Jobs -->
                <div class="gradient-border rounded-2xl p-6 shadow-lg floating-card bg-white dark:bg-gray-800">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-[#1B3C53] to-[#234C6A] flex items-center justify-center text-white mr-3">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            Recent Jobs
                        </h3>
                        <a href="{{ route('client.jobs') }}" class="text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white flex items-center">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentJobs as $job)
                        <div class="p-3 rounded-xl border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300 group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <a href="{{ route('jobs.show', $job) }}" 
                                       class="font-medium text-gray-800 dark:text-white hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors group-hover:translate-x-1 inline-block">
                                        {{ Str::limit($job->title, 35) }}
                                    </a>
                                    <div class="flex items-center mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="px-2 py-1 rounded-full text-xs {{ $job->status === 'open' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' }}">
                                            {{ str_replace('_', ' ', ucfirst($job->status)) }}
                                        </span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $job->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-[#234C6A] dark:text-[#456882] group-hover:scale-110 transition-transform">
                                        {{ $job->formatted_budget ?? 'Fixed' }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $job->pending_proposals_count }} proposals
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-[#E3E3E3] to-gray-300 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                                <i class="fas fa-inbox text-2xl"></i>
                            </div>
                            <p>No jobs posted yet</p>
                            <a href="{{ route('client.jobs.create') }}" class="text-[#456882] hover:text-[#1B3C53] mt-2 inline-flex items-center">
                                Post your first job <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Proposals -->
                <div class="gradient-border rounded-2xl p-6 shadow-lg floating-card bg-white dark:bg-gray-800">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-[#234C6A] to-[#456882] flex items-center justify-center text-white mr-3">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            Recent Proposals
                        </h3>
                        <a href="{{ route('client.proposals') }}" class="text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white flex items-center">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentProposals as $proposal)
                        <div class="p-3 rounded-xl border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300 group">
                            <div class="flex items-start">
                                <div class="relative">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white mr-3 group-hover:scale-110 transition-transform">
                                        {{ substr($proposal->freelancer->name, 0, 1) }}
                                    </div>
                                    @if($proposal->status === 'accepted')
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <a href="{{ route('client.proposals.show', $proposal) }}" 
                                           class="font-medium text-gray-800 dark:text-white hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                                            {{ $proposal->freelancer->name }}
                                        </a>
                                        <div class="text-lg font-bold text-[#234C6A] dark:text-[#456882] group-hover:scale-110 transition-transform">
                                            ${{ number_format($proposal->bid_amount, 0) }}
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        For: {{ Str::limit($proposal->job->title, 25) }}
                                    </p>
                                    <div class="flex items-center mt-2 text-xs">
                                        <span class="px-2 py-1 rounded-full {{ $proposal->getStatusBadgeAttribute() }} inline-flex items-center">
                                            <span class="w-2 h-2 rounded-full mr-1 {{ $proposal->status === 'pending' ? 'bg-yellow-500' : ($proposal->status === 'accepted' ? 'bg-green-500' : 'bg-red-500') }}"></span>
                                            {{ ucfirst($proposal->status) }}
                                        </span>
                                        <span class="mx-2 text-gray-400">•</span>
                                        <span class="text-gray-500">{{ $proposal->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-[#E3E3E3] to-gray-300 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                                <i class="fas fa-file-alt text-2xl"></i>
                            </div>
                            <p>No proposals yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Active Contracts -->
                <div class="gradient-border rounded-2xl p-6 shadow-lg floating-card bg-white dark:bg-gray-800">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-[#456882] to-[#3A5A72] flex items-center justify-center text-white mr-3">
                                <i class="fas fa-file-contract"></i>
                            </div>
                            Active Contracts
                        </h3>
                        <a href="{{ route('client.contracts') }}" class="text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white flex items-center">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($activeContracts as $contract)
                        <div class="p-3 rounded-xl border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300 group">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <a href="{{ route('client.contracts.show', $contract) }}" 
                                       class="font-medium text-gray-800 dark:text-white hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                                        {{ Str::limit($contract->title, 30) }}
                                    </a>
                                    <div class="mt-2">
                                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                                            <span>Progress</span>
                                            <span>{{ $contract->getProgressPercentage() }}%</span>
                                        </div>
                                        <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-[#1B3C53] to-[#456882] rounded-full progress-bar" 
                                                 data-progress="{{ $contract->getProgressPercentage() }}"
                                                 style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#E3E3E3] to-gray-300 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center text-gray-600 dark:text-gray-400 mr-2">
                                        {{ substr($contract->freelancer->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $contract->freelancer->name }}</span>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-[#234C6A] dark:text-[#456882] group-hover:scale-110 transition-transform">
                                        ${{ number_format($contract->amount, 0) }}
                                    </div>
                                    <div class="text-xs {{ $contract->daysRemaining() > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        @if($contract->daysRemaining() > 0)
                                            {{ $contract->daysRemaining() }} days left
                                        @else
                                            Overdue
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-[#E3E3E3] to-gray-300 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                                <i class="fas fa-file-contract text-2xl"></i>
                            </div>
                            <p>No active contracts</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Notifications Section -->
            <div class="gradient-border rounded-2xl p-6 shadow-lg floating-card bg-white dark:bg-gray-800 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-[#456882] to-[#3A5A72] flex items-center justify-center text-white mr-3">
                            <i class="fas fa-bell"></i>
                        </div>
                        Recent Notifications
                    </h3>
                    <div class="flex items-center space-x-4">
                        <button onclick="markAllAsRead()" class="text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white">
                            Mark all as read
                        </button>
                        <a href="#" class="text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white flex items-center">
                            See All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                    @forelse($notifications as $notification)
                    <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300 {{ !$notification->read ? 'bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20' : '' }} group">
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 transition-transform group-hover:scale-110
                                {{ $notification->type === 'new_proposal' ? 'bg-green-100 text-green-600' : 
                                   ($notification->type === 'contract_created' ? 'bg-blue-100 text-blue-600' : 
                                   ($notification->type === 'message_received' ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-600')) }}">
                                <i class="fas 
                                    {{ $notification->type === 'new_proposal' ? 'fa-file-alt' : 
                                       ($notification->type === 'contract_created' ? 'fa-file-contract' : 
                                       ($notification->type === 'message_received' ? 'fa-comment' : 'fa-bell')) }}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-medium text-gray-800 dark:text-white truncate">{{ $notification->title }}</h4>
                                    <span class="text-xs text-gray-500 whitespace-nowrap ml-2">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 truncate">{{ $notification->message }}</p>
                                <div class="flex items-center mt-2">
                                    @if(!$notification->read)
                                    <span class="inline-block w-2 h-2 bg-red-500 rounded-full mr-2 notification-dot"></span>
                                    <span class="text-xs text-red-600 dark:text-red-400">Unread</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-r from-[#E3E3E3] to-gray-300 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                            <i class="fas fa-bell-slash text-3xl"></i>
                        </div>
                        <p class="text-lg mb-2">All caught up!</p>
                        <p class="text-sm">No new notifications</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#1B3C53] to-[#456882] flex items-center justify-center">
                            <i class="fas fa-dove text-white"></i>
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

    <!-- JavaScript -->
    <script>
        // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle dropdowns
            setupDropdown('notificationBtn', 'notificationDropdown');
            setupDropdown('userMenuBtn', 'userDropdown');
            
            // Mobile menu toggle
            document.getElementById('mobileMenuBtn').addEventListener('click', function() {
                document.getElementById('mobileMenu').classList.toggle('hidden');
            });
            
            // Theme toggle
            document.getElementById('themeToggle').addEventListener('click', function() {
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
            
            // Animate progress bars
            animateProgressBars();
            
            // Initialize job chart
            initializeJobChart();
            
            // Setup hover animations
            setupHoverAnimations();
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
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function() {
                    dropdown.classList.add('hidden');
                });
            }
        }

        // Animate progress bars
        function animateProgressBars() {
            document.querySelectorAll('.progress-bar').forEach(bar => {
                let progress = parseInt(bar.dataset.progress, 10);
                progress = Math.max(0, Math.min(100, progress));
                
                setTimeout(() => {
                    bar.style.width = progress + '%';
                    bar.style.transition = 'width 1.2s cubic-bezier(0.34, 1.56, 0.64, 1)';
                }, 300);
            });
        }

        // Initialize job chart
        function initializeJobChart() {
            const ctx = document.getElementById('jobChart').getContext('2d');
            const jobChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode(isset($chartData) && is_array($chartData) ? array_column($chartData, 'month') : []); ?>,
                    datasets: [{
                        label: 'Jobs Posted',
                        data: <?php echo json_encode(isset($chartData) && is_array($chartData) ? array_column($chartData, 'jobs') : []); ?>,
                        borderColor: '#1B3C53',
                        backgroundColor: 'rgba(27, 60, 83, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#234C6A',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(27, 60, 83, 0.9)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#456882',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        }
                    }
                }
            });
            
            // Update chart theme on dark mode toggle
            const updateChartTheme = () => {
                const isDark = document.documentElement.classList.contains('dark');
                jobChart.options.scales.x.grid.color = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
                jobChart.options.scales.y.grid.color = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
                jobChart.update();
            };
            
            // Listen for dark mode changes
            const darkModeObserver = new MutationObserver(updateChartTheme);
            darkModeObserver.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
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

        // Mark all notifications as read
        function markAllAsRead() {
            fetch('/api/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    document.querySelectorAll('.notification-dot').forEach(dot => dot.remove());
                    document.querySelectorAll('.bg-gradient-to-r.from-blue-50').forEach(div => {
                        div.classList.remove('bg-gradient-to-r', 'from-blue-50', 'to-indigo-50', 'dark:from-blue-900/20', 'dark:to-indigo-900/20');
                    });
                    
                    // Show success message
                    showToast('All notifications marked as read', 'success');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to mark notifications as read', 'error');
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

        // Real-time notification updates
        function updateNotificationCount() {
            fetch('/api/notifications/unread-count')
                .then(response => response.json())
                .then(data => {
                    const badge = document.querySelector('.notification-badge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                });
        }
        // Add to your existing JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchSuggestions = document.getElementById('searchSuggestions');
    const suggestionsList = document.getElementById('suggestionsList');
    
    if (searchInput) {
        // Load recent searches
        loadRecentSearches();
        
        // Show/hide suggestions
        searchInput.addEventListener('focus', function() {
            searchSuggestions.classList.remove('hidden');
        });
        
        searchInput.addEventListener('blur', function() {
            // Hide suggestions after a delay (to allow clicking on them)
            setTimeout(() => {
                searchSuggestions.classList.add('hidden');
            }, 200);
        });
        
        // Real-time search suggestions
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            if (query.length > 1) {
                fetchSearchSuggestions(query);
            } else {
                loadRecentSearches();
            }
        });
        
        // Keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchSuggestions.classList.add('hidden');
            }
        });
    }
});

function loadRecentSearches() {
    const recentSearches = JSON.parse(localStorage.getItem('worknest_recent_searches') || '[]');
    const suggestionsList = document.getElementById('suggestionsList');
    
    if (recentSearches.length > 0) {
        suggestionsList.innerHTML = recentSearches.map(search => `
            <a href="/search?q=${encodeURIComponent(search.query)}&type=${search.type}" 
               class="flex items-center justify-between p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <div class="flex items-center">
                    <i class="fas fa-clock text-gray-400 mr-3"></i>
                    <div>
                        <p class="text-gray-800 dark:text-white">${search.query}</p>
                        <p class="text-xs text-gray-500 capitalize">${search.type}</p>
                    </div>
                </div>
                <i class="fas fa-arrow-right text-gray-400"></i>
            </a>
        `).join('');
    } else {
        suggestionsList.innerHTML = `
            <div class="p-6 text-center text-gray-500">
                <i class="fas fa-search text-2xl mb-2"></i>
                <p>No recent searches</p>
            </div>
        `;
    }
}

function fetchSearchSuggestions(query) {
    fetch(`/api/search/suggestions?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            const suggestionsList = document.getElementById('suggestionsList');
            
            if (data.suggestions && data.suggestions.length > 0) {
                suggestionsList.innerHTML = data.suggestions.map(suggestion => `
                    <a href="${suggestion.url}" 
                       class="flex items-center justify-between p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-lg mr-3 flex items-center justify-center ${getSuggestionIconClass(suggestion.type)}">
                                <i class="${getSuggestionIcon(suggestion.type)}"></i>
                            </div>
                            <div>
                                <p class="text-gray-800 dark:text-white">${suggestion.title}</p>
                                <p class="text-xs text-gray-500 capitalize">${suggestion.type}</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400"></i>
                    </a>
                `).join('');
            } else {
                suggestionsList.innerHTML = `
                    <div class="p-6 text-center text-gray-500">
                        <i class="fas fa-search text-2xl mb-2"></i>
                        <p>No results found for "${query}"</p>
                        <a href="{{ route('client.freelancers') }}" class="text-[#456882] hover:text-[#1B3C53] mt-2 inline-block">
                            Browse all freelancers
                        </a>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error fetching suggestions:', error);
        });
}

function getSuggestionIcon(type) {
    const icons = {
        'job': 'fa-briefcase',
        'freelancer': 'fa-user-tie',
        'skill': 'fa-tag',
        'category': 'fa-folder'
    };
    return icons[type] || 'fa-search';
}

function getSuggestionIconClass(type) {
    const classes = {
        'job': 'bg-blue-100 text-blue-600',
        'freelancer': 'bg-green-100 text-green-600',
        'skill': 'bg-purple-100 text-purple-600',
        'category': 'bg-orange-100 text-orange-600'
    };
    return classes[type] || 'bg-gray-100 text-gray-600';
}

function saveToRecentSearches(query, type) {
    let recentSearches = JSON.parse(localStorage.getItem('worknest_recent_searches') || '[]');
    
    // Remove if already exists
    recentSearches = recentSearches.filter(s => s.query !== query);
    
    // Add to beginning
    recentSearches.unshift({
        query: query,
        type: type,
        timestamp: new Date().toISOString()
    });
    
    // Keep only last 5 searches
    recentSearches = recentSearches.slice(0, 5);
    
    localStorage.setItem('worknest_recent_searches', JSON.stringify(recentSearches));
}

function clearRecentSearches() {
    localStorage.removeItem('worknest_recent_searches');
    loadRecentSearches();
}

// Handle form submission to save recent searches
document.querySelector('form[action*="search"]')?.addEventListener('submit', function(e) {
    const searchInput = document.getElementById('searchInput');
    const typeSelect = this.querySelector('select[name="type"]');
    
    if (searchInput.value.trim()) {
        saveToRecentSearches(searchInput.value.trim(), typeSelect.value);
    }
});

        // Update every 30 seconds
        setInterval(updateNotificationCount, 30000);
    </script>
</body>
</html>