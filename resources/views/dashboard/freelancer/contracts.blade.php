<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Contracts - WorkNest</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .gradient-text {
            background: linear-gradient(90deg, #8b5cf6 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Work<span class="gradient-text">Nest</span></span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-purple-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('freelancer.proposals') }}" class="text-gray-600 hover:text-purple-600">
                        <i class="fas fa-paper-plane mr-1"></i> Proposals
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-white">My Contracts</h1>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                <div class="text-3xl font-bold">{{ $contracts->total() }}</div>
                <div class="text-white/80">Total Contracts</div>
            </div>
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl p-6 text-white">
                @php $active = $contracts->where('status', 'active')->count(); @endphp
                <div class="text-3xl font-bold">{{ $active }}</div>
                <div class="text-white/80">Active</div>
            </div>
            <div class="bg-gradient-to-r from-purple-700 to-purple-800 rounded-xl p-6 text-white">
                @php $completed = $contracts->where('status', 'completed')->count(); @endphp
                <div class="text-3xl font-bold">{{ $completed }}</div>
                <div class="text-white/80">Completed</div>
            </div>
            <div class="bg-gradient-to-r from-purple-800 to-purple-900 rounded-xl p-6 text-white">
                @php $totalEarnings = $contracts->where('status', 'completed')->sum('amount'); @endphp
                <div class="text-3xl font-bold">${{ number_format($totalEarnings) }}</div>
                <div class="text-white/80">Earned</div>
            </div>
        </div>

        <!-- Contracts Table -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">Active Contracts</h3>
            </div>
            
            @if($contracts->count() > 0)
                <div class="divide-y">
                    @foreach($contracts as $contract)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white">
                                            {{ substr($contract->client->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold">
                                                <a href="{{ route('freelancer.contracts.show', $contract) }}" 
                                                   class="hover:text-purple-600">
                                                    {{ $contract->title }}
                                                </a>
                                            </h4>
                                            <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                                <span>
                                                    <i class="fas fa-user-tie mr-1"></i>
                                                    {{ $contract->client->name }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-dollar-sign mr-1"></i>
                                                    ${{ number_format($contract->amount, 2) }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $contract->start_date->format('M d, Y') }} - {{ $contract->end_date->format('M d, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                                       {{ $contract->status == 'active' ? 'bg-green-100 text-green-800' : 
                                        ($contract->status == 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($contract->status) }}
                                    </span>
                                    <div class="mt-2">
                                        <a href="{{ route('messages.show', $contract->client) }}"
                                           class="text-sm text-purple-600 hover:underline">
                                            <i class="fas fa-envelope mr-1"></i>Message Client
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t">
                    {{ $contracts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-5xl mb-6 text-gray-300">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">No contracts yet</h3>
                    <p class="text-gray-500">When clients accept your proposals, contracts will appear here</p>
                    <a href="{{ route('jobs.index') }}" 
                       class="mt-4 inline-block px-6 py-3 bg-purple-600 text-white rounded-lg">
                        Browse Jobs
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>