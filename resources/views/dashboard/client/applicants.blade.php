<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-800 dark:text-white leading-tight">
                    Applicants for: {{ $job->title }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    {{ $applicants->count() }} proposals received
                </p>
            </div>
            <a href="{{ route('client.jobs') }}" 
               class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                Back to Jobs
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($applicants->count() > 0)
                <div class="space-y-6">
                    @foreach($applicants as $proposal)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                            <div class="flex justify-between items-start">
                                <!-- Freelancer Info -->
                                <div class="flex items-start space-x-4">
                                    <img src="{{ $proposal->freelancer->getAvatarUrl() }}" 
                                         alt="{{ $proposal->freelancer->name }}"
                                         class="w-16 h-16 rounded-full border-2 border-[#456882]">
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-800 dark:text-white">
                                            {{ $proposal->freelancer->name }}
                                        </h3>
                                        <div class="flex items-center space-x-3 mt-1">
                                            <span class="text-yellow-500">
                                                <i class="fas fa-star"></i>
                                                {{ number_format($proposal->freelancer->average_rating, 1) }}
                                            </span>
                                            <span class="text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-briefcase"></i>
                                                {{ $proposal->freelancer->acceptedProposals->count() }} jobs
                                            </span>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                            {{ $proposal->freelancer->title ?? 'Freelancer' }}
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Proposal Details -->
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-[#1B3C53] dark:text-white">
                                        ${{ number_format($proposal->bid_amount, 2) }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Est. {{ $proposal->estimated_days }} days
                                    </div>
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            {{ $proposal->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 
                                               $proposal->status === 'accepted' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 
                                               'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                            {{ ucfirst($proposal->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Cover Letter -->
                            <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                                <h4 class="font-bold text-gray-800 dark:text-white mb-3">Cover Letter:</h4>
                                <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">
                                    {{ $proposal->cover_letter }}
                                </p>
                            </div>
                            
                            <!-- Actions -->
                            @if($proposal->status === 'pending')
                                <div class="mt-6 flex justify-end space-x-3">
                                    <a href="{{ route('client.freelancers') }}/{{ $proposal->freelancer_id }}"
                                       target="_blank"
                                       class="px-4 py-2 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-gray-700">
                                        View Profile
                                    </a>
                                    <a href="{{ route('messages.show', $proposal->freelancer_id) }}"
                                       class="px-4 py-2 bg-gradient-to-r from-[#456882] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#1B3C53]">
                                        Message
                                    </a>
                                    <form action="{{ route('client.proposals.accept', $proposal) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="px-6 py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882]">
                                            Accept Proposal
                                        </button>
                                    </form>
                                    <form action="{{ route('client.proposals.reject', $proposal) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="px-6 py-2 border border-red-300 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-5xl mb-6 text-gray-300 dark:text-gray-600">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">No applicants yet</h3>
                    <p class="text-gray-500 dark:text-gray-400">Proposals will appear here when freelancers apply</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>