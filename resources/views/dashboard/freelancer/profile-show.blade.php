<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - WorkNest</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(139, 92, 246, 0.15);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Work<span class="text-purple-600">Nest</span></span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-purple-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('profile.edit') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                        <i class="fas fa-edit mr-1"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Profile Header -->
    <div class="gradient-bg text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                <!-- Avatar -->
                <div class="relative">
                    <img src="{{ $user->getAvatarUrl() }}" 
                         alt="{{ $user->name }}" 
                         class="w-32 h-32 rounded-full border-4 border-white shadow-lg">
                    @if($user->getProfileCompletenessPercentageRoleBased() >= 80)
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    @endif
                </div>
                
                <!-- Profile Info -->
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                            <p class="text-xl opacity-90 mt-1">{{ $user->title ?? 'Freelancer' }}</p>
                            <div class="flex items-center justify-center md:justify-start space-x-4 mt-3">
                                <span>
                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $user->location ?? 'Not specified' }}
                                </span>
                                <span>
                                    <i class="fas fa-clock mr-1"></i> Member since {{ $user->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Completeness -->
                    <div class="mt-6">
                        <div class="flex justify-between mb-2">
                            <span class="opacity-90">Profile Strength</span>
                            <span class="font-bold">{{ $user->getProfileCompletenessPercentageRoleBased() }}%</span>
                        </div>
                        <div class="w-full bg-white/30 rounded-full h-2">
                            <div class="bg-white h-2 rounded-full" 
                                 style="width: '{{ $user->getProfileCompletenessPercentageRoleBased() }}%'"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- About Me -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">About Me</h2>
                    @if($user->bio)
                        <p class="text-gray-700 whitespace-pre-line">{{ $user->bio }}</p>
                    @else
                        <p class="text-gray-500 italic">No bio added yet.</p>
                    @endif
                </div>

                <!-- Skills -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Skills</h2>
                    @if($user->profile && !empty($user->profile->skills))
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->profile->skills as $skill)
                                <span class="bg-purple-100 text-purple-700 px-4 py-2 rounded-lg font-medium">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">No skills added yet.</p>
                    @endif
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact Information</h2>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-gray-500 w-6"></i>
                            <span class="ml-3">{{ $user->email }}</span>
                        </div>
                        @if($user->phone)
                        <div class="flex items-center">
                            <i class="fas fa-phone text-gray-500 w-6"></i>
                            <span class="ml-3">{{ $user->phone }}</span>
                        </div>
                        @endif
                        @if($user->location)
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-gray-500 w-6"></i>
                            <span class="ml-3">{{ $user->location }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Stats Card -->
                <div class="gradient-bg rounded-xl p-6 text-white stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="opacity-90">Hourly Rate</p>
                            <h3 class="text-3xl font-bold mt-2">${{ number_format($user->hourly_rate ?? 0, 2) }}/hr</h3>
                        </div>
                        <i class="fas fa-dollar-sign text-2xl opacity-80"></i>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Jobs Completed</span>
                            <span class="font-bold text-purple-600">{{ $user->acceptedProposals->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Success Rate</span>
                            <span class="font-bold text-green-600">98%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Response Time</span>
                            <span class="font-bold text-blue-600">2.1 hours</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('profile.edit') }}" class="block w-full text-center py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            <i class="fas fa-edit mr-2"></i> Edit Profile
                        </a>
                        <a href="{{ route('jobs.index') }}" class="block w-full text-center py-3 border border-purple-600 text-purple-600 rounded-lg hover:bg-purple-50">
                            <i class="fas fa-search mr-2"></i> Find Jobs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-gray-600">
            <p>© {{ date('Y') }} WorkNest. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>