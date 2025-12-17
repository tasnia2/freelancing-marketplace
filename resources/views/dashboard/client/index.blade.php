@extends('layouts.client')

@section('title', 'Client Dashboard')
   @section('header')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                Client Dashboard
            </h2>
        </div>
    </x-slot>
    @endsection

    @section('content')
    <div class="py-6 animate-slide-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Total Jobs Card -->
                <div class="bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-2xl p-6 text-white shadow-lg transform hover:scale-[1.02] transition-transform duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[#E3E3E3] text-sm">Posted Jobs</p>
                            <h3 class="text-3xl font-bold mt-2">{{ $stats['posted_jobs'] }}</h3>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <i class="fas fa-briefcase text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#E3E3E3]">Active</span>
                            <span class="font-semibold">{{ $stats['active_jobs'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Proposals Card -->
                <div class="bg-gradient-to-r from-[#456882] to-[#3A5A72] rounded-2xl p-6 text-white shadow-lg transform hover:scale-[1.02] transition-transform duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[#E3E3E3] text-sm">Total Proposals</p>
                            <h3 class="text-3xl font-bold mt-2">{{ $stats['total_proposals'] }}</h3>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <i class="fas fa-file-alt text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#E3E3E3]">Pending</span>
                            <span class="font-semibold">{{ $stats['pending_proposals'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Financial Card -->
                <div class="bg-gradient-to-r from-[#234C6A] to-[#1B3C53] rounded-2xl p-6 text-white shadow-lg transform hover:scale-[1.02] transition-transform duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[#E3E3E3] text-sm">Total Spent</p>
                            <h3 class="text-3xl font-bold mt-2">${{ number_format($stats['total_spent'], 0) }}</h3>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <i class="fas fa-wallet text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#E3E3E3]">Hired Freelancers</span>
                            <span class="font-semibold">{{ $stats['hired_freelancers'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Quick Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Job Activity Chart -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-chart-line text-[#234C6A] mr-2"></i>
                        Job Activity (Last 6 Months)
                    </h3>
                    <div class="h-64">
                        <canvas id="jobChart"></canvas>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-bolt text-[#456882] mr-2"></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('client.jobs.create') }}" 
                           class="flex items-center p-3 bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-xl hover:from-[#456882] hover:to-[#234C6A] hover:text-white transition-all duration-300 group">
                            <div class="w-10 h-10 rounded-lg bg-[#1B3C53] flex items-center justify-center text-white mr-3 group-hover:bg-white group-hover:text-[#1B3C53] transition-all duration-300">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div>
                                <p class="font-medium">Post New Job</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-300">Hire freelancers</p>
                            </div>
                        </a>
                        <a href="{{ route('client.proposals') }}" 
                           class="flex items-center p-3 bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-xl hover:from-[#456882] hover:to-[#234C6A] hover:text-white transition-all duration-300 group">
                            <div class="w-10 h-10 rounded-lg bg-[#234C6A] flex items-center justify-center text-white mr-3 group-hover:bg-white group-hover:text-[#234C6A] transition-all duration-300">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div>
                                <p class="font-medium">Review Proposals</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-300">
                                    {{ $stats['pending_proposals'] }} pending
                                </p>
                            </div>
                        </a>
                        <a href="{{ route('client.contracts') }}" 
                           class="flex items-center p-3 bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-xl hover:from-[#456882] hover:to-[#234C6A] hover:text-white transition-all duration-300 group">
                            <div class="w-10 h-10 rounded-lg bg-[#456882] flex items-center justify-center text-white mr-3 group-hover:bg-white group-hover:text-[#456882] transition-all duration-300">
                                <i class="fas fa-file-contract"></i>
                            </div>
                            <div>
                                <p class="font-medium">Active Contracts</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-300">
                                    {{ count($activeContracts) }} ongoing
                                </p>
                            </div>
                        </a>
                        <a href="{{ route('client.freelancers') }}" 
                           class="flex items-center p-3 bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-xl hover:from-[#456882] hover:to-[#234C6A] hover:text-white transition-all duration-300 group">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white mr-3 group-hover:bg-white group-hover:text-[#1B3C53] transition-all duration-300">
                                <i class="fas fa-search"></i>
                            </div>
                            <div>
                                <p class="font-medium">Find Freelancers</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-300">Browse talent</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Jobs -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-briefcase text-[#1B3C53] mr-2"></i>
                            Recent Jobs
                        </h3>
                        <a href="{{ route('client.jobs') }}" class="text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white">
                            View All →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentJobs as $job)
                        <div class="p-3 rounded-xl border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300">
                            <div class="flex justify-between items-start">
                                <div>
                                    <a href="{{ route('jobs.show', $job) }}" 
                                       class="font-medium text-gray-800 dark:text-white hover:text-[#234C6A] dark:hover:text-[#456882]">
                                        {{ Str::limit($job->title, 35) }}
                                    </a>
                                    <div class="flex items-center mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="px-2 py-1 rounded-full text-xs {{ $job->status === 'open' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' }}">
                                            {{ str_replace('_', ' ', ucfirst($job->status)) }}
                                        </span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $job->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-[#234C6A] dark:text-[#456882]">
                                        {{ $job->formatted_budget ?? 'Fixed' }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $job->pending_proposals_count }} proposals
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p>No jobs posted yet</p>
                            <a href="{{ route('client.jobs.create') }}" class="text-[#456882] hover:text-[#1B3C53] mt-2 inline-block">
                                Post your first job
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Proposals -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-file-alt text-[#234C6A] mr-2"></i>
                            Recent Proposals
                        </h3>
                        <a href="{{ route('client.proposals') }}" class="text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white">
                            View All →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentProposals as $proposal)
                        <div class="p-3 rounded-xl border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white mr-3">
                                    {{ substr($proposal->freelancer->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <a href="{{ route('client.proposals.show', $proposal) }}" 
                                           class="font-medium text-gray-800 dark:text-white hover:text-[#234C6A] dark:hover:text-[#456882]">
                                            {{ $proposal->freelancer->name }}
                                        </a>
                                        <div class="text-lg font-bold text-[#234C6A] dark:text-[#456882]">
                                            ${{ number_format($proposal->bid_amount, 0) }}
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        For: {{ Str::limit($proposal->job->title, 25) }}
                                    </p>
                                    <div class="flex items-center mt-2 text-xs">
                                        <span class="px-2 py-1 rounded-full {{ $proposal->getStatusBadgeAttribute() }}">
                                            {{ ucfirst($proposal->status) }}
                                        </span>
                                        <span class="mx-2 text-gray-400">•</span>
                                        <span class="text-gray-500">{{ $proposal->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-file-alt text-3xl mb-2"></i>
                            <p>No proposals yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Active Contracts -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-file-contract text-[#456882] mr-2"></i>
                            Active Contracts
                        </h3>
                        <a href="{{ route('client.contracts') }}" class="text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white">
                            View All →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($activeContracts as $contract)
                        <div class="p-3 rounded-xl border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300">
                            <div class="flex justify-between items-start">
                                <div>
                                    <a href="{{ route('client.contracts.show', $contract) }}" 
                                       class="font-medium text-gray-800 dark:text-white hover:text-[#234C6A] dark:hover:text-[#456882]">
                                        {{ Str::limit($contract->title, 30) }}
                                    </a>
                                    <div class="flex items-center mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-3">
                                            <div class="bg-gradient-to-r from-[#1B3C53] to-[#456882] h-2 rounded-full progress-bar" 
                                                  data-progress="{{ $contract->getProgressPercentage() }}"
                                                style="width: 0%"></div>

                                            <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
       // Animate progress bars
                                                       document.querySelectorAll('.progress-bar').forEach(bar => {
                                                       let progress = parseInt(bar.dataset.progress, 10);
                                                        progress = Math.max(0, Math.min(100, progress)); // Ensure 0-100
        
        // Animate the width
                                                       setTimeout(() => {
                                                       bar.style.width = progress + '%';
                                                     bar.style.transition = 'width 1s ease-in-out';
                                                         }, 100);
                                                    });
                                                  });
                                            </script>
                                        </div>
                                        <span>{{ $contract->getProgressPercentage() }}%</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-[#234C6A] dark:text-[#456882]">
                                        ${{ number_format($contract->amount, 0) }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        @if($contract->daysRemaining() > 0)
                                            {{ $contract->daysRemaining() }} days left
                                        @else
                                            Overdue
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center text-sm">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#E3E3E3] to-gray-300 flex items-center justify-center text-gray-600 mr-2">
                                    {{ substr($contract->freelancer->name, 0, 1) }}
                                </div>
                                <span class="text-gray-600 dark:text-gray-400">{{ $contract->freelancer->name }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-file-contract text-3xl mb-2"></i>
                            <p>No active contracts</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                        <i class="fas fa-bell text-[#456882] mr-2"></i>
                        Recent Notifications
                    </h3>
                    <a href="#" class="text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white">
                        Mark all as read
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($notifications as $notification)
                    <div class="p-3 rounded-xl border border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300 {{ !$notification->read ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 
                                {{ $notification->type === 'new_proposal' ? 'bg-green-100 text-green-600' : 
                                   ($notification->type === 'contract_created' ? 'bg-blue-100 text-blue-600' : 
                                   ($notification->type === 'message_received' ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-600')) }}">
                                <i class="fas 
                                    {{ $notification->type === 'new_proposal' ? 'fa-file-alt' : 
                                       ($notification->type === 'contract_created' ? 'fa-file-contract' : 
                                       ($notification->type === 'message_received' ? 'fa-comment' : 'fa-bell')) }}"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h4 class="font-medium text-gray-800 dark:text-white">{{ $notification->title }}</h4>
                                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $notification->message }}</p>
                                @if(!$notification->read)
                                <span class="inline-block w-2 h-2 bg-red-500 rounded-full mt-2"></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-bell-slash text-3xl mb-2"></i>
                        <p>No notifications</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
    @endsection

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Job Activity Chart
            const ctx = document.getElementById('jobChart').getContext('2d');
            const jobChart = new Chart(ctx, {
                type: 'line',
                data: {
                   labels: <?php echo json_encode(isset($chartData) && is_array($chartData) ? array_column($chartData, 'month') : []); ?>,
                    datasets: [{
                        label: 'Jobs Posted',
                        data: <?php echo json_encode(isset($chartData) && is_array($chartData) ? array_column($chartData, 'jobs') : []); ?>,
                        borderColor: '#1B3C53',
                        backgroundColor: 'rgba(27, 60, 83, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#234C6A',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(27, 60, 83, 0.9)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#456882',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        }
                    }
                }
            });

            // Real-time notification updates (simulated)
            function updateNotificationCount() {
                fetch('/api/notifications/unread-count')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.querySelector('.notification-badge');
                        if (badge) {
                            if (data.count > 0) {
                                badge.textContent = data.count;
                                badge.classList.remove('hidden');
                            } else {
                                badge.classList.add('hidden');
                            }
                        }
                    });
            }

            // Update every 30 seconds
            setInterval(updateNotificationCount, 30000);

            // Animate stats cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-slide-in');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.stats-card').forEach(card => {
                observer.observe(card);
            });

            // Dark mode chart updates
            const darkModeToggle = document.querySelector('[x-data]');
            const updateChartTheme = () => {
                const isDark = document.documentElement.classList.contains('dark');
                jobChart.options.scales.x.grid.color = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
                jobChart.options.scales.y.grid.color = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
                jobChart.update();
            };

            // Listen for dark mode changes
            const darkModeObserver = new MutationObserver(updateChartTheme);
            darkModeObserver.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        });

        // Hover animations
        document.querySelectorAll('.hover-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 20px 40px rgba(27, 60, 83, 0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 10px 20px rgba(27, 60, 83, 0.05)';
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        :root {
            --primary-dark: #1B3C53;
            --primary: #234C6A;
            --primary-light: #456882;
            --light-bg: #E3E3E3;
        }

        body {
            font-family: 'Figtree', sans-serif;
        }

        .stats-card {
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.1;
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-20px, -20px) rotate(360deg); }
        }

        .hover-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .notification-dot {
            animation: pulseGlow 2s infinite;
        }

        .progress-bar {
            background: linear-gradient(90deg, #1B3C53, #456882);
            height: 4px;
            border-radius: 2px;
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
    @endpush
