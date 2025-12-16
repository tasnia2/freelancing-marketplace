<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    Job Proposals
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Review and manage proposals from freelancers
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center space-x-2">
                        <i class="fas fa-filter text-[#456882]"></i>
                        <span>Filter</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" 
                         class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-4 z-50">
                        <h4 class="font-medium text-gray-800 dark:text-white mb-3">Filter Proposals</h4>
                        <div class="space-y-3">
                            <select id="jobFilter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="">All Jobs</option>
                                @foreach($jobs as $job)
                                <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                    {{ Str::limit($job->title, 30) }}
                                </option>
                                @endforeach
                            </select>
                            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button onclick="applyFilters()" 
                                    class="w-full px-4 py-2 bg-[#234C6A] text-white rounded-lg hover:bg-[#1B3C53] transition-colors">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
                <div class="relative" x-data="{ showStats: false }">
                    <button @click="showStats = !showStats"
                            class="px-4 py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 flex items-center space-x-2">
                        <i class="fas fa-chart-bar"></i>
                        <span>Stats</span>
                    </button>
                    <div x-show="showStats" @click.away="showStats = false"
                         class="absolute right-0 mt-2 w-72 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 p-4 z-50">
                        <h4 class="font-semibold text-gray-800 dark:text-white mb-3">Proposals Overview</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="text-gray-600 dark:text-gray-400">Total Proposals</span>
                                <span class="text-lg font-bold text-[#1B3C53] dark:text-[#456882]">{{ $proposalStats['all'] }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                <span class="text-yellow-600 dark:text-yellow-400">Pending</span>
                                <span class="text-lg font-bold text-yellow-600 dark:text-yellow-400">{{ $proposalStats['pending'] }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <span class="text-green-600 dark:text-green-400">Accepted</span>
                                <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $proposalStats['accepted'] }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                <span class="text-red-600 dark:text-red-400">Rejected</span>
                                <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ $proposalStats['rejected'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Overview -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('client.proposals') }}?status=all" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'all' ? 'border-[#234C6A]' : 'border-gray-200 dark:border-gray-700' }} hover:border-[#456882] transition-all duration-300 text-center hover-card">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $proposalStats['all'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">All Proposals</div>
                </a>
                <a href="{{ route('client.proposals') }}?status=pending" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'pending' ? 'border-yellow-500' : 'border-gray-200 dark:border-gray-700' }} hover:border-yellow-500 transition-all duration-300 text-center hover-card">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $proposalStats['pending'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pending Review</div>
                </a>
                <a href="{{ route('client.proposals') }}?status=accepted" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'accepted' ? 'border-green-500' : 'border-gray-200 dark:border-gray-700' }} hover:border-green-500 transition-all duration-300 text-center hover-card">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $proposalStats['accepted'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Accepted</div>
                </a>
                <a href="{{ route('client.proposals') }}?status=rejected" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'rejected' ? 'border-red-500' : 'border-gray-200 dark:border-gray-700' }} hover:border-red-500 transition-all duration-300 text-center hover-card">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $proposalStats['rejected'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Rejected</div>
                </a>
            </div>

            <!-- Proposals List -->
            <div class="space-y-6">
                @forelse($proposals as $proposal)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden hover-card">
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                            <!-- Freelancer Info -->
                            <div class="flex items-start space-x-4">
                                <div class="relative">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white text-xl font-bold">
                                        {{ substr($proposal->freelancer->name, 0, 1) }}
                                    </div>
                                    @if($proposal->freelancer->average_rating > 0)
                                    <div class="absolute -bottom-2 -right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center">
                                        <i class="fas fa-star mr-1"></i>
                                        {{ number_format($proposal->freelancer->average_rating, 1) }}
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                        <a href="{{ route('client.proposals.show', $proposal) }}" 
                                           class="hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                                            {{ $proposal->freelancer->name }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $proposal->freelancer->title ?? 'Freelancer' }}
                                    </p>
                                    <div class="flex items-center mt-2 space-x-4">
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $proposal->freelancer->location ?? 'Remote' }}
                                        </div>
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-briefcase mr-1"></i>
                                            {{ $proposal->freelancer->acceptedProposals()->count() ?? 0 }} jobs
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Job Info -->
                            <div class="lg:w-1/3">
                                <h4 class="font-medium text-gray-800 dark:text-white mb-2">For Job:</h4>
                                <a href="{{ route('jobs.show', $proposal->job) }}" 
                                   class="inline-block px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    <div class="font-medium text-gray-800 dark:text-white">{{ Str::limit($proposal->job->title, 40) }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center mt-1">
                                        <span class="px-2 py-1 rounded-full text-xs mr-2 {{ $proposal->job->status === 'open' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' }}">
                                            {{ ucfirst($proposal->job->status) }}
                                        </span>
                                        {{ $proposal->job->experience_level }} level
                                    </div>
                                </a>
                            </div>

                            <!-- Proposal Details -->
                            <div class="lg:w-1/4">
                                <div class="space-y-3">
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Bid Amount</div>
                                        <div class="text-2xl font-bold text-[#234C6A] dark:text-[#456882]">
                                            ${{ number_format($proposal->bid_amount, 0) }}
                                            @if($proposal->job->job_type === 'hourly')
                                            <span class="text-sm font-normal">/hr</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Estimated Time</div>
                                        <div class="font-medium text-gray-800 dark:text-white">
                                            {{ $proposal->estimated_days }} days
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Status</div>
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $proposal->getStatusBadgeAttribute() }}">
                                            {{ ucfirst($proposal->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cover Letter Excerpt -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-800 dark:text-white mb-2">Cover Letter:</h4>
                                    <p class="text-gray-600 dark:text-gray-400 line-clamp-2">
                                        {{ Str::limit(strip_tags($proposal->cover_letter), 200) }}
                                    </p>
                                </div>
                                <a href="{{ route('client.proposals.show', $proposal) }}" 
                                   class="ml-4 text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white font-medium">
                                    Read full proposal →
                                </a>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-clock mr-1"></i>
                                Submitted {{ $proposal->created_at->diffForHumans() }}
                            </div>
                            <div class="flex space-x-3">
                                @if($proposal->status === 'pending')
                                <form action="{{ route('client.proposals.accept', $proposal) }}" method="POST" 
                                      onsubmit="return confirm('Accept this proposal and hire ' + '{{ $proposal->freelancer->name }}' + '?');">
                                    @csrf
                                    <button type="submit" 
                                            class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 flex items-center space-x-2">
                                        <i class="fas fa-check"></i>
                                        <span>Accept Proposal</span>
                                    </button>
                                </form>
                                <form action="{{ route('client.proposals.reject', $proposal) }}" method="POST"
                                      onsubmit="return confirm('Reject this proposal from ' + '{{ $proposal->freelancer->name }}' + '?');">
                                    @csrf
                                    <button type="submit" 
                                            class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 flex items-center space-x-2">
                                        <i class="fas fa-times"></i>
                                        <span>Reject</span>
                                    </button>
                                </form>
                                @elseif($proposal->status === 'accepted')
                                <a href="{{ route('client.contracts.create', ['job' => $proposal->job_id, 'freelancer' => $proposal->freelancer_id]) }}" 
                                   class="px-4 py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 flex items-center space-x-2">
                                    <i class="fas fa-file-contract"></i>
                                    <span>Create Contract</span>
                                </a>
                                @endif
                                
                                <a href="{{ route('client.proposals.show', $proposal) }}" 
                                   class="px-4 py-2 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-[#2a3b4a] transition-all duration-300 flex items-center space-x-2">
                                    <i class="fas fa-eye"></i>
                                    <span>View Details</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-r from-[#E3E3E3] to-gray-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                            <i class="fas fa-file-alt text-4xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">No Proposals Yet</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            You haven't received any proposals yet. Make sure your job posts are detailed and attractive to freelancers.
                        </p>
                        <div class="space-y-3">
                            <a href="{{ route('client.jobs.create') }}" 
                               class="inline-block px-6 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300">
                                <i class="fas fa-plus mr-2"></i>Post a New Job
                            </a>
                            <a href="{{ route('client.jobs') }}" 
                               class="inline-block px-6 py-3 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-[#2a3b4a] transition-all duration-300 ml-3">
                                <i class="fas fa-briefcase mr-2"></i>View Your Jobs
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($proposals->hasPages())
            <div class="mt-8">
                {{ $proposals->links() }}
            </div>
            @endif

            <!-- Tips Section -->
            <div class="mt-8 bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-[#456882] mr-2"></i>
                    Tips for Reviewing Proposals
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#1B3C53] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Check Portfolio</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Review freelancer's past work and ratings
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#234C6A] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Compare Proposals</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Look at multiple proposals before deciding
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#456882] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Ask Questions</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Clarify any doubts before accepting
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#1B3C53] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Consider Value</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Don't just choose the lowest bid
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function applyFilters() {
            const jobId = document.getElementById('jobFilter').value;
            const status = document.getElementById('statusFilter').value;
            
            let url = new URL(window.location.href);
            if (jobId) url.searchParams.set('job_id', jobId);
            else url.searchParams.delete('job_id');
            
            if (status) url.searchParams.set('status', status);
            else url.searchParams.delete('status');
            
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-refresh for new proposals (simulated real-time)
            function checkNewProposals() {
                fetch('/api/proposals/unread-count')
                    .then(response => response.json())
                    .then(data => {
                        if (data.count > 0 && document.querySelector('[x-data]')) {
                            showNotification(`You have ${data.count} new proposal(s)!`);
                        }
                    });
            }
            
            // Check every 30 seconds
            setInterval(checkNewProposals, 30000);

            // Proposal card animations
            document.querySelectorAll('.hover-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                    this.style.boxShadow = '0 20px 40px rgba(27, 60, 83, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });

            // Status badge animations
            document.querySelectorAll('.status-badge').forEach(badge => {
                badge.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                
                badge.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Action confirmation
            document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('button[type="submit"]');
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
                    button.disabled = true;
                });
            });
        });

        function showNotification(message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-gradient-to-r from-[#1B3C53] to-[#456882] text-white px-6 py-4 rounded-lg shadow-xl z-50 transform translate-x-full transition-transform duration-500';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-bell text-xl mr-3"></i>
                    <div>
                        <div class="font-medium">New Proposals!</div>
                        <div class="text-sm opacity-90">${message}</div>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 500);
            }, 5000);
        }
    </script>
    @endpush

    @push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .hover-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .status-badge {
            transition: all 0.2s ease;
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
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .action-btn {
            position: relative;
            overflow: hidden;
        }

        .action-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .action-btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            20% {
                transform: scale(25, 25);
                opacity: 0.3;
            }
            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
        }

        .proposal-card {
            border-left: 4px solid transparent;
        }

        .proposal-card.pending {
            border-left-color: #f59e0b;
        }

        .proposal-card.accepted {
            border-left-color: #10b981;
        }

        .proposal-card.rejected {
            border-left-color: #ef4444;
        }
    </style>
    @endpush
</x-app-layout>