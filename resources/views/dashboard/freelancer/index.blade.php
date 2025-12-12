<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Freelancer Dashboard - WorkNest</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @keyframes progress {
            from { width: 0; }
        }
        
        .progress-bar {
            animation: progress 1.5s ease-in-out;
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg gradient-bg flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800">WorkNest</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-home"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-gray-900 relative">
                        <i class="fas fa-bell"></i>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-gray-900 relative">
                        <i class="fas fa-envelope"></i>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-blue-500 text-white text-xs rounded-full flex items-center justify-center">5</span>
                    </a>
                    
                    <!-- User Menu -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="text-gray-700">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-gray-500"></i>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i> Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Dashboard -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                    <!-- Profile Card -->
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-600">{{ auth()->user()->profile->headline ?? 'Freelancer' }}</p>
                        <div class="flex items-center justify-center mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-{{ $i <= (auth()->user()->getAvgRating() ?? 0) ? 'yellow-400' : 'gray-300' }}"></i>
                            @endfor
                            <span class="ml-2 text-gray-600">({{ auth()->user()->reviews()->count() }})</span>
                        </div>
                    </div>
                    
                    <!-- Profile Completeness -->
                    <div class="mb-6">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Profile Completeness</span>
                            <span class="text-sm font-bold text-blue-600">{{ $stats['profile_completeness'] }}%</span>
                        </div>
                      <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-400 to-blue-500 h-2 rounded-full progress-bar" 
                            data-width="{{ $stats['profile_completeness'] }}" id="progress-bar"></div>
                      </div>

                     <script>
                       document.addEventListener('DOMContentLoaded', function() {
                      const progressBar = document.getElementById('progress-bar');
                      if (progressBar) {
                             const width = progressBar.getAttribute('data-width') + '%';
                        progressBar.style.width = width;
                            }
                                });
                     </script>
                        @if($stats['profile_completeness'] < 100)
                        <p class="text-xs text-gray-500 mt-2">Complete your profile to get more job opportunities</p>
                        @endif
                    </div>
                    
                    <!-- Wallet Balance -->
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-4 mb-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-600">Available Balance</p>
                                <h3 class="text-2xl font-bold text-gray-800">${{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</h3>
                            </div>
                            <button class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg text-sm hover:shadow-lg">
                                Withdraw
                            </button>
                        </div>
                    </div>
                    
                    <!-- Navigation Menu -->
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-briefcase"></i>
                            <span>Browse Jobs</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-paper-plane"></i>
                            <span>My Proposals</span>
                            <span class="ml-auto bg-blue-100 text-blue-600 text-xs font-bold px-2 py-1 rounded-full">{{ $stats['active_proposals'] }}</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-file-contract"></i>
                            <span>Contracts</span>
                            <span class="ml-auto bg-green-100 text-green-600 text-xs font-bold px-2 py-1 rounded-full">{{ $stats['accepted_proposals'] }}</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-comments"></i>
                            <span>Messages</span>
                            <span class="ml-auto bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded-full">5</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Profile</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </nav>
                </div>
                
                <!-- Quick Stats -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Response Rate</span>
                            <span class="font-bold text-green-600">85%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Avg. Response Time</span>
                            <span class="font-bold text-blue-600">2.4h</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Job Success</span>
                            <span class="font-bold text-purple-600">96%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Welcome & Stats -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-gray-600">Here's what's happening with your freelance business today.</p>
                    
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white hover-lift">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-blue-100">Total Earnings</p>
                                    <h3 class="text-2xl font-bold mt-2">${{ number_format($stats['total_earnings'], 2) }}</h3>
                                </div>
                                <i class="fas fa-wallet text-2xl opacity-80"></i>
                            </div>
                            <p class="text-blue-100 text-sm mt-4">+12% from last month</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white hover-lift">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-purple-100">Active Proposals</p>
                                    <h3 class="text-2xl font-bold mt-2">{{ $stats['active_proposals'] }}</h3>
                                </div>
                                <i class="fas fa-paper-plane text-2xl opacity-80"></i>
                            </div>
                            <p class="text-purple-100 text-sm mt-4">Waiting for client review</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white hover-lift">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-green-100">Accepted Jobs</p>
                                    <h3 class="text-2xl font-bold mt-2">{{ $stats['accepted_proposals'] }}</h3>
                                </div>
                                <i class="fas fa-check-circle text-2xl opacity-80"></i>
                            </div>
                            <p class="text-green-100 text-sm mt-4">Currently working on</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 text-white hover-lift">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-orange-100">Completed Jobs</p>
                                    <h3 class="text-2xl font-bold mt-2">{{ $stats['completed_jobs'] }}</h3>
                                </div>
                                <i class="fas fa-trophy text-2xl opacity-80"></i>
                            </div>
                            <p class="text-orange-100 text-sm mt-4">Successfully delivered</p>
                        </div>
                    </div>
                </div>
                
                <!-- Recommended Jobs -->
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Recommended Jobs For You</h2>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    @if($recommendedJobs->count() > 0)
                    <div class="space-y-4">
                        @foreach($recommendedJobs as $job)
                        <div class="border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition-colors duration-300">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $job->title }}</h3>
                                    <div class="flex items-center mt-2 space-x-4">
                                        <span class="text-gray-600 text-sm">
                                            <i class="fas fa-user mr-1"></i> {{ $job->client->name ?? 'Client' }}
                                        </span>
                                        <span class="text-gray-600 text-sm">
                                            <i class="fas fa-clock mr-1"></i> Posted {{ $job->created_at->diffForHumans() }}
                                        </span>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">
                                            {{ ucfirst($job->experience_level) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-gray-800">
                                        @if($job->job_type == 'hourly')
                                            ${{ number_format($job->budget, 2) }}/hr
                                        @else
                                            ${{ number_format($job->budget, 0) }}
                                        @endif
                                    </div>
                                    <button class="mt-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg text-sm hover:shadow-lg transition-all duration-300">
                                        Apply Now
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex flex-wrap gap-2">
                                @if($job->skills)
                                    @foreach(json_decode($job->skills) as $skill)
                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">{{ $skill }}</span>
                                    @endforeach
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Web Development</span>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Laravel</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <i class="fas fa-briefcase text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600">No recommended jobs at the moment.</p>
                        <p class="text-gray-500 text-sm mt-2">Complete your profile to get better job matches.</p>
                    </div>
                    @endif
                </div>
                
                <!-- Recent Proposals -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Recent Proposals</h2>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    @if($recentProposals->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-gray-500 text-sm border-b">
                                    <th class="pb-3">Job Title</th>
                                    <th class="pb-3">Bid Amount</th>
                                    <th class="pb-3">Submitted</th>
                                    <th class="pb-3">Status</th>
                                    <th class="pb-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentProposals as $proposal)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4">
                                        <div class="font-medium text-gray-800">{{ $proposal->job->title ?? 'Job' }}</div>
                                        <div class="text-sm text-gray-500">{{ $proposal->job->client->name ?? 'Client' }}</div>
                                    </td>
                                    <td class="py-4 font-medium text-gray-800">${{ number_format($proposal->bid_amount, 2) }}</td>
                                    <td class="py-4 text-gray-600">{{ $proposal->created_at->diffForHumans() }}</td>
                                    <td class="py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            @if($proposal->status == 'accepted') bg-green-100 text-green-800
                                            @elseif($proposal->status == 'rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ ucfirst($proposal->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        <button class="px-4 py-1 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50">
                                            View
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <i class="fas fa-paper-plane text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600">You haven't submitted any proposals yet.</p>
                        <a href="#" class="inline-block mt-4 px-6 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg hover:shadow-lg">
                            Browse Jobs
                        </a>
                    </div>
                    @endif
                </div>
                
                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-gray-800">Boost Profile</h3>
                                <p class="text-gray-600 text-sm mt-2">Get 3x more views</p>
                            </div>
                            <i class="fas fa-rocket text-2xl text-blue-500"></i>
                        </div>
                        <button class="w-full mt-4 py-2 bg-white border border-blue-500 text-blue-600 rounded-lg text-sm hover:bg-blue-50">
                            Upgrade Now
                        </button>
                    </div>
                    
                    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-gray-800">Add Portfolio</h3>
                                <p class="text-gray-600 text-sm mt-2">Showcase your work</p>
                            </div>
                            <i class="fas fa-images text-2xl text-green-500"></i>
                        </div>
                        <button class="w-full mt-4 py-2 bg-white border border-green-500 text-green-600 rounded-lg text-sm hover:bg-green-50">
                            Add Items
                        </button>
                    </div>
                    
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-gray-800">Get Certified</h3>
                                <p class="text-gray-600 text-sm mt-2">Increase credibility</p>
                            </div>
                            <i class="fas fa-award text-2xl text-purple-500"></i>
                        </div>
                        <button class="w-full mt-4 py-2 bg-white border border-purple-500 text-purple-600 rounded-lg text-sm hover:bg-purple-50">
                            Explore Tests
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            // User dropdown
            const userButton = document.querySelector('button[class*="flex items-center space-x-2"]');
            const userDropdown = userButton?.nextElementSibling;
            
            if (userButton && userDropdown) {
                userButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userButton.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }
            
            // Animate progress bars
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 300);
            });
        });
    </script>
</body>
</html>