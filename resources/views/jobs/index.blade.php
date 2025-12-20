@php
    // Get user info once
    $user = auth()->user();
    $isFreelancer = $user && ($user->role === 'freelancer' || $user->user_type === 'freelancer');
    $isClient = $user && ($user->role === 'client' || $user->user_type === 'client');
    
    // Set colors based on role
    if ($isFreelancer) {
        // Purple theme for freelancers
        $primaryColor = 'purple';
        $primary600 = '#8B5EF0';
        $primary700 = '#7B4EE0';
        $primary800 = '#6B3ED0';
        $textColorClass = 'text-purple-600';
        $bgGradientClass = 'bg-gradient-to-r from-purple-600 to-purple-800';
        $hoverGradientClass = 'hover:from-purple-700 hover:to-purple-900';
        $focusRingClass = 'focus:ring-purple-500';
    } else {
        // Blue theme for clients and guests (original)
        $primaryColor = 'blue';
        $primary600 = '#1B3C53';
        $primary700 = '#234C6A';
        $primary800 = '#456882';
        $textColorClass = 'text-[#456882]';
        $bgGradientClass = 'bg-gradient-to-r from-[#1B3C53] to-[#234C6A]';
        $hoverGradientClass = 'hover:from-[#234C6A] hover:to-[#456882]';
        $focusRingClass = 'focus:ring-[#1B3C53]';
    }
