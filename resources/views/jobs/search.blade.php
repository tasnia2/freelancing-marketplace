<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    {{ __('Search Jobs') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('Find your perfect freelance opportunity') }}
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
                    <i id="theme-icon" class="fas fa-moon text-gray-700 dark:text-yellow-300"></i>
                </button>
                
                <a href="{{ route('jobs.index') }}" 
                   class="px-4 py-2 border border-[#7C3AED] text-[#5B21B6] dark:text-white rounded-lg hover:bg-[#F5F3FF] dark:hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span>{{ __('Back to Jobs') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 mb-8">
                <!-- FIXED: Use the correct search route name from your routes -->
                <form method="GET" action="{{ route('search.results') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <input type="text" 
                                   name="q" 
                                   value="{{ request('q') }}"
                                   placeholder="Search jobs, skills, or keywords..."
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <!-- Budget Range -->
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" 
                                   name="budget_min" 
                                   value="{{ request('budget_min') }}"
                                   placeholder="Min Budget ($)"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <input type="number" 
                                   name="budget_max" 
                                   value="{{ request('budget_max') }}"
                                   placeholder="Max Budget ($)"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <!-- Submit -->
                        <div>
                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-gradient-to-r from-[#5B21B6] to-[#7C3AED] text-white rounded-lg hover:from-[#7C3AED] hover:to-[#A78BFA] transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                                <i class="fas fa-search mr-2"></i>Search Jobs
                            </button>
                        </div>
                    </div>
                    
                    <!-- Additional Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <!-- Job Type -->
                        <div>
                            <select name="job_type" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="">All Job Types</option>
                                <option value="fixed" {{ request('job_type') == 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                                <option value="hourly" {{ request('job_type') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                            </select>
                        </div>
                        
                        <!-- Experience Level -->
                        <div>
                            <select name="experience_level" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="">All Experience Levels</option>
                                <option value="entry" {{ request('experience_level') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                <option value="intermediate" {{ request('experience_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="expert" {{ request('experience_level') == 'expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                        </div>
                        
                        <!-- Remote Only -->
                        <div class="flex items-center">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" 
                                       name="is_remote" 
                                       value="1"
                                       {{ request('is_remote') ? 'checked' : '' }}
                                       class="w-4 h-4 text-[#5B21B6] bg-gray-100 border-gray-300 rounded focus:ring-[#5B21B6] dark:focus:ring-[#A78BFA] dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span class="text-gray-700 dark:text-gray-300">Remote Only</span>
                            </label>
                        </div>
                        
                        <!-- Urgent Jobs -->
                        <div class="flex items-center">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" 
                                       name="is_urgent" 
                                       value="1"
                                       {{ request('is_urgent') ? 'checked' : '' }}
                                       class="w-4 h-4 text-[#5B21B6] bg-gray-100 border-gray-300 rounded focus:ring-[#5B21B6] dark:focus:ring-[#A78BFA] dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span class="text-gray-700 dark:text-gray-300">Urgent Jobs</span>
                            </label>
                        </div>
                    </div>
                    
                    @if(request()->anyFilled(['q', 'budget_min', 'budget_max', 'job_type', 'experience_level', 'is_remote', 'is_urgent']))
                        <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Showing {{ $jobs->total() }} results
                                @if(request('q'))
                                    for "{{ request('q') }}"
                                @endif
                            </div>
                            <a href="{{ route('search.results') }}" 
                               class="text-sm text-[#7C3AED] hover:underline dark:text-[#A78BFA]">
                                <i class="fas fa-times mr-1"></i>Clear all filters
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Results -->
            @if($jobs->count() > 0)
                <!-- Results Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                            Job Opportunities
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Found {{ $jobs->total() }} matching jobs
                        </p>
                    </div>
                    
                    <!-- Sort Options -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Sort by:</span>
                        <select onchange="this.form.submit()" 
                                name="sort"
                                class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:border-transparent dark:bg-gray-700 dark:text-white text-sm">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="budget_high" {{ request('sort') == 'budget_high' ? 'selected' : '' }}>Highest Budget</option>
                            <option value="budget_low" {{ request('sort') == 'budget_low' ? 'selected' : '' }}>Lowest Budget</option>
                        </select>
                    </div>
                </div>

                <!-- Jobs Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jobs as $job)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                            <!-- Job Header -->
                            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-800 dark:text-white line-clamp-1 group-hover:text-[#7C3AED] transition-colors duration-300">
                                            <a href="{{ route('jobs.show', $job) }}">
                                                {{ $job->title }}
                                            </a>
                                        </h3>
                                        <div class="flex flex-wrap gap-2 mt-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                                @if($job->experience_level == 'entry') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                @elseif($job->experience_level == 'intermediate') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                                @endif">
                                                {{ ucfirst($job->experience_level) }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                {{ ucfirst($job->job_type) }}
                                            </span>
                                            @if($job->is_urgent)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 animate-pulse">
                                                    <i class="fas fa-bolt mr-1"></i>Urgent
                                                </span>
                                            @endif
                                            @if($job->is_remote)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                                    <i class="fas fa-globe mr-1"></i>Remote
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Save Button -->
                                    @auth
                                        @if(auth()->user()->role == 'freelancer')
                                            <button class="text-gray-400 hover:text-[#5B21B6] dark:hover:text-[#A78BFA] transition-colors duration-300"
                                                    title="Save job">
                                                <i class="far fa-bookmark"></i>
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                                
                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4">
                                    {{ Str::limit(strip_tags($job->description), 120) }}
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
                                            <div class="font-bold text-xl text-gray-800 dark:text-white">
                                                @if($job->job_type == 'hourly')
                                                    ${{ number_format($job->hourly_rate, 2) }}/hr
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
                                                • {{ $job->proposals_count ?? 0 }} proposals
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Skills -->
                                @if($job->skills && $job->skills->count() > 0)
                                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($job->skills->take(3) as $skill)
                                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-xs">
                                                    {{ $skill->name }}
                                                </span>
                                            @endforeach
                                            @if($job->skills->count() > 3)
                                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full text-xs">
                                                    +{{ $job->skills->count() - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Apply Button -->
                                <div class="mt-6">
                                    @auth
                                        @if(auth()->user()->role == 'freelancer')
                                            <a href="{{ route('jobs.show', $job) }}" 
                                               class="block w-full text-center px-4 py-3 bg-gradient-to-r from-[#5B21B6] to-[#7C3AED] text-white rounded-lg hover:from-[#7C3AED] hover:to-[#A78BFA] transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                                                <i class="fas fa-paper-plane mr-2"></i>Apply Now
                                            </a>
                                        @else
                                            <a href="{{ route('jobs.show', $job) }}" 
                                               class="block w-full text-center px-4 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-medium">
                                                <i class="fas fa-eye mr-2"></i>View Details
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" 
                                           class="block w-full text-center px-4 py-3 bg-gradient-to-r from-[#5B21B6] to-[#7C3AED] text-white rounded-lg hover:from-[#7C3AED] hover:to-[#A78BFA] transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                                            <i class="fas fa-sign-in-alt mr-2"></i>Login to Apply
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $jobs->withQueryString()->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-r from-[#5B21B6]/10 to-[#7C3AED]/10 dark:from-[#5B21B6]/20 dark:to-[#7C3AED]/20 mb-6">
                        <i class="fas fa-search text-4xl text-[#7C3AED]"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">No jobs found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
                        @if(request()->anyFilled(['q', 'budget_min', 'budget_max', 'job_type', 'experience_level']))
                            Try adjusting your search filters or broaden your search criteria.
                        @else
                            There are currently no jobs matching your criteria. Try browsing all jobs instead.
                        @endif
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('jobs.index') }}" 
                           class="px-6 py-3 bg-gradient-to-r from-[#5B21B6] to-[#7C3AED] text-white rounded-lg hover:from-[#7C3AED] hover:to-[#A78BFA] transition-all duration-300 shadow-lg hover:shadow-xl">
                            Browse All Jobs
                        </a>
                        <a href="{{ route('search.results') }}" 
                           class="px-6 py-3 border-2 border-[#5B21B6] text-[#5B21B6] dark:text-white dark:border-[#A78BFA] rounded-lg hover:bg-[#F5F3FF] dark:hover:bg-gray-700 transition-all duration-300">
                            Clear Search
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Theme Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            
            // Add animation to job cards on hover
            const jobCards = document.querySelectorAll('.group');
            jobCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                });
            });
        });
    </script>
</x-app-layout>