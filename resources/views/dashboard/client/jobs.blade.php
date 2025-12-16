<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                My Jobs
            </h2>
            <a href="{{ route('client.jobs.create') }}" 
               class="px-4 py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 flex items-center space-x-2 shadow-lg">
                <i class="fas fa-plus"></i>
                <span>Post New Job</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Job Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('client.jobs') }}?status=all" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'all' ? 'border-[#234C6A]' : 'border-gray-200 dark:border-gray-700' }} hover:border-[#456882] transition-all duration-300 text-center">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $jobStats['all'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">All Jobs</div>
                </a>
                <a href="{{ route('client.jobs') }}?status=open" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'open' ? 'border-green-500' : 'border-gray-200 dark:border-gray-700' }} hover:border-green-500 transition-all duration-300 text-center">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $jobStats['open'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Open</div>
                </a>
                <a href="{{ route('client.jobs') }}?status=in_progress" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'in_progress' ? 'border-blue-500' : 'border-gray-200 dark:border-gray-700' }} hover:border-blue-500 transition-all duration-300 text-center">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $jobStats['in_progress'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">In Progress</div>
                </a>
                <a href="{{ route('client.jobs') }}?status=completed" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'completed' ? 'border-purple-500' : 'border-gray-200 dark:border-gray-700' }} hover:border-purple-500 transition-all duration-300 text-center">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $jobStats['completed'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Completed</div>
                </a>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 mb-6 shadow-lg border border-gray-100 dark:border-gray-700">
                <form method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Search jobs by title or description..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    <button type="submit" 
                            class="px-6 py-2 bg-[#234C6A] text-white rounded-lg hover:bg-[#1B3C53] transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i>
                        Filter
                    </button>
                </form>
            </div>

            <!-- Jobs Table -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Job Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Proposals</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Budget</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Posted</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($jobs as $job)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white mr-3">
                                            <i class="fas fa-briefcase"></i>
                                        </div>
                                        <div>
                                            <a href="{{ route('jobs.show', $job) }}" 
                                               class="font-medium text-gray-900 dark:text-white hover:text-[#234C6A] dark:hover:text-[#456882]">
                                                {{ Str::limit($job->title, 40) }}
                                            </a>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $job->project_length_text }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium 
                                        {{ $job->status === 'open' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                           ($job->status === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 
                                           ($job->status === 'completed' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 
                                           'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300')) }}">
                                        {{ str_replace('_', ' ', ucfirst($job->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <span class="text-lg font-semibold text-gray-800 dark:text-white">
                                            {{ $job->proposals_count }}
                                        </span>
                                        @if($job->proposals_count > 0)
                                        <a href="{{ route('client.proposals') }}?job_id={{ $job->id }}" 
                                           class="ml-2 text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white">
                                            View
                                        </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-lg font-bold text-[#234C6A] dark:text-[#456882]">
                                        {{ $job->formatted_budget ?? 'Fixed' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $job->created_at->format('M d, Y') }}
                                    <div class="text-xs">{{ $job->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('jobs.show', $job) }}" 
                                           class="p-2 text-gray-600 dark:text-gray-400 hover:text-[#234C6A] dark:hover:text-[#456882] hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                           title="View Job">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('client.jobs.edit', $job) }}" 
                                           class="p-2 text-gray-600 dark:text-gray-400 hover:text-green-600 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                           title="Edit Job">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('client.jobs.destroy', $job) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this job?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-gray-600 dark:text-gray-400 hover:text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                                    title="Delete Job">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-briefcase text-4xl mb-4"></i>
                                        <p class="text-lg font-medium mb-2">No jobs posted yet</p>
                                        <p class="mb-6">Start by posting your first job to find freelancers</p>
                                        <a href="{{ route('client.jobs.create') }}" 
                                           class="px-6 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 inline-flex items-center space-x-2">
                                            <i class="fas fa-plus"></i>
                                            <span>Post Your First Job</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($jobs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $jobs->links() }}
                </div>
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-xl p-6 text-white">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-lg mr-4">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[#E3E3E3] text-sm">Total Proposals Received</p>
                            <h3 class="text-2xl font-bold mt-1">
                                {{ collect($jobStats)->sum() > 0 ? number_format($jobStats['all'] * 2) : 0 }}
                            </h3>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-[#456882] to-[#3A5A72] rounded-xl p-6 text-white">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-lg mr-4">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[#E3E3E3] text-sm">Jobs Completed</p>
                            <h3 class="text-2xl font-bold mt-1">{{ $jobStats['completed'] }}</h3>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-[#234C6A] to-[#1B3C53] rounded-xl p-6 text-white">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-lg mr-4">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[#E3E3E3] text-sm">Active Collaborations</p>
                            <h3 class="text-2xl font-bold mt-1">{{ $jobStats['in_progress'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // Status filter animation
            document.querySelectorAll('a[href*="status="]').forEach(link => {
                link.addEventListener('click', function(e) {
                    const currentStatus = new URLSearchParams(window.location.search).get('status');
                    const newStatus = new URLSearchParams(this.href.split('?')[1]).get('status');
                    
                    if (currentStatus === newStatus) {
                        e.preventDefault();
                    }
                });
            });

            // Row hover effects
            document.querySelectorAll('tbody tr').forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = getComputedStyle(document.documentElement)
                        .getPropertyValue('--light-bg') + '20';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });

            // Delete confirmation
            document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to delete this job? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        :root {
            --light-bg: #E3E3E3;
        }

        .dark {
            --light-bg: #2a3b4a;
        }

        table tbody tr {
            transition: all 0.2s ease;
        }

        .status-badge {
            position: relative;
            overflow: hidden;
        }

        .status-badge::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .hover-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(27, 60, 83, 0.1);
        }

        .dark .hover-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .action-btn {
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }
    </style>
    @endpush
</x-app-layout>