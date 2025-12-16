@extends('layouts.client')

@section('title', 'Contracts')

   @section('header')
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    Contracts
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Manage your agreements with freelancers
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative" x-data="{ showFilters: false }">
                    <button @click="showFilters = !showFilters"
                            class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center space-x-2">
                        <i class="fas fa-filter text-[#456882]"></i>
                        <span>Filter</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div x-show="showFilters" @click.away="showFilters = false" 
                         class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-4 z-50">
                        <h4 class="font-medium text-gray-800 dark:text-white mb-3">Filter Contracts</h4>
                        <div class="space-y-3">
                            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="">All Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                        <h4 class="font-semibold text-gray-800 dark:text-white mb-3">Contracts Overview</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="text-gray-600 dark:text-gray-400">Total Contracts</span>
                                <span class="text-lg font-bold text-[#1B3C53] dark:text-[#456882]">{{ $contractStats['all'] }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <span class="text-blue-600 dark:text-blue-400">Draft</span>
                                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $contractStats['draft'] }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <span class="text-green-600 dark:text-green-400">Active</span>
                                <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $contractStats['active'] }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <span class="text-purple-600 dark:text-purple-400">Completed</span>
                                <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $contractStats['completed'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('client.contracts') }}?status=all" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'all' ? 'border-[#234C6A]' : 'border-gray-200 dark:border-gray-700' }} hover:border-[#456882] transition-all duration-300 text-center hover-card">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $contractStats['all'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">All Contracts</div>
                </a>
                <a href="{{ route('client.contracts') }}?status=draft" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'draft' ? 'border-blue-500' : 'border-gray-200 dark:border-gray-700' }} hover:border-blue-500 transition-all duration-300 text-center hover-card">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $contractStats['draft'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Draft</div>
                </a>
                <a href="{{ route('client.contracts') }}?status=active" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'active' ? 'border-green-500' : 'border-gray-200 dark:border-gray-700' }} hover:border-green-500 transition-all duration-300 text-center hover-card">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $contractStats['active'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Active</div>
                </a>
                <a href="{{ route('client.contracts') }}?status=completed" 
                   class="p-4 bg-white dark:bg-gray-800 rounded-xl border {{ $status === 'completed' ? 'border-purple-500' : 'border-gray-200 dark:border-gray-700' }} hover:border-purple-500 transition-all duration-300 text-center hover-card">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $contractStats['completed'] }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Completed</div>
                </a>
            </div>

            <!-- Contracts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($contracts as $contract)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden hover-card transform transition-all duration-300 hover:-translate-y-1">
                    <!-- Contract Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $contract->status === 'draft' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 
                                       ($contract->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                       ($contract->status === 'completed' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 
                                       'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300')) }}">
                                    {{ ucfirst($contract->status) }}
                                </span>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-[#234C6A] dark:text-[#456882]">
                                    ${{ number_format($contract->amount, 0) }}
                                </div>
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                            <a href="{{ route('client.contracts.show', $contract) }}" 
                               class="hover:text-[#234C6A] dark:hover:text-[#456882] transition-colors">
                                {{ Str::limit($contract->title, 40) }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                            {{ Str::limit($contract->description, 80) }}
                        </p>
                    </div>

                    <!-- Contract Details -->
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Freelancer Info -->
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white font-bold mr-3">
                                    {{ substr($contract->freelancer->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-800 dark:text-white">{{ $contract->freelancer->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Freelancer</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Rating</div>
                                    <div class="flex items-center">
                                        @if($contract->freelancer->average_rating > 0)
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-xs {{ $i <= floor($contract->freelancer->average_rating) ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                            @endfor
                                        @else
                                            <span class="text-xs text-gray-400">No ratings</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Start Date</div>
                                    <div class="font-medium text-gray-800 dark:text-white">
                                        {{ $contract->start_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">End Date</div>
                                    <div class="font-medium text-gray-800 dark:text-white">
                                        {{ $contract->end_date ? $contract->end_date->format('M d, Y') : 'Not set' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Progress -->
                            <div>
                                <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mb-1">
                                    <span>Progress</span>
                                    <span>{{ $contract->getProgressPercentage() }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                          <div id="progress-bar"
                                     data-progress="{{ $contract->getProgressPercentage() }}"
                                  class="bg-gradient-to-r from-[#1B3C53] to-[#456882] 
                                     h-2 rounded-full transition-all duration-700"
                                         style="width: 0%;">
                                     </div>
                               </div>
                               <script>
                                     document.addEventListener('DOMContentLoaded', () => {
                                    const bar = document.getElementById('progress-bar');
                                    if (!bar) return;
               
                                   let progress = parseInt(bar.dataset.progress, 10);

                                   progress = Math.max(0, Math.min(100, progress));

                                            setTimeout(() => {
                                           bar.style.width = progress + '%';
                                             }, 100);
                                             });
                                </script>


                                </div>
                            </div>

                            <!-- Days Remaining -->
                            @if($contract->status === 'active' && $contract->end_date)
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-blue-600 dark:text-blue-400 mr-2"></i>
                                    <div>
                                        <div class="text-sm text-blue-600 dark:text-blue-400">
                                            @php
                                                $daysLeft = $contract->daysRemaining();
                                            @endphp
                                            @if($daysLeft > 0)
                                                {{ $daysLeft }} days remaining
                                            @else
                                                Overdue by {{ abs($daysLeft) }} days
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Contract Actions -->
                    <div class="p-6 pt-0">
                        <div class="flex space-x-3">
                            <a href="{{ route('client.contracts.show', $contract) }}" 
                               class="flex-1 px-4 py-2 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-[#2a3b4a] transition-all duration-300 text-center">
                                View Details
                            </a>
                            @if($contract->status === 'active')
                            <form action="{{ route('client.contracts.complete', $contract) }}" method="POST" 
                                  onsubmit="return confirm('Mark this contract as completed?');">
                                @csrf
                                <button type="submit" 
                                        class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300">
                                    Complete
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="md:col-span-3 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-r from-[#E3E3E3] to-gray-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                            <i class="fas fa-file-contract text-4xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">No Contracts Yet</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            You haven't created any contracts yet. Start by accepting a proposal from a freelancer.
                        </p>
                        <div class="space-y-3">
                            <a href="{{ route('client.proposals') }}" 
                               class="inline-block px-6 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300">
                                <i class="fas fa-file-alt mr-2"></i>View Proposals
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
            @if($contracts->hasPages())
            <div class="mt-8">
                {{ $contracts->links() }}
            </div>
            @endif

            <!-- Contract Tips -->
            <div class="mt-8 bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-[#456882] mr-2"></i>
                    Contract Best Practices
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#1B3C53] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Clear Milestones</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Define clear deliverables and deadlines
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#234C6A] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Regular Updates</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Schedule regular progress check-ins
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#456882] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Payment Terms</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Agree on payment schedule upfront
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#1B3C53] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Scope Management</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Clearly define project scope and changes
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endsection


    @push('scripts')
    <script>
        function applyFilters() {
            const status = document.getElementById('statusFilter').value;
            
            let url = new URL(window.location.href);
            if (status) url.searchParams.set('status', status);
            else url.searchParams.delete('status');
            
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Contract card animations
            document.querySelectorAll('.hover-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.boxShadow = '0 20px 40px rgba(27, 60, 83, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.boxShadow = '';
                });
            });

            // Progress bar animation on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const progressBar = entry.target.querySelector('.progress-bar-fill');
                        if (progressBar) {
                            const width = progressBar.style.width;
                            progressBar.style.width = '0';
                            setTimeout(() => {
                                progressBar.style.width = width;
                            }, 100);
                        }
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.hover-card').forEach(card => {
                observer.observe(card);
            });

            // Contract status updates
            function updateContractStatuses() {
                fetch('/api/contracts/status-updates')
                    .then(response => response.json())
                    .then(data => {
                        if (data.updates && data.updates.length > 0) {
                            showNotification(`${data.updates.length} contract(s) have status updates`);
                        }
                    });
            }
            
            // Check every 60 seconds
            setInterval(updateContractStatuses, 60000);
        });

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-gradient-to-r from-[#1B3C53] to-[#456882] text-white px-6 py-4 rounded-lg shadow-xl z-50 transform translate-x-full transition-transform duration-500';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-bell text-xl mr-3"></i>
                    <div>
                        <div class="font-medium">Contract Updates</div>
                        <div class="text-sm opacity-90">${message}</div>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 500);
            }, 5000);
        }
    </script>
    @endpush

    @push('styles')
    <style>
        .hover-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .progress-bar-fill {
            transition: width 1s ease-in-out;
        }

        .contract-card {
            position: relative;
            overflow: hidden;
        }

        .contract-card::before {
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

        .contract-card:hover::before {
            opacity: 1;
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
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .action-button {
            position: relative;
            overflow: hidden;
        }

        .action-button:hover::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 2s infinite;
        }
    </style>
    @endpush
