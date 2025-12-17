<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-800 dark:text-white leading-tight">
                    {{ __('Find Your Perfect Job') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    {{ __('Browse thousands of job opportunities from local clients') }}
                </p>
            </div>
            @auth
                @if(auth()->user()->user_type === 'client')
                    <a href="{{ route('client.jobs.create') }}" 
                       class="px-6 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-medium">
                        <i class="fas fa-plus mr-2"></i>Post a Job
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                            <i class="fas fa-briefcase text-xl"></i>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">{{ $stats['total_jobs'] ?? 0 }}</div>
                            <div class="text-white/80">Total Jobs</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-[#234C6A] to-[#456882] rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                            <i class="fas fa-bolt text-xl"></i>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">{{ $stats['urgent_jobs'] ?? 0 }}</div>
                            <div class="text-white/80">Urgent Jobs</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-[#456882] to-[#1B3C53] rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                            <i class="fas fa-globe text-xl"></i>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">{{ $stats['remote_jobs'] ?? 0 }}</div>
                            <div class="text-white/80">Remote Jobs</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-[#1B3C53] to-[#456882] rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                            <i class="fas fa-dollar-sign text-xl"></i>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">${{ number_format($stats['total_budget'] ?? 0) }}</div>
                            <div class="text-white/80">Total Budget</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 mb-8">
                <form method="GET" action="{{ route('jobs.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search jobs..."
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <!-- Job Type -->
                        <div>
                            <select name="job_type" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="">All Job Types</option>
                                <option value="fixed" {{ request('job_type') == 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                                <option value="hourly" {{ request('job_type') == 'hourly' ? 'selected' : '' }}>Hourly Rate</option>
                            </select>
                        </div>
                        
                        <!-- Experience Level -->
                        <div>
                            <select name="experience_level" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="">All Experience Levels</option>
                                <option value="entry" {{ request('experience_level') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                <option value="intermediate" {{ request('experience_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="expert" {{ request('experience_level') == 'expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Budget Range -->
                        <div>
                            <input type="number" 
                                   name="budget_min" 
                                   value="{{ request('budget_min') }}"
                                   placeholder="Min Budget"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <input type="number" 
                                   name="budget_max" 
                                   value="{{ request('budget_max') }}"
                                   placeholder="Max Budget"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <!-- Remote Only -->
                        <div class="flex items-center">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_remote" 
                                       value="1"
                                       {{ request('is_remote') ? 'checked' : '' }}
                                       class="mr-2 h-5 w-5 text-[#1B3C53] rounded focus:ring-[#1B3C53]">
                                <span class="text-gray-700 dark:text-gray-300">Remote Only</span>
                            </label>
                        </div>
                        
                        <!-- Urgent Only -->
                        <div class="flex items-center">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_urgent" 
                                       value="1"
                                       {{ request('is_urgent') ? 'checked' : '' }}
                                       class="mr-2 h-5 w-5 text-[#1B3C53] rounded focus:ring-[#1B3C53]">
                                <span class="text-gray-700 dark:text-gray-300">Urgent Only</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $jobs->total() }} jobs found
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('jobs.index') }}" 
                               class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                Clear Filters
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882]">
                                Search Jobs
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Jobs Grid -->
            @if($jobs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jobs as $job)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Job Header -->
                            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-800 dark:text-white line-clamp-1">
                                            <a href="{{ route('jobs.show', $job) }}" class="hover:text-[#456882]">
                                                {{ $job->title }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center space-x-3 mt-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $job->experience_badge_class }}">
                                                {{ ucfirst($job->experience_level) }}
                                            </span>
                                            @if($job->is_urgent)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                    <i class="fas fa-bolt mr-1"></i>Urgent
                                                </span>
                                            @endif
                                            @if($job->is_remote)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                    <i class="fas fa-globe mr-1"></i>Remote
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @auth
                                        <button onclick="toggleSaveJob('{{ $job->id }}', this)" 
                                                class="text-gray-400 hover:text-[#456882]">
                                            <i class="fas fa-bookmark"></i>
                                        </button>
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
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 flex items-center justify-center mr-3">
                                            <i class="fas fa-dollar-sign text-[#456882] text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800 dark:text-white">{{ $job->formatted_budget }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $job->job_type === 'hourly' ? 'Hourly Rate' : 'Fixed Price' }}</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Skills -->
                                    <div class="flex items-start">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 flex items-center justify-center mr-3 mt-1">
                                            <i class="fas fa-tools text-[#456882] text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach(array_slice($job->skills_required, 0, 3) as $skill)
                                                    <span class="inline-block px-2 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                                @if(count($job->skills_required) > 3)
                                                    <span class="inline-block px-2 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded">
                                                        +{{ count($job->skills_required) - 3 }} more
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Time & Proposals -->
                                    <div class="flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                            <i class="fas fa-clock mr-2"></i>
                                            <span>{{ $job->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                            <i class="fas fa-users mr-2"></i>
                                            <span>{{ $job->proposals_count }} proposals</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Apply Button -->
                                <div class="mt-6">
                                    <a href="{{ route('jobs.show', $job) }}" 
                                       class="block w-full text-center px-4 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-medium">
                                        @auth
                                            @if(auth()->user()->user_type === 'freelancer')
                                                <i class="fas fa-paper-plane mr-2"></i>Apply Now
                                            @else
                                                <i class="fas fa-eye mr-2"></i>View Details
                                            @endif
                                        @else
                                            <i class="fas fa-eye mr-2"></i>View Details
                                        @endauth
                                    </a>
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
                <div class="text-center py-12">
                    <div class="text-5xl mb-6 text-gray-300 dark:text-gray-600">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">No jobs found</h3>
                    <p class="text-gray-500 dark:text-gray-400">Try adjusting your search filters</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleSaveJob(jobId, button) {
            fetch(`/jobs/${jobId}/save`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.saved) {
                    button.innerHTML = '<i class="fas fa-bookmark text-[#456882]"></i>';
                    showToast('Job saved!', 'success');
                } else {
                    button.innerHTML = '<i class="fas fa-bookmark"></i>';
                    showToast('Job removed from saved', 'info');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred', 'error');
            });
        }
        
        function showToast(message, type) {
            // Simple toast notification
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
    @endpush
    
    @push('styles')
    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    @endpush
</x-app-layout>