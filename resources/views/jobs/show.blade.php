<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    {{ $job->title }}
                </h2>
                <div class="flex items-center space-x-4 mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        {{ $job->experience_badge_class }}">
                        {{ ucfirst($job->experience_level) }}
                    </span>
                    @if($job->is_urgent)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                            <i class="fas fa-bolt mr-1"></i> Urgent
                        </span>
                    @endif
                    @if($job->is_remote)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                            <i class="fas fa-globe mr-1"></i> Remote
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex space-x-3">
                @auth
                    @if(auth()->user()->user_type === 'freelancer')
                        @if($hasApplied)
                            <span class="px-4 py-2 bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 rounded-lg font-medium">
                                <i class="fas fa-check mr-2"></i>Applied
                            </span>
                        @else
                            <button onclick="document.getElementById('applyModal').classList.remove('hidden')"
                                    class="px-6 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-medium">
                                <i class="fas fa-paper-plane mr-2"></i>Apply Now
                            </button>
                        @endif
                    @endif
                    
                    <button id="saveJobBtn" 
                            onclick="toggleSaveJob('{{ $job->id }}')"
                            class="px-4 py-3 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-gray-700 transition-all duration-300">
                        <i class="fas fa-bookmark mr-2"></i>
                        <span id="saveText">{{ $isSaved ? 'Saved' : 'Save Job' }}</span>
                    </button>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-6 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-medium">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login to Apply
                    </a>
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Job Details -->
                <div class="lg:col-span-2">
                    <!-- Job Overview Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8 mb-8">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <i class="fas fa-info-circle text-[#456882] mr-3"></i>Job Overview
                        </h3>
                        
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                        
                        <!-- Skills Section -->
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-bold text-gray-800 dark:text-white mb-4">Required Skills</h4>
                            <div class="flex flex-wrap gap-3">
                                @foreach($job->skills_required as $skill)
                                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 text-[#1B3C53] dark:text-white font-medium">
                                        <i class="fas fa-check text-[#456882] dark:text-[#456882] mr-2"></i>
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Attachments -->
@if($job->attachments && count($job->attachments) > 0)
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
        <h4 class="font-bold text-gray-800 dark:text-white mb-4">Attachments ({{ count($job->attachments) }})</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($job->attachments as $attachment)
                @php
                    // Check if file is an image
                    $isImage = in_array(strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION)), 
                        ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg']);
                    
                    // Get the full URL for the file
                    $fileUrl = Storage::url($attachment['path']);
                @endphp
                
                @if($isImage)
                    <!-- Image Preview -->
                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden hover:border-[#456882] transition-colors">
                        <a href="{{ $fileUrl }}" 
                           target="_blank" 
                           class="block relative group">
                            <div class="aspect-video bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                <img src="{{ $fileUrl }}" 
                                     alt="{{ $attachment['name'] }}"
                                     class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105">
                            </div>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <div class="bg-white/90 dark:bg-gray-800/90 p-2 rounded-full">
                                    <i class="fas fa-expand text-[#456882]"></i>
                                </div>
                            </div>
                        </a>
                        <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-medium text-gray-800 dark:text-white truncate">{{ $attachment['name'] }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($attachment['size'] / 1024, 2) }} KB</div>
                                </div>
                                <a href="{{ $fileUrl }}" 
                                   download
                                   class="p-2 text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white transition-colors"
                                   title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Regular File -->
                    <a href="{{ $fileUrl }}" 
                       target="_blank"
                       class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg hover:border-[#456882] transition-colors bg-white dark:bg-gray-800 group">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            @php
                                $extension = strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION));
                                $icon = match($extension) {
                                    'pdf' => 'fa-file-pdf',
                                    'doc', 'docx' => 'fa-file-word',
                                    'xls', 'xlsx' => 'fa-file-excel',
                                    'ppt', 'pptx' => 'fa-file-powerpoint',
                                    'zip', 'rar', '7z' => 'fa-file-archive',
                                    'txt' => 'fa-file-alt',
                                    default => 'fa-file',
                                };
                            @endphp
                            <i class="fas {{ $icon }} text-[#456882] text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-gray-800 dark:text-white truncate">{{ $attachment['name'] }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <span class="uppercase">{{ $extension }}</span> • {{ number_format($attachment['size'] / 1024, 2) }} KB
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 ml-4">
                            <a href="{{ $fileUrl }}" 
                               target="_blank"
                               class="p-2 text-gray-400 hover:text-[#456882] transition-colors"
                               title="Preview">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <a href="{{ $fileUrl }}" 
                               download
                               class="p-2 text-gray-400 hover:text-[#456882] transition-colors"
                               title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
@endif
                    </div>
                    
                    <!-- Client Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <i class="fas fa-user-tie text-[#456882] mr-3"></i>About the Client
                        </h3>
                        
                        <div class="flex items-start">
    <div class="w-16 h-16 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white text-2xl font-bold mr-6">
        @if($job->client && $job->client->name)
            {{ strtoupper(substr($job->client->name, 0, 1)) }}
        @else
            <i class="fas fa-user"></i>
        @endif
    </div>
    <div class="flex-1">
        <div class="flex justify-between items-start">
            <div>
                <h4 class="font-bold text-gray-800 dark:text-white text-lg">
                    {{ $job->client->name ?? 'Client' }}
                </h4>
                <div class="flex items-center space-x-4 mt-2">
                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>Bangladesh</span>
                    </div>
                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                        <i class="fas fa-clock mr-2"></i>
                        <span>Member since {{ $job->client->created_at->format('M Y') ?? 'Recently' }}</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-[#1B3C53] dark:text-white">4.8</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Client Rating</div>
            </div>
        </div>

                                
                                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="text-2xl font-bold text-[#1B3C53] dark:text-white">{{ $job->client->jobsPosted()->count() }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Jobs Posted</div>
                                    </div>
                                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="text-2xl font-bold text-[#1B3C53] dark:text-white">95%</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Hire Rate</div>
                                    </div>
                                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="text-2xl font-bold text-[#1B3C53] dark:text-white">4.2</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Avg. Rating</div>
                                    </div>
                                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="text-2xl font-bold text-[#1B3C53] dark:text-white">24h</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Avg. Response</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Job Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Job Summary Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8 mb-8 sticky top-6">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <i class="fas fa-clipboard-list text-[#456882] mr-3"></i>Job Summary
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Budget -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 flex items-center justify-center mr-4">
                                        <i class="fas fa-money-bill-wave text-[#456882]"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Budget</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $job->job_type === 'hourly' ? 'Hourly Rate' : 'Fixed Price' }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-[#1B3C53] dark:text-white">
                                        @if($job->job_type === 'hourly')
                                            ${{ number_format($job->hourly_rate, 2) }}/hr
                                        @else
                                            ${{ number_format($job->budget, 0) }}
                                        @endif
                                    </div>
                                    @if($job->job_type === 'hourly')
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $job->hours_per_week }} hrs/week
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Project Length -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 flex items-center justify-center mr-4">
                                        <i class="fas fa-calendar-alt text-[#456882]"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Project Length</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Duration</div>
                                    </div>
                                </div>
                                <div class="text-lg font-medium text-gray-800 dark:text-white">
                                    {{ $job->project_length_text }}
                                </div>
                            </div>
                            
                            <!-- Posted Date -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 flex items-center justify-center mr-4">
                                        <i class="fas fa-clock text-[#456882]"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Posted</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Date</div>
                                    </div>
                                </div>
                                <div class="text-lg font-medium text-gray-800 dark:text-white">
                                    {{ $job->created_at->diffForHumans() }}
                                </div>
                            </div>
                            
                            <!-- Deadline -->
                            @if($job->deadline)
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 flex items-center justify-center mr-4">
                                            <i class="fas fa-hourglass-end text-[#456882]"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">Deadline</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Apply by</div>
                                        </div>
                                    </div>
                                    <div class="text-lg font-medium {{ $job->is_expired ? 'text-red-600' : 'text-gray-800 dark:text-white' }}">
                                        {{ $job->deadline->format('M d, Y') }}
                                        @if($job->is_expired)
                                            <div class="text-sm text-red-500">Expired</div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Proposals -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 flex items-center justify-center mr-4">
                                        <i class="fas fa-users text-[#456882]"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Proposals</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Submitted</div>
                                    </div>
                                </div>
                                <div class="text-lg font-medium text-gray-800 dark:text-white">
                                    {{ $job->proposals_count }}
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 flex items-center justify-center mr-4">
                                        <i class="fas fa-circle text-[#456882]"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-white">Status</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Job Status</div>
                                    </div>
                                </div>
                                <div class="text-lg font-medium 
                                    @if($job->status === 'open') text-green-600
                                    @elseif($job->status === 'in_progress') text-blue-600
                                    @elseif($job->status === 'completed') text-gray-600
                                    @else text-red-600 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                                </div>
                            </div>
                            
                            <!-- Apply Button for Freelancers -->
                            @auth
                                @if(auth()->user()->user_type === 'freelancer' && !$hasApplied)
                                    <button onclick="document.getElementById('applyModal').classList.remove('hidden')"
                                            class="w-full mt-8 py-4 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-xl hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-xl">
                                        <i class="fas fa-paper-plane mr-3"></i>Apply for this Job
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                   class="block w-full mt-8 py-4 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-xl hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-bold text-lg text-center shadow-lg hover:shadow-xl">
                                    <i class="fas fa-sign-in-alt mr-3"></i>Login to Apply
                                </a>
                            @endauth
                        </div>
                    </div>
                    
                    <!-- Similar Jobs -->
                    @if($similarJobs->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                                <i class="fas fa-briefcase text-[#456882] mr-3"></i>Similar Jobs
                            </h3>
                            
                            <div class="space-y-4">
                                @foreach($similarJobs as $similarJob)
                                    <a href="{{ route('jobs.show', $similarJob) }}" 
                                       class="block p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-[#456882] hover:shadow-md transition-all">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-bold text-gray-800 dark:text-white line-clamp-1">{{ $similarJob->title }}</h4>
                                                <div class="flex items-center space-x-3 mt-2">
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                                        <i class="fas fa-clock mr-1"></i>{{ $similarJob->created_at->diffForHumans() }}
                                                    </span>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                                        <i class="fas fa-dollar-sign mr-1"></i>{{ $similarJob->formatted_budget }}
                                                    </span>
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $similarJob->experience_badge_class }}">
                                                {{ ucfirst($similarJob->experience_level) }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Apply Modal -->
    <div id="applyModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-2xl bg-white dark:bg-gray-800">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Apply for "{{ $job->title }}"</h3>
                <button onclick="document.getElementById('applyModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <form action="{{ route('jobs.apply', $job) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-6">
                    <!-- Cover Letter -->
                    <div>
                        <label for="cover_letter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Cover Letter *
                        </label>
                        <textarea id="cover_letter" 
                                  name="cover_letter" 
                                  rows="6"
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                  placeholder="Introduce yourself and explain why you're the best fit for this job..."></textarea>
                    </div>
                    
                    <!-- Bid Amount -->
                    <div>
                        <label for="bid_amount" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Your Bid Amount ($) *
                        </label>
                        <input type="number" 
                               id="bid_amount" 
                               name="bid_amount" 
                               required
                               min="{{ $job->job_type === 'hourly' ? 5 : 10 }}"
                               step="0.01"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                               placeholder="Enter your bid amount">
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            @if($job->job_type === 'hourly')
                                Minimum hourly rate: $5/hour
                            @else
                                Minimum fixed price: $10
                            @endif
                        </p>
                    </div>
                    
                    <!-- Estimated Days -->
                    <div>
                        <label for="estimated_days" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Estimated Days to Complete *
                        </label>
                        <input type="number" 
                               id="estimated_days" 
                               name="estimated_days" 
                               required
                               min="1"
                               max="365"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                    </div>
                    
                   <!-- Attachments -->
<!-- Attachments -->
@if($job->attachments && count($job->attachments) > 0)
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
        <h4 class="font-bold text-gray-800 dark:text-white mb-4">Attachments</h4>
        <div class="space-y-4">
            @foreach($job->attachments as $attachment)
                @php
                    // Check file type
                    $extension = strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION));
                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                    $isPDF = $extension === 'pdf';
                    $isDocument = in_array($extension, ['doc', 'docx', 'txt', 'rtf']);
                    $fileSize = isset($attachment['size']) ? number_format($attachment['size'] / 1024, 2) . ' KB' : 'Unknown size';
                @endphp
                
                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                    <!-- File Header -->
                    <a href="{{ Storage::url($attachment['path']) }}" 
                       target="_blank"
                       class="flex items-center p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="w-12 h-12 rounded-lg 
                            @if($isImage) bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30
                            @elseif($isPDF) bg-gradient-to-r from-red-100 to-red-200 dark:from-red-900/30 dark:to-red-800/30
                            @elseif($isDocument) bg-gradient-to-r from-green-100 to-green-200 dark:from-green-900/30 dark:to-green-800/30
                            @else bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20
                            @endif flex items-center justify-center mr-4">
                            @if($isImage)
                                <i class="fas fa-image text-blue-600 dark:text-blue-400"></i>
                            @elseif($isPDF)
                                <i class="fas fa-file-pdf text-red-600 dark:text-red-400"></i>
                            @elseif($isDocument)
                                <i class="fas fa-file-alt text-green-600 dark:text-green-400"></i>
                            @else
                                <i class="fas fa-file text-[#456882]"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800 dark:text-white">{{ $attachment['name'] }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $attachment['type'] ?? $extension }} • {{ $fileSize }}
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            @if($isImage)
                               <button type="button" 
        class="preview-image-btn p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg"
        data-image-src="{{ Storage::url($attachment['path']) }}"
        data-image-name="{{ $attachment['name'] }}"
        title="Preview Image">
    <i class="fas fa-expand"></i>
</button>
                            @endif
                            <a href="{{ Storage::url($attachment['path']) }}" 
                               target="_blank"
                               class="p-2 text-[#456882] hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg"
                               title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </a>
                    
                    <!-- Image Preview (if image) -->
                    @if($isImage)
                        <div class="border-t border-gray-300 dark:border-gray-600 p-4 bg-gray-50 dark:bg-gray-700">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Preview:</div>
                            <div class="relative h-48 rounded-lg overflow-hidden">
                                <img src="{{ Storage::url($attachment['path']) }}" 
                                     alt="{{ $attachment['name'] }}"
                                     class="w-full h-full object-contain bg-white dark:bg-gray-800 p-2 rounded">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-end justify-center p-4">
                                    <button type="button" 
        class="preview-image-btn px-4 py-2 bg-white/90 dark:bg-gray-800/90 text-gray-800 dark:text-white rounded-lg font-medium hover:bg-white dark:hover:bg-gray-800"
        data-image-src="{{ Storage::url($attachment['path']) }}"
        data-image-name="{{ $attachment['name'] }}">
    <i class="fas fa-expand mr-2"></i>View Full Size
</button>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- PDF Preview (if PDF) -->
                    @if($isPDF)
                        <div class="border-t border-gray-300 dark:border-gray-600 p-4 bg-gray-50 dark:bg-gray-700">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">PDF Preview:</div>
                            <div class="h-48 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600">
                                <iframe src="{{ Storage::url($attachment['path']) }}#view=FitH" 
                                        class="w-full h-full bg-white dark:bg-gray-800"
                                        title="{{ $attachment['name'] }}">
                                </iframe>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif                
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" 
                            onclick="document.getElementById('applyModal').classList.add('hidden')"
                            class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-medium">
                        Submit Proposal
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    @push('scripts')
    <script>
        // Toggle save job
        function toggleSaveJob(jobId) {
            fetch(`/jobs/${jobId}/save`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                const saveText = document.getElementById('saveText');
                const saveBtn = document.getElementById('saveJobBtn');
                
                if (data.saved) {
                    saveText.textContent = 'Saved';
                    saveBtn.classList.add('bg-gradient-to-r', 'from-[#1B3C53]/10', 'to-[#456882]/10', 'dark:from-[#1B3C53]/20', 'dark:to-[#456882]/20');
                    showToast('Job saved successfully!', 'success');
                } else {
                    saveText.textContent = 'Save Job';
                    saveBtn.classList.remove('bg-gradient-to-r', 'from-[#1B3C53]/10', 'to-[#456882]/10', 'dark:from-[#1B3C53]/20', 'dark:to-[#456882]/20');
                    showToast('Job removed from saved', 'info');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred', 'error');
            });
        }
        
        function showToast(message, type) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
        
        // Close modal on outside click
        document.getElementById('applyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
        
        // Close modal on ESC key
       // Handle image preview button clicks
document.addEventListener('DOMContentLoaded', function() {
    // Add click event to all preview buttons
    document.addEventListener('click', function(e) {
        // Check if clicked element or its parent has the preview-image-btn class
        const previewBtn = e.target.closest('.preview-image-btn');
        
        if (previewBtn) {
            e.preventDefault();
            const imageSrc = previewBtn.getAttribute('data-image-src');
            const imageName = previewBtn.getAttribute('data-image-name');
            
            if (imageSrc && imageName) {
                openImageModal(imageSrc, imageName);
            }
        }
    });
});

// Image modal functions
function openImageModal(imageSrc, imageName) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalImageName = document.getElementById('modalImageName');
    const modalImageDownload = document.getElementById('modalImageDownload');
    
    if (!modal || !modalImage) {
        console.error('Modal elements not found');
        return;
    }
    
    modalImage.src = imageSrc;
    modalImage.alt = imageName;
    modalImageName.textContent = imageName;
    
    if (modalImageDownload) {
        modalImageDownload.href = imageSrc;
        modalImageDownload.download = imageName;
    }
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Close modal on background click
const imageModal = document.getElementById('imageModal');
if (imageModal) {
    imageModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
}
    </script>
    @endpush
    
    @push('styles')
    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .prose {
            color: #374151;
            line-height: 1.75;
        }
        
        .dark .prose {
            color: #d1d5db;
        }
        
        .prose p {
            margin-bottom: 1.25em;
        }
        
        .prose ul {
            list-style-type: disc;
            padding-left: 1.25em;
            margin-bottom: 1.25em;
        }
        
        .prose ol {
            list-style-type: decimal;
            padding-left: 1.25em;
            margin-bottom: 1.25em;
        }
        
        .prose li {
            margin-bottom: 0.5em;
        }
        
        .sticky {
            position: sticky;
        }
    </style>
    @endpush
    <!-- Image Preview Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-[90vh]">
        <button onclick="closeImageModal()" 
                class="absolute -top-12 right-0 text-white hover:text-gray-300 text-3xl">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-[80vh] object-contain">
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/70 text-white px-4 py-2 rounded-lg">
            <span id="modalImageName"></span>
            <a href="#" id="modalImageDownload" class="ml-4 text-blue-300 hover:text-blue-100">
                <i class="fas fa-download mr-1"></i>Download
            </a>
        </div>
    </div>
</div>
</x-app-layout>