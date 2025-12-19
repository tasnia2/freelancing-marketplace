<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    Freelancer Directory
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Find and hire talented freelancers
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="openAdvancedFilters()"
                        class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center space-x-2">
                    <i class="fas fa-sliders-h text-[#456882]"></i>
                    <span>Advanced Filters</span>
                </button>
                <a href="{{ route('client.jobs.create') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 flex items-center space-x-2">
                    <i class="fas fa-briefcase"></i>
                    <span>Post a Job</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Search and Filters Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 mb-8">
                <form method="GET" class="space-y-4">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Search freelancers by name, skills, or expertise..." 
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <button type="submit" 
                                class="px-6 py-3 bg-[#234C6A] text-white rounded-lg hover:bg-[#1B3C53] transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i>
                            Search
                        </button>
                    </div>
                    
                    <!-- Quick Filters -->
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}" 
                           class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-sm">
                            <i class="fas fa-star text-yellow-500 mr-1"></i>Top Rated
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'jobs_completed']) }}" 
                           class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-sm">
                            <i class="fas fa-check-circle text-green-500 mr-1"></i>Most Jobs
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['available' => 'true']) }}" 
                           class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-sm">
                            <i class="fas fa-circle text-green-500 mr-1"></i>Available Now
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['hourly_rate_max' => 25]) }}" 
                           class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 text-sm">
                            <i class="fas fa-dollar-sign text-blue-500 mr-1"></i>Under $25/hr
                        </a>
                    </div>
                </form>
                
                <!-- Advanced Filters (Initially Hidden) -->
                <div id="advancedFilters" class="hidden mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Hourly Rate Range</label>
                            <div class="flex items-center space-x-3">
                                <input type="number" 
                                       name="hourly_rate_min" 
                                       value="{{ request('hourly_rate_min') }}"
                                       placeholder="Min"
                                       class="w-24 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <span class="text-gray-500">to</span>
                                <input type="number" 
                                       name="hourly_rate_max" 
                                       value="{{ request('hourly_rate_max') }}"
                                       placeholder="Max"
                                       class="w-24 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location</label>
                            <select name="location" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="">Any Location</option>
                                <option value="remote" {{ request('location') == 'remote' ? 'selected' : '' }}>Remote Only</option>
                                <option value="bd" {{ request('location') == 'bd' ? 'selected' : '' }}>Bangladesh</option>
                                <option value="us" {{ request('location') == 'us' ? 'selected' : '' }}>United States</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Skills</label>
                            <input type="text" 
                                   name="skills" 
                                   value="{{ request('skills') }}"
                                   placeholder="e.g., Laravel, Vue.js, React"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" 
                                class="px-6 py-2 bg-[#234C6A] text-white rounded-lg hover:bg-[#1B3C53] transition-colors">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="p-4 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-xl text-white">
                    <div class="text-2xl font-bold">{{ $freelancers->total() }}</div>
                    <div class="text-sm opacity-90">Total Freelancers</div>
                </div>
                <div class="p-4 bg-gradient-to-r from-[#456882] to-[#3A5A72] rounded-xl text-white">
                    <div class="text-2xl font-bold">{{ $freelancers->where('average_rating', '>=', 4.5)->count() }}</div>
                    <div class="text-sm opacity-90">Top Rated (4.5+)</div>
                </div>
                <div class="p-4 bg-gradient-to-r from-[#234C6A] to-[#1B3C53] rounded-xl text-white">
                    <div class="text-2xl font-bold">{{ $freelancers->where('hourly_rate', '<=', 25)->count() }}</div>
                    <div class="text-sm opacity-90">Under $25/hr</div>
                </div>
                <div class="p-4 bg-gradient-to-r from-[#1B3C53] to-[#456882] rounded-xl text-white">
                    <div class="text-2xl font-bold">{{ $freelancers->where('location', 'like', '%bd%')->count() }}</div>
                    <div class="text-sm opacity-90">Bangladeshi</div>
                </div>
            </div>
            
            <!-- Freelancers Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($freelancers as $freelancer)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden hover-card transform transition-all duration-300 hover:-translate-y-1">
                    <!-- Freelancer Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start">
                                <div class="relative">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white text-xl font-bold">
                                        {{ substr($freelancer->name, 0, 1) }}
                                    </div>
                                    @if($freelancer->average_rating >= 4.5)
                                    <div class="absolute -bottom-2 -right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        <i class="fas fa-star mr-1"></i>Top
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                        {{ $freelancer->name }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                        {{ $freelancer->title ?? 'Freelancer' }}
                                    </p>
                                    <div class="flex items-center mt-2">
                                        @if($freelancer->average_rating > 0)
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-xs {{ $i <= floor($freelancer->average_rating) ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                            @endfor
                                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                                {{ number_format($freelancer->average_rating, 1) }}
                                                <span class="text-gray-400">({{ $freelancer->reviews_received_count ?? 0 }})</span>
                                            </span>
                                        </div>
                                        @else
                                        <span class="text-sm text-gray-400">No ratings yet</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-[#234C6A] dark:text-[#456882]">
                                    ${{ number_format($freelancer->hourly_rate ?? 0, 0) }}/hr
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Hourly Rate</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Freelancer Details -->
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Location & Availability -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span>{{ $freelancer->location ?? 'Remote' }}</span>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    <i class="fas fa-circle text-xs mr-1"></i>Available
                                </span>
                            </div>
                            
                            <!-- Skills -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Skills</h4>
                                <div class="flex flex-wrap gap-2">
                                    {{-- Line 208 fix --}}
@if($freelancer->profile && !empty($freelancer->profile->skills))
    @php
        $skills = is_array($freelancer->profile->skills) 
            ? $freelancer->profile->skills 
            : json_decode($freelancer->profile->skills, true);
        $skills = $skills ?? [];
    @endphp
    
    @foreach(array_slice($skills, 0, 4) as $skill)
        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-full text-sm">
            {{ is_array($skill) ? $skill['name'] ?? $skill : $skill }}
        </span>
    @endforeach
                                    @else
                                        <span class="text-gray-400 italic">No skills listed</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-800 dark:text-white">{{ $freelancer->accepted_proposals_count ?? 0 }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Jobs Done</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-800 dark:text-white">100%</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">On Time</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-800 dark:text-white">{{ $freelancer->reviews_received_count ?? 0 }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Reviews</div>
                                </div>
                            </div>
                            
                            <!-- Bio Excerpt -->
                            @if($freelancer->bio)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                    {{ Str::limit($freelancer->bio, 120) }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="p-6 pt-0">
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('messages.show', $freelancer) }}" 
                               class="px-4 py-2 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-[#2a3b4a] transition-all duration-300 text-center">
                                <i class="fas fa-comment mr-2"></i>Message
                            </a>
                            <button onclick="inviteToJob('{{ $freelancer->id }}')"
                                    class="px-4 py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300">
                                <i class="fas fa-briefcase mr-2"></i>Hire Now
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="md:col-span-3 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-r from-[#E3E3E3] to-gray-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                            <i class="fas fa-users text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">No freelancers found</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Try adjusting your search criteria or post a job to attract freelancers.
                        </p>
                        <div class="space-y-3">
                            <a href="{{ route('client.jobs.create') }}" 
                               class="inline-block px-6 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300">
                                <i class="fas fa-plus mr-2"></i>Post a Job
                            </a>
                            <button onclick="clearFilters()" 
                                    class="inline-block px-6 py-3 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-[#2a3b4a] transition-all duration-300 ml-3">
                                <i class="fas fa-filter mr-2"></i>Clear Filters
                            </button>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($freelancers->hasPages())
            <div class="mt-8">
                {{ $freelancers->links() }}
            </div>
            @endif
            
            <!-- Hiring Tips -->
            <div class="mt-8 bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-[#456882] mr-2"></i>
                    Tips for Hiring Freelancers
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#1B3C53] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Check Portfolio</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Review past work and client testimonials
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#234C6A] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Clear Communication</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Ensure they understand your requirements
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#456882] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Set Milestones</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Break projects into manageable chunks
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#1B3C53] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Use Contracts</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Formalize agreements to protect both parties
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Invite to Job Modal -->
    <div id="inviteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Invite to Job</h3>
                    <button onclick="closeInviteModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="inviteModalContent">
                    <!-- Content will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openAdvancedFilters() {
            document.getElementById('advancedFilters').classList.toggle('hidden');
        }
        
        function clearFilters() {
            window.location.href = "{{ route('client.freelancers') }}";
        }
        
        function inviteToJob(freelancerId) {
            fetch(`/client/freelancers/${freelancerId}/invite-modal`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('inviteModalContent').innerHTML = html;
                    document.getElementById('inviteModal').classList.remove('hidden');
                });
        }
        
        function closeInviteModal() {
            document.getElementById('inviteModal').classList.add('hidden');
        }
        
        // Close modal when clicking outside
        document.getElementById('inviteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeInviteModal();
            }
        });
        
        // Freelancer card animations
        document.querySelectorAll('.hover-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 20px 40px rgba(27, 60, 83, 0.15)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '';
            });
        });
        
        // Search debounce
        let searchTimeout;
        document.querySelector('input[name="search"]').addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (e.target.value.length > 2 || e.target.value.length === 0) {
                    this.form.submit();
                }
            }, 500);
        });
        
        // Filter by skills
        document.querySelectorAll('.skill-tag').forEach(tag => {
            tag.addEventListener('click', function() {
                const skill = this.textContent.trim();
                const url = new URL(window.location.href);
                url.searchParams.set('skills', skill);
                window.location.href = url.toString();
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .hover-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .line-clamp-2 {
           display: -webkit-box;
            display: -moz-box;
            display: box;
            -webkit-line-clamp: 2;
            -moz-line-clamp: 2;
            line-clamp: 2; /* Standard property */
            -webkit-box-orient: vertical;
            -moz-box-orient: vertical;
            box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .skill-tag {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .skill-tag:hover {
            background: linear-gradient(135deg, #1B3C53, #456882);
            color: white;
            transform: translateY(-2px);
        }
        
        .freelancer-card {
            position: relative;
            overflow: hidden;
        }
        
        .freelancer-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1B3C53, #456882);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .freelancer-card:hover::before {
            opacity: 1;
        }
        
        .rating-stars {
            position: relative;
        }
        
        .rating-stars::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .availability-dot {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
    @endpush
</x-app-layout>