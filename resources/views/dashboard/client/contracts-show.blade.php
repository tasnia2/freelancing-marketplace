<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl">{{ $contract->title }}</h2>
                <div class="flex items-center space-x-4 mt-2">
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                       {{ $contract->status == 'active' ? 'bg-green-100 text-green-800' : 
                       ($contract->status == 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}>
                        {{ ucfirst($contract->status) }}
                    </span>
                    <span class="text-gray-600">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $contract->start_date->format('M d, Y') }} - {{ $contract->end_date->format('M d, Y') }}
                    </span>
                </div>
            </div>
            @if($contract->status == 'active')
                <form action="{{ route('client.contracts.complete', $contract) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        <i class="fas fa-check mr-2"></i>Mark as Completed
                    </button>
                </form>
            @endif
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

                    <!-- Freelancer Info -->
                    <div class="bg-white rounded-xl shadow p-8">
                        <h3 class="text-xl font-bold mb-6 border-b pb-4">Freelancer</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] 
                                      flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($contract->freelancer->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-lg">{{ $contract->freelancer->name }}</h4>
                                <div class="text-gray-600">{{ $contract->freelancer->email }}</div>
                                <div class="flex items-center space-x-4 mt-2">
                                    <a href="{{ route('messages.show', $contract->freelancer) }}"
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
                                <span>{{ (int) now()->diffInDays($contract->end_date) }} days left</span>
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

                    <!-- Actions -->
                    <div class="bg-white rounded-xl shadow p-8">
                        <h3 class="text-xl font-bold mb-6 border-b pb-4">Actions</h3>
                        <div class="space-y-4">
                            <a href="{{ route('messages.show', $contract->freelancer) }}"
                               class="block w-full text-center px-4 py-3 border border-[#456882] 
                                      text-[#1B3C53] rounded-lg hover:bg-[#E3E3E3]">
                                <i class="fas fa-envelope mr-2"></i>Message Freelancer
                            </a>
                            <a href="#"
                               class="block w-full text-center px-4 py-3 border border-gray-300 
                                      text-gray-700 rounded-lg hover:bg-gray-50">
                                <i class="fas fa-download mr-2"></i>Download Contract
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>