@endphp<x-app-layout>
    <!-- Store user type in a hidden element -->
    @auth
        <div id="current-user-type" data-user-type="{{ auth()->user()->user_type }}" class="hidden"></div>
    @endauth

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
                @php
                    // Define colors based on user type
                    if (auth()->check() && auth()->user()->user_type === 'freelancer') {
                        $color1 = 'purple-600';
                        $color2 = 'purple-800';
                        $color3 = 'purple-400';
                    } else {
                        $color1 = '[#1B3C53]';
                        $color2 = '[#234C6A]';
                        $color3 = '[#456882]';
                    }
                @endphp
                
                <div class="bg-gradient-to-r from-{{ $color1 }} to-{{ $color2 }} rounded-xl p-6 text-white shadow-lg">
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
                
                <div class="bg-gradient-to-r from-{{ $color2 }} to-{{ $color3 }} rounded-xl p-6 text-white shadow-lg">
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
                
                <div class="bg-gradient-to-r from-{{ $color3 }} to-{{ $color1 }} rounded-xl p-6 text-white shadow-lg">
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
                
                <div class="bg-gradient-to-r from-{{ $color1 }} to-{{ $color3 }} rounded-xl p-6 text-white shadow-lg">
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
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'focus:ring-purple-500' : 'focus:ring-[#1B3C53]' }} focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <!-- Job Type -->
                        <div>
                            <select name="job_type" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'focus:ring-purple-500' : 'focus:ring-[#1B3C53]' }} focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="">All Job Types</option>
                                <option value="fixed" {{ request('job_type') == 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                                <option value="hourly" {{ request('job_type') == 'hourly' ? 'selected' : '' }}>Hourly Rate</option>
                            </select>
                        </div>
                        
                        <!-- Experience Level -->
                        <div>
                            <select name="experience_level" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'focus:ring-purple-500' : 'focus:ring-[#1B3C53]' }} focus:border-transparent dark:bg-gray-700 dark:text-white">
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
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'focus:ring-purple-500' : 'focus:ring-[#1B3C53]' }} focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <input type="number" 
                                   name="budget_max" 
                                   value="{{ request('budget_max') }}"
                                   placeholder="Max Budget"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'focus:ring-purple-500' : 'focus:ring-[#1B3C53]' }} focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <!-- Remote Only -->
                        <div class="flex items-center">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_remote" 
                                       value="1"
                                       {{ request('is_remote') ? 'checked' : '' }}
                                       class="mr-2 h-5 w-5 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'text-purple-500 focus:ring-purple-500' : 'text-[#1B3C53] focus:ring-[#1B3C53]' }} rounded">
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
                                       class="mr-2 h-5 w-5 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'text-purple-500 focus:ring-purple-500' : 'text-[#1B3C53] focus:ring-[#1B3C53]' }} rounded">
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
                                    class="px-6 py-2 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900' : 'bg-gradient-to-r from-[#1B3C53] to-[#234C6A] hover:from-[#234C6A] hover:to-[#456882]' }} text-white rounded-lg transition-all duration-300">
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
                                            <a href="{{ route('jobs.show', $job) }}" class="hover:{{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'text-purple-600' : 'text-[#456882]' }}">
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
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' }}">
                                                    <i class="fas fa-globe mr-1"></i>Remote
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @auth
                                        <button onclick="toggleSaveJob('{{ $job->id }}', this)" 
                                                class="text-gray-400 hover:{{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'text-purple-600' : 'text-[#456882]' }}">
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
                                        <div class="w-8 h-8 rounded-full {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'bg-gradient-to-r from-purple-600/10 to-purple-800/10 dark:from-purple-600/20 dark:to-purple-800/20' : 'bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20' }} flex items-center justify-center mr-3">
                                            <i class="fas fa-dollar-sign {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'text-purple-600' : 'text-[#456882]' }} text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800 dark:text-white">{{ $job->formatted_budget }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $job->job_type === 'hourly' ? 'Hourly Rate' : 'Fixed Price' }}</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Skills -->
                                    <div class="flex items-start">
                                        <div class="w-8 h-8 rounded-full {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'bg-gradient-to-r from-purple-600/10 to-purple-800/10 dark:from-purple-600/20 dark:to-purple-800/20' : 'bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20' }} flex items-center justify-center mr-3 mt-1">
                                            <i class="fas fa-tools {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'text-purple-600' : 'text-[#456882]' }} text-sm"></i>
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
                                    @auth
                                        @if(auth()->user()->role === 'freelancer')
                                            @php
                                                // Check if freelancer has already applied
                                                $hasApplied = $job->proposals()
                                                    ->where('freelancer_id', auth()->id())
                                                    ->exists();
                                            @endphp
                                            
                                            @if($hasApplied)
                                                <span class="block w-full text-center px-4 py-3 bg-green-100 text-green-800 rounded-lg font-medium cursor-default">
                                                    <i class="fas fa-check mr-2"></i>Already Applied
                                                </span>
                                            @else
                                                <button onclick="showApplyModal('{{ $job->id }}', '{{ addslashes($job->title) }}')" 
                                                       class="w-full px-4 py-3 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900' : 'bg-gradient-to-r from-[#1B3C53] to-[#234C6A] hover:from-[#234C6A] hover:to-[#456882]' }} text-white rounded-lg transition-all duration-300 font-medium">
                                                    <i class="fas fa-paper-plane mr-2"></i>Apply Now
                                                </button>
                                            @endif
                                        @elseif(auth()->user()->role === 'client')
                                            <a href="{{ route('jobs.show', $job) }}" 
                                               class="block w-full text-center px-4 py-3 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'bg-gradient-to-r from-purple-400 to-purple-800 hover:from-purple-600 hover:to-purple-900' : 'bg-gradient-to-r from-[#456882] to-[#234C6A] hover:from-[#234C6A] hover:to-[#1B3C53]' }} text-white rounded-lg transition-all duration-300 font-medium">
                                                <i class="fas fa-eye mr-2"></i>View Details
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" 
                                           class="block w-full text-center px-4 py-3 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900' : 'bg-gradient-to-r from-[#1B3C53] to-[#234C6A] hover:from-[#234C6A] hover:to-[#456882]' }} text-white rounded-lg transition-all duration-300 font-medium">
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
                    // Get user type from hidden element
                    const userTypeElement = document.getElementById('current-user-type');
                    const userType = userTypeElement ? userTypeElement.getAttribute('data-user-type') : 'client';
                    const isFreelancer = userType === 'freelancer';
                    const colorClass = isFreelancer ? 'text-purple-600' : 'text-[#456882]';
                    button.innerHTML = `<i class="fas fa-bookmark ${colorClass}"></i>`;
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
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
        
        function showApplyModal(jobId, jobTitle) {
            // Set the form action
            document.getElementById('applyForm').action = `/jobs/${jobId}/apply`;
            document.getElementById('modalJobTitle').textContent = `Apply for: ${jobTitle}`;
            document.getElementById('applyModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeApplyModal() {
            document.getElementById('applyModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close modal on outside click
        document.getElementById('applyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeApplyModal();
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeApplyModal();
            }
        });
    </script>
    @endpush
    
    <!-- Apply Modal -->
    <div id="applyModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-2xl bg-white dark:bg-gray-800">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white" id="modalJobTitle">Apply for Job</h3>
                <button onclick="closeApplyModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <form id="applyForm" method="POST" action="">
                @csrf
                
                <div class="space-y-6">
                    <!-- Cover Letter -->
                    <div>
                        <label for="modal_cover_letter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Cover Letter *
                        </label>
                        <textarea id="modal_cover_letter" name="cover_letter" rows="4" required
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'focus:ring-purple-500' : 'focus:ring-[#1B3C53]' }} focus:border-transparent dark:bg-gray-700 dark:text-white"
                                  placeholder="Introduce yourself and explain why you're the best fit..."></textarea>
                    </div>
                    
                    <!-- Bid Amount -->
                    <div>
                        <label for="modal_bid_amount" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Your Bid Amount ($) *
                        </label>
                        <input type="number" id="modal_bid_amount" name="bid_amount" required min="5" step="0.01"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'focus:ring-purple-500' : 'focus:ring-[#1B3C53]' }} focus:border-transparent dark:bg-gray-700 dark:text-white"
                               placeholder="Enter your bid amount">
                    </div>
                    
                    <!-- Estimated Days -->
                    <div>
                        <label for="modal_estimated_days" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Estimated Days to Complete *
                        </label>
                        <input type="number" id="modal_estimated_days" name="estimated_days" required min="1" max="365"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'focus:ring-purple-500' : 'focus:ring-[#1B3C53]' }} focus:border-transparent dark:bg-gray-700 dark:text-white"
                               placeholder="How many days will you need?">
                    </div>
                    
                    <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" onclick="closeApplyModal()"
                                class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-8 py-3 {{ auth()->check() && auth()->user()->user_type === 'freelancer' ? 'bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900' : 'bg-gradient-to-r from-[#1B3C53] to-[#234C6A] hover:from-[#234C6A] hover:to-[#456882]' }} text-white rounded-lg transition-all duration-300 font-medium">
                            Submit Proposal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>