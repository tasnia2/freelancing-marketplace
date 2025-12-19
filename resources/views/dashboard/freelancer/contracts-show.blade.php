<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl">{{ $contract->title }}</h2>
                <div class="flex items-center space-x-4 mt-2">
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        {{ $contract->status == 'active' ? 'bg-green-100 text-green-800' : 
                           $contract->status == 'completed' ? 'bg-blue-100 text-blue-800' : 
                           'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($contract->status) }}
                    </span>
                    <span class="text-gray-600">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $contract->start_date->format('M d, Y') }} - {{ $contract->end_date->format('M d, Y') }}
                    </span>
                </div>
            </div>
            <a href="{{ route('messages.show', $contract->client) }}"
               class="px-6 py-3 bg-[#456882] text-white rounded-lg hover:bg-[#234C6A]">
                <i class="fas fa-envelope mr-2"></i>Message Client
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Contract Details -->
                    <div class="bg-white rounded-xl shadow p-8">
                        <h3 class="text-xl font-bold mb-6 border-b pb-4">Contract Details</h3>
                        <div class="prose max-w-none">
                            {!! nl2br(e($contract->description)) !!}
                        </div>
                    </div>

                    <!-- Client Info -->
                    <div class="bg-white rounded-xl shadow p-8">
                        <h3 class="text-xl font-bold mb-6 border-b pb-4">Client</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] 
                                      flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($contract->client->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-lg">{{ $contract->client->name }}</h4>
                                <div class="text-gray-600">{{ $contract->client->email }}</div>
                                <div class="flex items-center space-x-4 mt-2">
                                    <a href="{{ route('messages.show', $contract->client) }}"
                                       class="px-4 py-2 bg-[#456882] text-white rounded-lg hover:bg-[#234C6A]">
                                        <i class="fas fa-envelope mr-2"></i>Message
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-8">
                    <!-- Contract Summary -->
                    <div class="bg-white rounded-xl shadow p-8">
                        <h3 class="text-xl font-bold mb-6 border-b pb-4">Contract Summary</h3>
                        <div class="space-y-6">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Contract Value</span>
                                <span class="text-2xl font-bold text-[#1B3C53]">
                                    ${{ number_format($contract->amount, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Duration</span>
                                <span>{{ $contract->start_date->diffInDays($contract->end_date) }} days</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Days Remaining</span>
                                <span class="font-bold">
                                    @if($contract->end_date->isFuture())
                                        {{ now()->diffInDays($contract->end_date) }} days
                                    @else
                                        <span class="text-red-600">Expired</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Job</span>
                                <a href="{{ route('jobs.show', $contract->job) }}"
                                   class="text-[#456882] hover:underline">
                                    {{ $contract->job->title }}
                                </a>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Created</span>
                                <span>{{ $contract->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="bg-white rounded-xl shadow p-8">
                        <h3 class="text-xl font-bold mb-6 border-b pb-4">Payment Status</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span>Contract Amount</span>
                                <span class="font-bold">${{ number_format($contract->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Status</span>
                                <span class="{{ $contract->status == 'completed' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $contract->status == 'completed' ? 'Ready for Payment' : 'In Progress' }}
                                </span>
                            </div>
                            @if($contract->status == 'completed')
                                <button class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    <i class="fas fa-money-check-alt mr-2"></i>Request Payment
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>