<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WorkNest - Freelance Marketplace</title>
    
    <!-- Tailwind CSS with dark mode -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
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
                        },
                        'slide-in': {
                            '0%': { transform: 'translateX(-100px)', opacity: 0 },
                            '100%': { transform: 'translateX(0)', opacity: 1 }
                        }
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))'
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --accent: #f56565;
            --light: #f8fafc;
            --dark: #0f172a;
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Dark mode styles */
        .dark {
            background-color: #0f172a;
            color: #f1f5f9;
        }
        
        .dark .bg-white {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
        }
        
        .dark .bg-gray-50 {
            background-color: #1e293b !important;
        }
        
        .dark .text-gray-800 {
            color: #f1f5f9 !important;
        }
        
        .dark .text-gray-600 {
            color: #94a3b8 !important;
        }
        
        .dark .border-gray-200 {
            border-color: #334155 !important;
        }
        
        /* Custom animations */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite linear;
        }
        
        .dark .shimmer {
            background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%);
            background-size: 1000px 100%;
        }
        
        /* Glass effect */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .dark .glass {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(90deg, #667eea, #764ba2, #f56565);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Hover effects */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .dark .hover-lift:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        
        .dark ::-webkit-scrollbar-track {
            background: #334155;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #764ba2, #667eea);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Floating Background Particles -->
    <div id="particles-bg" class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <!-- Particles will be generated by JavaScript -->
    </div>
    
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg sticky top-0 z-50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center p-1 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                            <i class="fas fa-handshake text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                            Work<span class="gradient-text">Nest</span>
                        </span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#jobs" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-300 relative group">
                        Jobs
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#freelancers" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-300 relative group">
                        Freelancers
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#how-it-works" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-300 relative group">
                        How it Works
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
                        <i id="theme-icon" class="fas fa-moon text-gray-700 dark:text-yellow-300"></i>
                    </button>
                    
                  @auth
                        <!-- User Menu -->
                        <div class="flex items-center space-x-4">
                            @if(auth()->user()->role == 'client')
                                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                                    <i class="fas fa-plus mr-2"></i> Post Job
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                                    <i class="fas fa-briefcase mr-2"></i> Find Work
                                </a>
                            @endif
                            <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                <i class="fas fa-user-circle text-xl"></i>
                            </a>
                        </div>
                    @else
                        <!-- Auth Buttons -->
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                                Get Started
                            </a>
                        </div>
                    @endauth
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700">
                        <i class="fas fa-bars text-gray-700 dark:text-gray-300"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700">
            <div class="space-y-3">
                <a href="#jobs" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Jobs</a>
                <a href="#freelancers" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Freelancers</a>
                <a href="#how-it-works" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">How it Works</a>
                <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                    @auth
                        <a href="{{ route('dashboard') }}" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white mb-2">
                            <i class="fas fa-user-circle mr-2"></i> Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white mb-2">Login</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg text-center">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 via-purple-500/10 to-pink-500/10"></div>
        <div class="max-w-7xl mx-auto px-4 py-16 md:py-24 relative z-10">
            <div class="flex flex-col lg:flex-row items-center">
                <!-- Left Content -->
                <div class="lg:w-1/2 mb-12 lg:mb-0 animate-slide-in">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Find <span class="gradient-text">Perfect Talent</span> or 
                        <span class="gradient-text">Dream Projects</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                        Join thousands of businesses and freelancers connecting on WorkNest. 
                        The #1 freelance marketplace for quality work.
                    </p>
                    
                    <!-- Search Bar -->
                    <div class="mb-8">
                        <div class="relative max-w-2xl">
                            <input type="text" 
                                   placeholder="Search jobs, skills, or freelancers..." 
                                   class="w-full px-6 py-4 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-12">
                            <button class="absolute right-3 top-1/2 transform -translate-y-1/2 p-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:shadow-lg transition-all duration-300">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            @if(auth()->user()->role == 'client')
                                <a href="{{ route('client.jobs.create') }}" 
                                   class="px-8 py-4 bg-gradient-to-r from-green-500 to-teal-500 text-white font-bold rounded-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 flex items-center justify-center group">
                                    <i class="fas fa-plus mr-3 group-hover:rotate-90 transition-transform duration-300"></i>
                                    Post a Job
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" 
                                   class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 flex items-center justify-center group">
                                    <i class="fas fa-briefcase mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                                    Browse Jobs
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register', ['role' => 'client']) }}" 
                               class="px-8 py-4 bg-gradient-to-r from-green-500 to-teal-500 text-white font-bold rounded-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 flex items-center justify-center group">
                                <i class="fas fa-briefcase mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                                Hire Talent
                            </a>
                            <a href="{{ route('register', ['role' => 'freelancer']) }}" 
                               class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 flex items-center justify-center group">
                                <i class="fas fa-laptop-code mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                                Find Work
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Right Illustration -->
                <div class="lg:w-1/2 flex justify-center animate-float">
                    <div class="relative">
                        <div class="w-64 h-64 md:w-96 md:h-96 rounded-full bg-gradient-to-r from-blue-500/20 to-purple-500/20 flex items-center justify-center relative overflow-hidden">
                            <!-- Animated circles -->
                            <div class="absolute w-full h-full">
                                <div class="absolute top-1/4 left-1/4 w-32 h-32 rounded-full bg-blue-500/10 animate-ping-slow"></div>
                                <div class="absolute bottom-1/4 right-1/4 w-24 h-24 rounded-full bg-purple-500/10 animate-ping-slow" style="animation-delay: 0.5s;"></div>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-40 h-40 rounded-full bg-pink-500/10 animate-ping-slow" style="animation-delay: 1s;"></div>
                            </div>
                            
                            <!-- Central icon -->
                            <div class="relative z-10 text-center">
                                <div class="w-32 h-32 md:w-48 md:h-48 rounded-full bg-gradient-to-r from-white to-gray-100 dark:from-gray-800 dark:to-gray-900 flex items-center justify-center shadow-2xl mx-auto mb-6">
                                    <i class="fas fa-handshake text-5xl md:text-7xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Join Our Community</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Counter -->
    <section class="py-12 bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                    $stats = [
                        'total_jobs' => \App\Models\MarketplaceJob::where('status', 'open')->count() ?: 1250,
                        'total_freelancers' => \App\Models\User::where('role', 'freelancer')->count() ?: 540,
                        'total_clients' => \App\Models\User::where('role', 'client')->count() ?: 320,
                        'total_earned' => \App\Models\JobProposal::where('status', 'accepted')->sum('bid_amount') ?: 5000000
                    ];
                @endphp
                
                <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl hover-lift">
                    <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2 counter" data-target="{{ $stats['total_jobs'] }}">0</div>
                    <div class="text-gray-600 dark:text-gray-300">Active Jobs</div>
                </div>
                <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl hover-lift">
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2 counter" data-target="{{ $stats['total_freelancers'] }}">0</div>
                    <div class="text-gray-600 dark:text-gray-300">Freelancers</div>
                </div>
                <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl hover-lift">
                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2 counter" data-target="{{ $stats['total_clients'] }}">0</div>
                    <div class="text-gray-600 dark:text-gray-300">Clients</div>
                </div>
                <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl hover-lift">
                    <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mb-2 counter" data-target="{{ $stats['total_earned'] }}">0</div>
                    <div class="text-gray-600 dark:text-gray-300">Total Earned</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Jobs -->
    <section id="jobs" class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Featured Jobs</h2>
                    <p class="text-gray-600 dark:text-gray-300">Latest opportunities from top clients</p>
                </div>
                <a href="{{ route('jobs.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                    View all jobs <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <!-- Jobs Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $featuredJobs = \App\Models\MarketplaceJob::where('status', 'open')
                        ->with('client')
                        ->latest()
                        ->take(6)
                        ->get();
                    
                    if($featuredJobs->isEmpty()) {
                        // Sample jobs for demo
                        $sampleJobs = [
                            ['title' => 'E-commerce Website Development', 'budget' => 5000, 'job_type' => 'fixed', 'experience_level' => 'expert', 'client' => ['name' => 'TechCorp Inc.']],
                            ['title' => 'Logo & Brand Identity Design', 'budget' => 800, 'job_type' => 'fixed', 'experience_level' => 'intermediate', 'client' => ['name' => 'StartupXYZ']],
                            ['title' => 'Mobile App Development', 'budget' => 3500, 'job_type' => 'hourly', 'experience_level' => 'expert', 'client' => ['name' => 'MobileFirst Inc']],
                            ['title' => 'Content Writing & SEO', 'budget' => 25, 'job_type' => 'hourly', 'experience_level' => 'entry', 'client' => ['name' => 'ContentStudio']],
                            ['title' => 'Social Media Marketing', 'budget' => 1200, 'job_type' => 'fixed', 'experience_level' => 'intermediate', 'client' => ['name' => 'GrowthHackers']],
                            ['title' => 'WordPress Website Fix', 'budget' => 300, 'job_type' => 'fixed', 'experience_level' => 'intermediate', 'client' => ['name' => 'SmallBusiness LLC']],
                        ];
                    }
                @endphp
                
              @foreach($featuredJobs as $job)
                <div class="job-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover-lift animate-fade-in-up" @php $delay = $loop->index * 0.1; @endphp
style="animation-delay: {{ $delay }}s">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                @if(($job['experience_level'] ?? $job->experience_level) == 'entry') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif(($job['experience_level'] ?? $job->experience_level) == 'intermediate') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @endif">
                                {{ ucfirst($job['experience_level'] ?? $job->experience_level) }}
                            </span>
                            <span class="ml-2 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ ucfirst($job['job_type'] ?? $job->job_type) }}
                            </span>
                        </div>
                        <button class="text-gray-400 hover:text-red-500 transition-colors duration-300">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">
    @if(isset($job->id))
        <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
            {{ $job->title }}
        </a>
    @else
        {{ $job['title'] ?? $job->title }}
    @endif
</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">
                        {{ $job['description'] ?? $job->description ?? 'Looking for a skilled professional to complete this project...' }}
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <div class="text-2xl font-bold text-gray-800 dark:text-white">
                                @if(($job['job_type'] ?? $job->job_type) == 'hourly')
                                    ${{ number_format($job['budget'] ?? $job->budget, 2) }}/hr
                                @else
                                    ${{ number_format($job['budget'] ?? $job->budget, 0) }}
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Posted by {{ $job['client']['name'] ?? $job->client->name ?? 'Anonymous' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach(['Laravel', 'PHP', 'Vue.js', 'MySQL'] as $skill)
                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-xs">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                    
                    <!-- Role-based Action Button -->
<div class="mt-auto">
    @if(isset($job->id)) {{-- Real job from database --}}
        <a href="{{ route('jobs.show', $job) }}" 
           class="block w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-medium hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 text-center">
            <i class="fas fa-eye mr-2"></i> View Details
        </a>
    @else {{-- Sample job (fallback) --}}
        @auth
            @if(auth()->user()->role == 'freelancer')
                <button class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-medium hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                    <i class="fas fa-paper-plane mr-2"></i> Apply Now
                </button>
            @else
                <button class="w-full py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-xl font-medium hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                    <i class="fas fa-eye mr-2"></i> View Details
                </button>
            @endif
        @else
            <a href="{{ route('login') }}" class="block w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-medium hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 text-center">
                <i class="fas fa-sign-in-alt mr-2"></i> Login to Apply
            </a>
        @endauth
    @endif
</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Top Freelancers -->
    <section id="freelancers" class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Top Freelancers</h2>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Meet our highest-rated professionals</p>
            </div>
            
            <!-- Freelancers Carousel -->
            <div class="relative">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $freelancers = \App\Models\User::where('role', 'freelancer')
                            ->withCount(['proposals' => function($q) {
                                $q->where('status', 'accepted');
                            }])
                            ->orderBy('proposals_count', 'desc')
                            ->take(6)
                            ->get();
                            
                        if($freelancers->isEmpty()) {
                            $sampleFreelancers = [
                                ['name' => 'Alex Johnson', 'title' => 'Full Stack Developer', 'hourly_rate' => 75, 'rating' => 4.9],
                                ['name' => 'Sarah Miller', 'title' => 'UI/UX Designer', 'hourly_rate' => 60, 'rating' => 4.8],
                                ['name' => 'Mike Chen', 'title' => 'DevOps Engineer', 'hourly_rate' => 85, 'rating' => 4.9],
                                ['name' => 'Emma Wilson', 'title' => 'Content Writer', 'hourly_rate' => 40, 'rating' => 4.7],
                                ['name' => 'David Brown', 'title' => 'Marketing Expert', 'hourly_rate' => 55, 'rating' => 4.8],
                                ['name' => 'Lisa Taylor', 'title' => 'Data Scientist', 'hourly_rate' => 90, 'rating' => 5.0],
                            ];
                        }
                    @endphp
                    
                    @foreach($freelancers->isEmpty() ? $sampleFreelancers : $freelancers as $freelancer)
                    <div class="freelancer-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover-lift animate-fade-in-up" @php $delay = $loop->index * 0.1; @endphp
style="animation-delay: {{ $delay }}s">
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-xl mr-4">
                                {{ substr($freelancer['name'] ?? $freelancer->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 dark:text-white">{{ $freelancer['name'] ?? $freelancer->name }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $freelancer['title'] ?? 'Freelancer' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-{{ $i <= ($freelancer['rating'] ?? 4.5) ? 'yellow-400' : 'gray-300 dark:text-gray-600' }} mr-1"></i>
                                @endfor
                                <span class="ml-2 text-gray-600 dark:text-gray-300">{{ $freelancer['rating'] ?? 4.5 }}/5</span>
                            </div>
                            <div class="text-lg font-bold text-gray-800 dark:text-white">
                                ${{ $freelancer['hourly_rate'] ?? $freelancer->hourly_rate ?? 50 }}/hr
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach(['Laravel', 'React', 'AWS', 'Docker'] as $skill)
                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-xs">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                        
                        <div class="mt-auto">
                            @auth
                            
                           @if(auth()->user()->role == 'client')
                                  
                                  <a href="{{ route('messages.index') }}" 
                                 class="block w-full py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-xl font-medium hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 mb-2 text-center">
                               <i class="fas fa-envelope mr-2"></i> Go to Messages
                               </a>
                               @endif

                            @endguest
                            <button class="w-full py-2 border-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400 rounded-xl font-medium hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors duration-300">
                                <i class="fas fa-eye mr-2"></i> View Profile
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-16 bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">How WorkNest Works</h2>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Simple steps to get started with your freelance journey</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-xl hover-lift">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center mx-auto mb-6 text-white text-2xl">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Create Profile</h3>
                    <p class="text-gray-600 dark:text-gray-300">Sign up as a client or freelancer. Build your profile with skills, portfolio, and experience.</p>
                </div>
                
                <div class="text-center p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-xl hover-lift">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center mx-auto mb-6 text-white text-2xl">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Find & Connect</h3>
                    <p class="text-gray-600 dark:text-gray-300">Browse jobs or freelancers. Use smart filters to find perfect matches for your needs.</p>
                </div>
                
                <div class="text-center p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-xl hover-lift">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-r from-pink-500 to-red-500 flex items-center justify-center mx-auto mb-6 text-white text-2xl">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Work & Get Paid</h3>
                    <p class="text-gray-600 dark:text-gray-300">Collaborate using our tools. Get paid securely through our escrow system.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute top-0 left-0 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-white/10 blur-3xl"></div>
        
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Ready to Start Your Journey?</h2>
            <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">
                Join thousands of successful freelancers and clients who trust WorkNest for their projects.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register', ['role' => 'freelancer']) }}" 
                   class="px-8 py-4 bg-white text-blue-600 font-bold rounded-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 flex items-center justify-center group">
                    <i class="fas fa-laptop-code mr-3 text-xl group-hover:scale-110 transition-transform duration-300"></i>
                    Start Freelancing
                </a>
                <a href="{{ route('register', ['role' => 'client']) }}" 
                   class="px-8 py-4 bg-white/20 backdrop-blur-sm text-white font-bold rounded-xl hover:bg-white/30 border-2 border-white transition-all duration-300 hover:-translate-y-1 flex items-center justify-center group">
                    <i class="fas fa-briefcase mr-3 text-xl group-hover:scale-110 transition-transform duration-300"></i>
                    Hire Talent
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <span class="text-xl font-bold">WorkNest</span>
                    </div>
                    <p class="text-gray-400 mb-6">Connecting talent with opportunity since 2023. The future of freelance work.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-gray-600 transition-colors duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-gray-600 transition-colors duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-gray-600 transition-colors duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-gray-600 transition-colors duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-6">For Freelancers</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Find Work</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Portfolio</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Get Certified</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Pricing</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-6">For Clients</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Post a Job</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Browse Freelancers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Enterprise</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Pricing</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-6">Company</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-gray-700 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} WorkNest. All rights reserved. Made with <i class="fas fa-heart text-red-500 mx-1"></i> for freelancers worldwide.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                themeIcon.className = isDark ? 'fas fa-sun text-yellow-300' : 'fas fa-moon text-gray-700';
            });
            
            // Load saved theme
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
                themeIcon.className = 'fas fa-sun text-yellow-300';
            }
        }
        
        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
        
        // Animated Counters
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.counter');
            const speed = 200;
            
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText.replace(/,/g, '');
                    const increment = target / speed;
                    
                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment).toLocaleString();
                        setTimeout(updateCount, 1);
                    } else {
                        counter.innerText = target.toLocaleString();
                    }
                };
                
                updateCount();
            });
            
            // Initialize particles
            initParticles();
            
            // Add hover effects to job cards
            const jobCards = document.querySelectorAll('.job-card, .freelancer-card');
            jobCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                    this.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                });
            });
        });
        
        // Floating Particles Background
        function initParticles() {
            const container = document.getElementById('particles-bg');
            if (!container) return;
            
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle absolute rounded-full';
                
                // Random properties
                const size = Math.random() * 100 + 20;
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 5;
                const colors = [
                    'rgba(102, 126, 234, 0.1)',
                    'rgba(118, 75, 162, 0.1)',
                    'rgba(245, 101, 101, 0.1)',
                    'rgba(72, 187, 120, 0.1)'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;
                particle.style.background = color;
                particle.style.animation = `float ${duration}s ease-in-out infinite`;
                particle.style.animationDelay = `${delay}s`;
                particle.style.filter = 'blur(20px)';
                particle.style.opacity = '0.5';
                
                container.appendChild(particle);
            }
        }
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
