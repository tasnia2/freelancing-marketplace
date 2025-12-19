<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - WorkNest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Simple Header -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600">WorkNest</a>
                <a href="{{ route('client.dashboard') }}" class="text-gray-600 hover:text-blue-600">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Search Box -->
        <div class="mb-8">
            <form action="{{ route('search.results') }}" method="GET" class="relative">
                <div class="flex">
                    <input type="text" 
                           name="q"
                           value="{{ $query }}"
                           placeholder="Search jobs, freelancers, skills..." 
                           class="flex-grow px-4 py-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    <select name="type" class="border border-gray-300 border-l-0 px-3 bg-gray-50">
                        <option value="all" {{ $type == 'all' ? 'selected' : '' }}>All</option>
                        <option value="jobs" {{ $type == 'jobs' ? 'selected' : '' }}>Jobs</option>
                        <option value="freelancers" {{ $type == 'freelancers' ? 'selected' : '' }}>Freelancers</option>
                        <option value="skills" {{ $type == 'skills' ? 'selected' : '' }}>Skills</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-r-lg hover:bg-blue-700">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Search Results -->
        <div>
            <h1 class="text-2xl font-bold mb-6">
                Search Results for "{{ $query }}"
                @if($type != 'all')
                    <span class="text-gray-600 text-lg">({{ ucfirst($type) }})</span>
                @endif
            </h1>

            @if(empty($query))
                <div class="text-center py-12">
                    <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600">Enter a search term to get results</p>
                </div>
            @else
                <!-- Jobs Results -->
                @if(($type == 'all' || $type == 'jobs') && $results['jobs']->count() > 0)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <i class="fas fa-briefcase text-blue-600 mr-2"></i>
                            Jobs ({{ $results['jobs']->count() }})
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($results['jobs'] as $job)
                                <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
                                    <h3 class="font-semibold text-lg mb-2">{{ $job->title }}</h3>
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($job->description ?? '', 150) }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-blue-600 font-bold">${{ number_format($job->budget ?? 0, 2) }}</span>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                            {{ $job->status ?? 'open' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Freelancers Results -->
                @if(($type == 'all' || $type == 'freelancers') && $results['freelancers']->count() > 0)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <i class="fas fa-users text-green-600 mr-2"></i>
                            Freelancers ({{ $results['freelancers']->count() }})
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($results['freelancers'] as $freelancer)
                                <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
                                    <div class="flex items-center mb-3">
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg mr-3">
                                            {{ strtoupper(substr($freelancer->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h3 class="font-semibold">{{ $freelancer->name }}</h3>
                                            <p class="text-gray-600 text-sm">{{ $freelancer->title ?? 'Freelancer' }}</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($freelancer->bio ?? '', 100) }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-green-600 font-bold">${{ number_format($freelancer->hourly_rate ?? 0, 2) }}/hr</span>
                                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">
                                            View Profile <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Skills Results -->
                @if(($type == 'all' || $type == 'skills') && $results['skills']->count() > 0)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <i class="fas fa-tags text-purple-600 mr-2"></i>
                            Skills ({{ $results['skills']->count() }})
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($results['skills'] as $skill)
                                <span class="px-4 py-2 bg-purple-100 text-purple-800 rounded-full">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- No Results -->
                @if($results['jobs']->count() == 0 && $results['freelancers']->count() == 0 && $results['skills']->count() == 0)
                    <div class="text-center py-12">
                        <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 mb-4">No results found for "{{ $query }}"</p>
                        <a href="{{ route('client.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-arrow-left mr-2"></i>Return to Dashboard
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>
</body>
</html>