<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Proposals - WorkNest</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .gradient-text {
            background: linear-gradient(90deg, #8b5cf6 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(139, 92, 246, 0.15);
        }
        
        .proposal-card {
            transition: all 0.3s ease;
        }
        
        .proposal-card:hover {
            background-color: #f5f3ff;
        }
        
        .dark .proposal-card:hover {
            background-color: rgba(139, 92, 246, 0.05);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Work<span class="gradient-text">Nest</span></span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('jobs.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">
                        <i class="fas fa-search mr-1"></i> Find Jobs
                    </a>
                    <a href="{{ route('freelancer.saved-jobs') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600">
                        <i class="fas fa-bookmark mr-1"></i> Saved Jobs
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
   

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-6 text-white shadow-lg stat-card">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                        <i class="fas fa-paper-plane text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">{{ $proposals->total() }}</div>
                        <div class="text-white/80">Total Proposals</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-6 text-white shadow-lg stat-card">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        @php
                            $pending = $proposals->where('status', 'pending')->count();
                        @endphp
                        <div class="text-3xl font-bold">{{ $pending }}</div>
                        <div class="text-white/80">Pending</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-6 text-white shadow-lg stat-card">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        @php
                            $accepted = $proposals->where('status', 'accepted')->count();
                        @endphp
                        <div class="text-3xl font-bold">{{ $accepted }}</div>
                        <div class="text-white/80">Accepted</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-6 text-white shadow-lg stat-card">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                        <i class="fas fa-dollar-sign text-xl"></i>
                    </div>
                    <div>
                        @php
                            $totalEarnings = $proposals->where('status', 'accepted')->sum('bid_amount');
                        @endphp
                        <div class="text-3xl font-bold">${{ number_format($totalEarnings) }}</div>
                        <div class="text-white/80">Total Earnings</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Proposals Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Proposals</h3>
            </div>
            
            @if($proposals->count() > 0)
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($proposals as $proposal)
                        <div class="p-6 proposal-card">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-800 dark:text-white">
                                                <a href="{{ route('jobs.show', $proposal->job) }}" class="hover:text-primary-600">
                                                    {{ $proposal->job->title }}
                                                </a>
                                            </h4>
                                            <div class="flex items-center space-x-4 mt-2">
                                                <span class="text-gray-600 dark:text-gray-400">
                                                    <i class="fas fa-user-tie mr-1"></i>
                                                    {{ $proposal->job->client->name }}
                                                </span>
                                                <span class="text-gray-600 dark:text-gray-400">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Applied {{ $proposal->created_at->diffForHumans() }}
                                                </span>
                                                <span class="text-gray-600 dark:text-gray-400">
                                                    <i class="fas fa-dollar-sign mr-1"></i>
                                                    ${{ number_format($proposal->bid_amount, 2) }}
                                                </span>
                                                <span class="text-gray-600 dark:text-gray-400">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $proposal->estimated_days }} days
                                                </span>
                                            </div>
                                            
                                            <!-- Cover Letter Preview -->
                                            <div class="mt-3">
                                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                                    {{ Str::limit($proposal->cover_letter, 150) }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <!-- Status Badge -->
                                        <div class="text-right">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                                    'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                    'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses[$proposal->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($proposal->status) }}
                                            </span>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                @if($proposal->status === 'pending')
                                                    <i class="fas fa-clock text-yellow-500 mr-1"></i> Waiting for client response
                                                @elseif($proposal->status === 'accepted')
                                                    <i class="fas fa-check-circle text-green-500 mr-1"></i> You got hired!
                                                @else
                                                    <i class="fas fa-times-circle text-red-500 mr-1"></i> Not selected
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="mt-4 flex justify-end space-x-3">
                                        <a href="{{ route('jobs.show', $proposal->job) }}" 
                                           class="px-4 py-2 border border-primary-500 text-primary-600 dark:text-primary-400 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-sm font-medium">
                                            <i class="fas fa-eye mr-1"></i> View Job
                                        </a>
                                        
                                        @if($proposal->status === 'accepted')
                                            <a href="{{ route('messages.show', $proposal->job->client_id) }}" 
                                               class="px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg hover:shadow-lg text-sm font-medium">
                                                <i class="fas fa-envelope mr-1"></i> Message Client
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $proposals->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <i class="fas fa-paper-plane text-primary-600 dark:text-primary-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">No proposals yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Start applying to jobs to see your proposals here</p>
                    <a href="{{ route('jobs.index') }}" 
                       class="px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg hover:shadow-lg font-medium">
                        <i class="fas fa-search mr-2"></i>Browse Jobs
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-12 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-gray-600 dark:text-gray-400">
            <p>© {{ date('Y') }} WorkNest. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Simple dark mode toggle (optional)
        const darkModeToggle = localStorage.getItem('darkMode');
        if (darkModeToggle === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>