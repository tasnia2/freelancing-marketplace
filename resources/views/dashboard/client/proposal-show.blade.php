<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    Proposal Details
                </h2>
                <div class="flex items-center mt-1 space-x-4">
                    <span class="text-gray-600 dark:text-gray-400">From: {{ $proposal->freelancer->name }}</span>
                    <span class="text-gray-400">•</span>
                    <span class="text-gray-600 dark:text-gray-400">For: {{ $proposal->job->title }}</span>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('client.proposals') }}" 
                   class="px-4 py-2 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-[#2a3b4a] transition-all duration-300 flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Proposals</span>
                </a>
                @if($proposal->status === 'pending')
                <div class="flex space-x-2">
                    <form action="{{ route('client.proposals.accept', $proposal) }}" method="POST" 
                          onsubmit="return confirmAccept();">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 flex items-center space-x-2">
                            <i class="fas fa-check"></i>
                            <span>Accept Proposal</span>
                        </button>
                    </form>
                    <form action="{{ route('client.proposals.reject', $proposal) }}" method="POST"
                          onsubmit="return confirm('Reject this proposal?');">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 flex items-center space-x-2">
                            <i class="fas fa-times"></i>
                            <span>Reject</span>
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Proposal Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-8">
                            <!-- Header -->
                            <div class="flex justify-between items-start mb-8">
                                <div>
                                    <div class="flex items-center mb-2">
                                        <span class="px-4 py-2 rounded-full text-sm font-medium {{ $proposal->getStatusBadgeAttribute() }} mr-3">
                                            {{ ucfirst($proposal->status) }} Proposal
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            Submitted {{ $proposal->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                                        Proposal from {{ $proposal->freelancer->name }}
                                    </h1>
                                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                                        For job: <a href="{{ route('jobs.show', $proposal->job) }}" 
                                                    class="text-[#456882] hover:text-[#1B3C53] dark:text-[#456882] font-medium">
                                            {{ $proposal->job->title }}
                                        </a>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-bold text-[#234C6A] dark:text-[#456882]">
                                        ${{ number_format($proposal->bid_amount, 0) }}
                                        @if($proposal->job->job_type === 'hourly')
                                        <span class="text-lg font-normal">/hour</span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Estimated: {{ $proposal->estimated_days }} days
                                    </div>
                                </div>
                            </div>

                            <!-- Cover Letter -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-envelope-open-text text-[#1B3C53] mr-2"></i>
                                    Cover Letter
                                </h3>
                                <div class="prose prose-lg dark:prose-invert max-w-none">
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                                        {!! nl2br(e($proposal->cover_letter)) !!}
                                    </div>
                                </div>
                            </div>

                            <!-- Proposal Terms -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-file-contract text-[#234C6A] mr-2"></i>
                                    Proposed Terms
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Bid Amount</div>
                                        <div class="text-xl font-bold text-gray-800 dark:text-white">
                                            ${{ number_format($proposal->bid_amount, 0) }}
                                            @if($proposal->job->job_type === 'hourly')
                                            <span class="text-sm font-normal">/hour</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Estimated Timeline</div>
                                        <div class="text-xl font-bold text-gray-800 dark:text-white">
                                            {{ $proposal->estimated_days }} days
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Delivered by: {{ now()->addDays($proposal->estimated_days)->format('M d, Y') }}
                                        </div>
                                    </div>
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Job Type</div>
                                        <div class="text-xl font-bold text-gray-800 dark:text-white capitalize">
                                            {{ str_replace('_', ' ', $proposal->job->job_type) }} Price
                                        </div>
                                    </div>
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Experience Level</div>
                                        <div class="text-xl font-bold text-gray-800 dark:text-white capitalize">
                                            {{ $proposal->job->experience_level }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            @if($proposal->status === 'pending')
                            <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex justify-center space-x-6">
                                    <form action="{{ route('client.proposals.accept', $proposal) }}" method="POST" 
                                          onsubmit="return confirmAccept();">
                                        @csrf
                                        <button type="submit" 
                                                class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 font-medium text-lg flex items-center space-x-2 shadow-lg hover:shadow-xl">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Accept & Hire Freelancer</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('client.proposals.reject', $proposal) }}" method="POST"
                                          onsubmit="return confirmReject();">
                                        @csrf
                                        <button type="submit" 
                                                class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 font-medium text-lg flex items-center space-x-2 shadow-lg hover:shadow-xl">
                                            <i class="fas fa-times-circle"></i>
                                            <span>Reject Proposal</span>
                                        </button>
                                    </form>
                                </div>
                                <p class="text-center text-gray-500 dark:text-gray-400 mt-4 text-sm">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Accepting will automatically reject all other proposals for this job
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Similar Proposals -->
                    @if($similarProposals->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-balance-scale text-[#456882] mr-2"></i>
                                Compare with Other Proposals
                            </h3>
                            <div class="space-y-4">
                                @foreach($similarProposals as $similar)
                                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white font-bold mr-3">
                                            {{ substr($similar->freelancer->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">{{ $similar->freelancer->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Rating: {{ number_format($similar->freelancer->average_rating, 1) }} ⭐
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-lg font-bold text-[#234C6A] dark:text-[#456882]">
                                            ${{ number_format($similar->bid_amount, 0) }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $similar->estimated_days }} days
                                        </div>
                                    </div>
                                    <a href="{{ route('client.proposals.show', $similar) }}" 
                                       class="px-3 py-1 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-[#2a3b4a] transition-colors text-sm">
                                        View
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Freelancer Profile -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-user-tie text-[#1B3C53] mr-2"></i>
                                Freelancer Profile
                            </h3>
                            <div class="text-center mb-6">
                                <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white text-2xl font-bold mb-4">
                                    {{ substr($proposal->freelancer->name, 0, 1) }}
                                </div>
                                <h4 class="text-xl font-bold text-gray-800 dark:text-white">{{ $proposal->freelancer->name }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $proposal->freelancer->title ?? 'Freelancer' }}</p>
                                @if($proposal->freelancer->average_rating > 0)
                                <div class="flex items-center justify-center mt-2">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= floor($proposal->freelancer->average_rating) ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-gray-600 dark:text-gray-400">
                                        {{ number_format($proposal->freelancer->average_rating, 1) }} ({{ $proposal->freelancer->reviewsReceived()->count() }} reviews)
                                    </span>
                                </div>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-gray-400 w-5 mr-3"></i>
                                    <span class="text-gray-600 dark:text-gray-400">
                                        {{ $proposal->freelancer->location ?? 'Remote' }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-briefcase text-gray-400 w-5 mr-3"></i>
                                    <span class="text-gray-600 dark:text-gray-400">
                                        {{ $proposal->freelancer->acceptedProposals()->count() ?? 0 }} completed jobs
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-gray-400 w-5 mr-3"></i>
                                    <span class="text-gray-600 dark:text-gray-400">
                                        Member since {{ $proposal->freelancer->created_at->format('M Y') }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <h5 class="font-medium text-gray-800 dark:text-white mb-3">Skills</h5>
                                <div class="flex flex-wrap gap-2">
                                    @if($proposal->freelancer->profile && $proposal->freelancer->profile->skills)
                                        @foreach(json_decode($proposal->freelancer->profile->skills, true) as $skill)
                                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-full text-sm">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400 italic">No skills listed</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="#" 
                                   class="block w-full text-center px-4 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300">
                                    <i class="fas fa-comment mr-2"></i>
                                    Message Freelancer
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Job Details -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-briefcase text-[#234C6A] mr-2"></i>
                                Job Details
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Job Title</div>
                                    <a href="{{ route('jobs.show', $proposal->job) }}" 
                                       class="font-medium text-gray-800 dark:text-white hover:text-[#234C6A] dark:hover:text-[#456882]">
                                        {{ Str::limit($proposal->job->title, 40) }}
                                    </a>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Status</div>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $proposal->job->status === 'open' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                           ($proposal->job->status === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 
                                           'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300') }}">
                                        {{ str_replace('_', ' ', ucfirst($proposal->job->status)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Budget</div>
                                    <div class="text-lg font-bold text-[#234C6A] dark:text-[#456882]">
                                        {{ $proposal->job->formatted_budget ?? 'Fixed Price' }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Experience Required</div>
                                    <div class="text-gray-800 dark:text-white capitalize">{{ $proposal->job->experience_level }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Project Length</div>
                                    <div class="text-gray-800 dark:text-white">{{ $proposal->job->project_length_text }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Proposals</div>
                                    <div class="text-gray-800 dark:text-white">{{ $proposal->job->proposals_count }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-2xl p-6 text-white">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('client.jobs') }}" 
                               class="flex items-center p-3 bg-white/10 rounded-xl hover:bg-white/20 transition-colors">
                                <i class="fas fa-briefcase mr-3"></i>
                                <span>View All Jobs</span>
                            </a>
                            <a href="{{ route('client.proposals') }}" 
                               class="flex items-center p-3 bg-white/10 rounded-xl hover:bg-white/20 transition-colors">
                                <i class="fas fa-file-alt mr-3"></i>
                                <span>All Proposals</span>
                            </a>
                            <a href="#" 
                               class="flex items-center p-3 bg-white/10 rounded-xl hover:bg-white/20 transition-colors">
                                <i class="fas fa-comment mr-3"></i>
                                <span>Start Chat</span>
                            </a>
                            <a href="#" 
                               class="flex items-center p-3 bg-white/10 rounded-xl hover:bg-white/20 transition-colors">
                                <i class="fas fa-question-circle mr-3"></i>
                                <span>Get Help</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function confirmAccept() {
            return confirm(`Are you sure you want to accept this proposal from ${proposalFreelancerName}?\n\nThis will:` +
                         `\n• Hire ${proposalFreelancerName}` +
                         `\n• Reject all other proposals for this job` +
                         `\n• Change job status to "In Progress"`);
        }

        function confirmReject() {
            return confirm(`Are you sure you want to reject this proposal from ${proposalFreelancerName}?\n\nThe freelancer will be notified.`);
        }

        // Store freelancer name for confirmation dialogs
        const proposalFreelancerName = "{{ $proposal->freelancer->name }}";

        document.addEventListener('DOMContentLoaded', function() {
            // Rating stars animation
            const stars = document.querySelectorAll('.fa-star');
            stars.forEach(star => {
                star.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.2)';
                    this.style.transition = 'transform 0.2s';
                });
                
                star.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Skill tags animation
            document.querySelectorAll('.skill-tag').forEach(tag => {
                tag.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 8px rgba(27, 60, 83, 0.2)';
                });
                
                tag.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });

            // Action buttons ripple effect
            document.querySelectorAll('form button[type="submit"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    // Create ripple element
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.7);
                        transform: scale(0);
                        animation: ripple-animation 0.6s linear;
                        width: ${size}px;
                        height: ${size}px;
                        top: ${y}px;
                        left: ${x}px;
                        pointer-events: none;
                    `;
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .prose {
            color: inherit;
        }
        
        .prose a {
            color: #234C6A;
        }
        
        .dark .prose a {
            color: #456882;
        }

        .skill-tag {
            transition: all 0.2s ease;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .job-detail-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .job-detail-card:hover {
            border-left-color: #456882;
            transform: translateX(4px);
        }

        .freelancer-avatar {
            position: relative;
            overflow: hidden;
        }

        .freelancer-avatar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 50%;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
            pointer-events: none;
        }

        .action-button {
            position: relative;
            overflow: hidden;
        }

        .action-button:hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
    @endpush
</x-app-layout>