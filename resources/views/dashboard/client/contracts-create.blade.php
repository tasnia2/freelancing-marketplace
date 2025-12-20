<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl">My Contracts</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-xl p-6 text-white">
                    <div class="text-3xl font-bold">{{ $contracts->total() }}</div>
                    <div class="text-white/80">Total Contracts</div>
                </div>
                <div class="bg-gradient-to-r from-[#234C6A] to-[#456882] rounded-xl p-6 text-white">
                    @php $active = $contracts->where('status', 'active')->count(); @endphp
                    <div class="text-3xl font-bold">{{ $active }}</div>
                    <div class="text-white/80">Active</div>
                </div>
                <div class="bg-gradient-to-r from-[#456882] to-[#1B3C53] rounded-xl p-6 text-white">
                    @php $completed = $contracts->where('status', 'completed')->count(); @endphp
                    <div class="text-3xl font-bold">{{ $completed }}</div>
                    <div class="text-white/80">Completed</div>
                </div>
                <div class="bg-gradient-to-r from-[#1B3C53] to-[#456882] rounded-xl p-6 text-white">
                    @php $totalAmount = $contracts->sum('amount'); @endphp
                    <div class="text-3xl font-bold">${{ number_format($totalAmount) }}</div>
                    <div class="text-white/80">Total Value</div>
                </div>
            </div>

            <!-- Contracts Table -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">All Contracts</h3>
                </div>
                
                @if($contracts->count() > 0)
                    <div class="divide-y">
                        @foreach($contracts as $contract)
                            <div class="p-6 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full bg-[#456882] flex items-center justify-center text-white">
                                                {{ substr($contract->freelancer->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold">
                                                    <a href="{{ route('client.contracts.show', $contract) }}" 
                                                       class="hover:text-[#456882]">
                                                        {{ $contract->title }}
                                                    </a>
                                                </h4>
                                                <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                                    <span>
                                                        <i class="fas fa-user mr-1"></i>
                                                        {{ $contract->freelancer->name }}
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
       ($contract->status == 'completed' ? 'bg-blue-100 text-blue-800' : 
       'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($contract->status) }}
                                        </span>
                                        <div class="mt-2 text-sm text-gray-500">
                                            Created {{ $contract->created_at->diffForHumans() }}
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
                        <p class="text-gray-500">Contracts will appear here when you hire freelancers</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>