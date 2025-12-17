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
            <a href="{{ route('jobs.index') }}" 
               class="px-4 py-2 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>{{ __('Back to Jobs') }}</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 mb-8">
                <form method="GET" action="{{ route('search') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <input type="text" 
                                   name="q" 
                                   value="{{ request('q') }}"
                                   placeholder="Search jobs..."
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <!-- Budget Range -->
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" 
                                   name="budget_min" 
                                   value="{{ request('budget_min') }}"
                                   placeholder="Min Budget"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <input type="number" 
                                   name="budget_max" 
                                   value="{{ request('budget_max') }}"
                                   placeholder="Max Budget"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <!-- Submit -->
                        <div>
                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-medium">
                                <i class="fas fa-search mr-2"></i>Search
                            </button>
                        </div>
                    </div>
                    
                    @if(request()->anyFilled(['q', 'budget_min', 'budget_max']))
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Showing {{ $jobs->total() }} results
                            </div>
                            <a href="{{ route('search') }}" 
                               class="text-sm text-[#456882] hover:underline">
                                Clear filters
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Results -->
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
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                                @if($job->experience_level == 'entry') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                @elseif($job->experience_level == 'intermediate') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                                @endif">
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
                                            <div class="font-bold text-gray-800 dark:text-white">
                                                @if($job->job_type == 'hourly')
                                                    ${{ number_format($job->hourly_rate, 2) }}/hr
                                                @else
                                                    ${{ number_format($job->budget, 0) }}
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($job->job_type) }}</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Client -->
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-[#456882] text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">
                                                {{ $job->client->name ?? 'Client' }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Posted {{ $job->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Apply Button -->
                                <div class="mt-6">
                                    <a href="{{ route('jobs.show', $job) }}" 
                                       class="block w-full text-center px-4 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-medium">
                                        <i class="fas fa-eye mr-2"></i>View Details
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
                <!-- No Results -->
                <div class="text-center py-12">
                    <div class="text-5xl mb-6 text-gray-300 dark:text-gray-600">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">No jobs found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Try adjusting your search filters</p>
                    <a href="{{ route('jobs.index') }}" 
                       class="px-6 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300">
                        Browse All Jobs
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>