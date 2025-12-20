<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - WorkNest</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'theme-primary': '#5B21B6',
                        'theme-secondary': '#7C3AED',
                        'theme-accent': '#A78BFA',
                        'theme-light': '#F5F3FF'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        }
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
        
        .dark .bg-gray-50 {
            background-color: #1e293b !important;
        }
        
        /* Purple theme gradient */
        .theme-gradient {
            background: linear-gradient(90deg, #5B21B6, #7C3AED);
        }
        
        .hover-theme-gradient:hover {
            background: linear-gradient(90deg, #7C3AED, #5B21B6);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .dark ::-webkit-scrollbar-track {
            background: #334155;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #5B21B6, #7C3AED);
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    
    <!-- Header with Theme Toggle -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-lg theme-gradient flex items-center justify-center p-1 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                        <i class="fas fa-handshake text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">
                        Work<span style="background: linear-gradient(90deg, #5B21B6, #7C3AED); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Nest</span>
                    </span>
                </a>
                
                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
                        <i id="theme-icon" class="fas fa-moon text-gray-700 dark:text-yellow-300"></i>
                    </button>
                    
                    <!-- Navigation Links -->
                    <a href="{{ route('jobs.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-theme-primary dark:hover:text-theme-accent transition-colors duration-300">
                        <i class="fas fa-briefcase mr-2"></i>Jobs
                    </a>
                    <a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-300 hover:text-theme-primary dark:hover:text-theme-accent transition-colors duration-300">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8 animate-fade-in">
        <!-- Enhanced Search Box -->
        <div class="mb-8 animate-slide-up">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <form action="{{ route('search.results') }}" method="GET" class="space-y-4">
                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Main Search Input -->
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text" 
                                       name="q"
                                       value="{{ request('q') }}"
                                       placeholder="Search jobs, freelancers, skills, companies..." 
                                       class="w-full px-6 py-4 pl-12 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-theme-primary dark:bg-gray-700 dark:text-white"
                                       required>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Search Type -->
                        <div class="w-full md:w-48">
                            <div class="relative">
                                <select name="type" class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-theme-primary appearance-none dark:bg-gray-700 dark:text-white">
                                    <option value="all" {{ request('type', 'all') == 'all' ? 'selected' : '' }}>All Categories</option>
                                    <option value="jobs" {{ request('type') == 'jobs' ? 'selected' : '' }}>Jobs</option>
                                    <option value="freelancers" {{ request('type') == 'freelancers' ? 'selected' : '' }}>Freelancers</option>
                                    <option value="skills" {{ request('type') == 'skills' ? 'selected' : '' }}>Skills</option>
                                </select>
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Search Button -->
                        <div class="w-full md:w-auto">
                            <button type="submit" class="w-full md:w-auto px-8 py-4 theme-gradient text-white rounded-xl hover:opacity-90 transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                                <i class="fas fa-search mr-2"></i>Search
                            </button>
                        </div>
                    </div>
                    
                    <!-- Advanced Filters -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Advanced filters:</span>
                            <button type="button" id="toggle-filters" class="text-sm text-theme-primary hover:text-theme-secondary dark:text-theme-accent">
                                <i class="fas fa-filter mr-1"></i>Show Filters
                            </button>
                        </div>
                        
                        <div id="advanced-filters" class="hidden mt-4 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Job Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Job Type</label>
                                    <select name="job_type" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                        <option value="">All Types</option>
                                        <option value="fixed" {{ request('job_type') == 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                                        <option value="hourly" {{ request('job_type') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                                    </select>
                                </div>
                                
                                <!-- Budget Range -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Budget Range</label>
                                    <div class="flex space-x-2">
                                        <input type="number" 
                                               name="budget_min" 
                                               value="{{ request('budget_min') }}"
                                               placeholder="Min $" 
                                               class="w-1/2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                        <input type="number" 
                                               name="budget_max" 
                                               value="{{ request('budget_max') }}"
                                               placeholder="Max $" 
                                               class="w-1/2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                    </div>
                                </div>
                                
                                <!-- Experience Level -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Experience</label>
                                    <select name="experience_level" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                        <option value="">All Levels</option>
                                        <option value="entry" {{ request('experience_level') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                        <option value="intermediate" {{ request('experience_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                        <option value="expert" {{ request('experience_level') == 'expert' ? 'selected' : '' }}>Expert</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Quick Filters -->
                            <div class="flex flex-wrap gap-2">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" 
                                           name="remote_only" 
                                           value="1"
                                           {{ request('remote_only') ? 'checked' : '' }}
                                           class="rounded text-theme-primary focus:ring-theme-primary">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Remote Only</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" 
                                           name="urgent_only" 
                                           value="1"
                                           {{ request('urgent_only') ? 'checked' : '' }}
                                           class="rounded text-theme-primary focus:ring-theme-primary">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Urgent Jobs</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Results -->
        <div class="animate-fade-in" style="animation-delay: 0.1s">
            @if(!empty(request('q')))
                <!-- Results Header -->
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                            Search Results for "{{ request('q') }}"
                            @if(request('type') && request('type') != 'all')
                                <span class="text-lg text-gray-600 dark:text-gray-400">({{ ucfirst(request('type')) }})</span>
                            @endif
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            @php
                                $totalResults = ($results['jobs']->count() ?? 0) + 
                                              ($results['freelancers']->count() ?? 0) + 
                                              ($results['skills']->count() ?? 0);
                            @endphp
                            Found {{ $totalResults }} matching results
                        </p>
                    </div>
                    
                    <!-- Clear Filters -->
                    @if(request()->anyFilled(['q', 'type', 'job_type', 'budget_min', 'budget_max', 'experience_level', 'remote_only', 'urgent_only']))
                        <a href="{{ route('search.results') }}" 
                           class="text-sm text-theme-primary hover:text-theme-secondary dark:text-theme-accent">
                            <i class="fas fa-times mr-1"></i>Clear all filters
                        </a>
                    @endif
                </div>

                <!-- Jobs Results -->
                @if((request('type') == 'all' || request('type') == 'jobs') && isset($results['jobs']) && $results['jobs']->count() > 0)
                    <div class="mb-8 animate-slide-up" style="animation-delay: 0.2s">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#5B21B6]/10 to-[#7C3AED]/10 dark:from-[#5B21B6]/20 dark:to-[#7C3AED]/20 flex items-center justify-center mr-3">
                                    <i class="fas fa-briefcase text-[#7C3AED]"></i>
                                </div>
                                Jobs <span class="ml-2 text-lg font-normal text-gray-600 dark:text-gray-400">({{ $results['jobs']->count() }})</span>
                            </h2>
                            <a href="{{ route('jobs.index') }}?q={{ urlencode(request('q')) }}" 
                               class="text-sm text-theme-primary hover:text-theme-secondary dark:text-theme-accent">
                                View all jobs <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($results['jobs'] as $job)
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                    <!-- Job Header -->
                                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex-1">
                                                <h3 class="font-bold text-lg text-gray-800 dark:text-white line-clamp-1 hover:text-theme-primary transition-colors duration-300">
                                                    <a href="{{ route('jobs.show', $job) }}">
                                                        {{ $job->title }}
                                                    </a>
                                                </h3>
                                                <div class="flex items-center space-x-2 mt-2">
                                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                                        @if($job->experience_level == 'entry') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                        @elseif($job->experience_level == 'intermediate') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                        @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                                        @endif">
                                                        {{ ucfirst($job->experience_level ?? 'Not specified') }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                        {{ ucfirst($job->job_type ?? 'Not specified') }}
                                                    </span>
                                                    @if($job->is_remote ?? false)
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                                            <i class="fas fa-globe mr-1"></i>Remote
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4">
                                            {{ Str::limit(strip_tags($job->description ?? 'No description available'), 120) }}
                                        </p>
                                    </div>
                                    
                                    <!-- Job Details -->
                                    <div class="p-6">
                                        <div class="space-y-4">
                                            <!-- Budget -->
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#5B21B6]/10 to-[#7C3AED]/10 dark:from-[#5B21B6]/20 dark:to-[#7C3AED]/20 flex items-center justify-center mr-3">
                                                    <i class="fas fa-dollar-sign text-[#7C3AED]"></i>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-800 dark:text-white">
                                                        @if($job->job_type == 'hourly')
                                                            ${{ number_format($job->hourly_rate ?? $job->budget, 2) }}/hr
                                                        @else
                                                            ${{ number_format($job->budget, 0) }}
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $job->job_type == 'hourly' ? 'Hourly Rate' : 'Fixed Price' }}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Client & Posted Time -->
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#5B21B6]/10 to-[#7C3AED]/10 dark:from-[#5B21B6]/20 dark:to-[#7C3AED]/20 flex items-center justify-center mr-3">
                                                    <i class="fas fa-building text-[#7C3AED]"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="font-medium text-gray-800 dark:text-white">
                                                        {{ $job->client->name ?? 'Client' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        Posted {{ $job->created_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Action Button -->
                                        <div class="mt-6">
                                            <a href="{{ route('jobs.show', $job) }}" 
                                               class="block w-full text-center px-4 py-3 theme-gradient text-white rounded-lg hover:opacity-90 transition-all duration-300 font-medium shadow-md">
                                                <i class="fas fa-eye mr-2"></i>View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Freelancers Results -->
                @if((request('type') == 'all' || request('type') == 'freelancers') && isset($results['freelancers']) && $results['freelancers']->count() > 0)
                    <div class="mb-8 animate-slide-up" style="animation-delay: 0.3s">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#5B21B6]/10 to-[#7C3AED]/10 dark:from-[#5B21B6]/20 dark:to-[#7C3AED]/20 flex items-center justify-center mr-3">
                                    <i class="fas fa-users text-[#7C3AED]"></i>
                                </div>
                                Freelancers <span class="ml-2 text-lg font-normal text-gray-600 dark:text-gray-400">({{ $results['freelancers']->count() }})</span>
                            </h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($results['freelancers'] as $freelancer)
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                    <!-- Freelancer Header -->
                                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center mb-4">
                                            <div class="w-16 h-16 rounded-full theme-gradient flex items-center justify-center text-white font-bold text-xl mr-4">
                                                {{ strtoupper(substr($freelancer->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-800 dark:text-white">{{ $freelancer->name }}</h3>
                                                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $freelancer->title ?? 'Freelancer' }}</p>
                                                <div class="flex items-center mt-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star text-{{ $i <= ($freelancer->rating ?? 4.5) ? 'yellow-400' : 'gray-300 dark:text-gray-600' }} text-xs mr-1"></i>
                                                    @endfor
                                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $freelancer->rating ?? 4.5 }}/5</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4">
                                            {{ Str::limit($freelancer->bio ?? 'No bio available', 100) }}
                                        </p>
                                    </div>
                                    
                                    <!-- Freelancer Details -->
                                    <div class="p-6">
                                        <div class="space-y-4">
                                            <!-- Hourly Rate -->
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#5B21B6]/10 to-[#7C3AED]/10 dark:from-[#5B21B6]/20 dark:to-[#7C3AED]/20 flex items-center justify-center mr-3">
                                                    <i class="fas fa-money-bill-wave text-[#7C3AED]"></i>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-800 dark:text-white">
                                                        ${{ number_format($freelancer->hourly_rate ?? 50, 2) }}/hr
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">Hourly Rate</div>
                                                </div>
                                            </div>
                                            
                                            <!-- Location & Member Since -->
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#5B21B6]/10 to-[#7C3AED]/10 dark:from-[#5B21B6]/20 dark:to-[#7C3AED]/20 flex items-center justify-center mr-3">
                                                    <i class="fas fa-map-marker-alt text-[#7C3AED]"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="font-medium text-gray-800 dark:text-white">
                                                        {{ $freelancer->location ?? 'Location not specified' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        Member since {{ $freelancer->created_at->format('M Y') ?? 'Recently' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Skills -->
                                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                            <div class="flex flex-wrap gap-2">
                                                @php
                                                    $freelancerSkills = $freelancer->skills ?? collect(['Laravel', 'PHP', 'JavaScript', 'React', 'Vue.js'])->random(3);
                                                @endphp
                                                
                                                @foreach($freelancerSkills as $skill)
                                                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-xs">
                                                        {{ is_string($skill) ? $skill : ($skill->name ?? 'Skill') }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                        <!-- Action Button -->
                                        <div class="mt-6">
                                            @if(isset($freelancer->id))
                                                <a href="{{ route('freelancers.public.show', $freelancer) }}" 
                                                   class="block w-full text-center px-4 py-3 border-2 border-theme-primary text-theme-primary dark:text-theme-accent dark:border-theme-accent rounded-lg hover:bg-theme-light transition-colors duration-300 font-medium">
                                                    <i class="fas fa-eye mr-2"></i>View Profile
                                                </a>
                                            @else
                                                <button class="w-full px-4 py-3 border-2 border-theme-primary text-theme-primary dark:text-theme-accent dark:border-theme-accent rounded-lg hover:bg-theme-light transition-colors duration-300 font-medium">
                                                    <i class="fas fa-eye mr-2"></i>View Profile
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Skills Results -->
                @if((request('type') == 'all' || request('type') == 'skills') && isset($results['skills']) && $results['skills']->count() > 0)
                    <div class="mb-8 animate-slide-up" style="animation-delay: 0.4s">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#5B21B6]/10 to-[#7C3AED]/10 dark:from-[#5B21B6]/20 dark:to-[#7C3AED]/20 flex items-center justify-center mr-3">
                                    <i class="fas fa-tags text-[#7C3AED]"></i>
                                </div>
                                Skills <span class="ml-2 text-lg font-normal text-gray-600 dark:text-gray-400">({{ $results['skills']->count() }})</span>
                            </h2>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                            <div class="flex flex-wrap gap-3">
                                @foreach($results['skills'] as $skill)
                                    <a href="{{ route('jobs.index') }}?skill={{ urlencode($skill->name) }}" 
                                       class="inline-flex items-center px-5 py-3 rounded-full bg-gradient-to-r from-[#5B21B6]/10 to-[#7C3AED]/10 dark:from-[#5B21B6]/20 dark:to-[#7C3AED]/20 text-[#5B21B6] dark:text-white font-medium hover:from-[#5B21B6]/20 hover:to-[#7C3AED]/20 transition-all duration-300">
                                        <i class="fas fa-hashtag mr-2"></i>
                                        {{ $skill->name }}
                                        <span class="ml-2 px-2 py-1 bg-white dark:bg-gray-700 text-[#5B21B6] dark:text-gray-300 rounded-full text-xs">
                                            {{ $skill->jobs_count ?? 0 }} jobs
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- No Results -->
                @if((!isset($results['jobs']) || $results['jobs']->count() == 0) && 
                    (!isset($results['freelancers']) || $results['freelancers']->count() == 0) && 
                    (!isset($results['skills']) || $results['skills']->count() == 0))
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-r from-[#5B21B6]/10 to-[#7C3AED]/10 dark:from-[#5B21B6]/20 dark:to-[#7C3AED]/20 mb-6">
                            <i class="fas fa-search text-4xl text-[#7C3AED]"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">No results found</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
                            We couldn't find any results for "{{ request('q') }}". Try different keywords or check your spelling.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('jobs.index') }}" 
                               class="px-6 py-3 theme-gradient text-white rounded-lg hover:opacity-90 transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                                Browse All Jobs
                            </a>
                            <a href="{{ route('search.results') }}" 
                               class="px-6 py-3 border-2 border-theme-primary text-theme-primary dark:text-white dark:border-theme-accent rounded-lg hover:bg-theme-light transition-colors duration-300">
                                Clear Search
                            </a>
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty Search State -->
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-r from-[#5B21B6]/10 to-[#7C3AED]/10 dark:from-[#5B21B6]/20 dark:to-[#7C3AED]/20 mb-6">
                        <i class="fas fa-search text-4xl text-[#7C3AED]"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">Start Your Search</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Enter keywords to find jobs, freelancers, or skills</p>
                    
                    <!-- Popular Searches -->
                    <div class="max-w-2xl mx-auto">
                        <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Popular Searches:</h4>
                        <div class="flex flex-wrap justify-center gap-2">
                            @foreach(['Laravel Developer', 'Web Design', 'Mobile App', 'Content Writing', 'SEO Specialist', 'UI/UX Design', 'Data Analysis', 'Python Developer'] as $popular)
                                <a href="{{ route('search.results') }}?q={{ urlencode($popular) }}" 
                                   class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
                                    {{ $popular }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Theme Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            
            // Toggle Advanced Filters
            const toggleFiltersBtn = document.getElementById('toggle-filters');
            const advancedFilters = document.getElementById('advanced-filters');
            
            if (toggleFiltersBtn && advancedFilters) {
                toggleFiltersBtn.addEventListener('click', function() {
                    const isHidden = advancedFilters.classList.toggle('hidden');
                    this.innerHTML = isHidden ? 
                        '<i class="fas fa-filter mr-1"></i>Show Filters' : 
                        '<i class="fas fa-times mr-1"></i>Hide Filters';
                });
            }
            
            // Add hover effects to cards
            const cards = document.querySelectorAll('.hover\\:-translate-y-1');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                    this.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.1)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                });
            });
        });
    </script>
</body>
</html>