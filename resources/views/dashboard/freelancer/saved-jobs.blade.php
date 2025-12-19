<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Jobs - WorkNest</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    }
                }
            }
        }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .gradient-text {
            background: linear-gradient(90deg, #8b5cf6 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .job-card {
            transition: all 0.3s ease;
        }
        
        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(139, 92, 246, 0.15);
        }
        
        .checkbox:checked {
            background-color: #8b5cf6;
            border-color: #8b5cf6;
        }
        
        .checkbox:checked:after {
            content: '✓';
            color: white;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-50 via-white to-purple-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Work<span class="gradient-text">Nest</span></span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-primary-600">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('jobs.index') }}" class="text-gray-600 hover:text-primary-600">
                        <i class="fas fa-search mr-1"></i> Find Jobs
                    </a>
                    <a href="{{ route('freelancer.proposals') }}" class="text-gray-600 hover:text-primary-600">
                        <i class="fas fa-paper-plane mr-1"></i> My Proposals
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Saved Jobs</h1>
                    <p class="text-gray-600 mt-2">Jobs you've bookmarked for later</p>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Stats -->
                    <div class="hidden md:flex items-center space-x-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-primary-600">{{ $savedJobs->total() }}</div>
                            <div class="text-sm text-gray-600">Total Saved</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">
                                @php
                                    $appliedCount = 0;
                                    foreach ($savedJobs as $job) {
                                        if ($job->proposals->where('freelancer_id', auth()->id())->isNotEmpty()) {
                                            $appliedCount++;
                                        }
                                    }
                                @endphp
                                {{ $appliedCount }}
                            </div>
                            <div class="text-sm text-gray-600">Applied</div>
                        </div>
                    </div>
                    
                    <a href="{{ route('jobs.index') }}" class="px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg hover:shadow-lg">
                        <i class="fas fa-search mr-2"></i> Browse More Jobs
                    </a>
                </div>
            </div>
        </div>

        <!-- Bulk Actions Bar -->
        <div id="bulkActionsBar" class="hidden mb-6 bg-white rounded-xl shadow-sm border p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="selectAll" class="w-5 h-5 rounded border-gray-300">
                        <label for="selectAll" class="ml-2 text-gray-700">
                            <span id="selectedCount">0</span> jobs selected
                        </label>
                    </div>
                    
                    <div class="flex space-x-2">
                        <button id="bulkUnsave" class="px-4 py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-50">
                            <i class="fas fa-trash-alt mr-2"></i> Remove Selected
                        </button>
                        <button id="bulkApply" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                            <i class="fas fa-paper-plane mr-2"></i> Apply to Selected
                        </button>
                    </div>
                </div>
                
                <button id="cancelBulk" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Saved Jobs List -->
            <div class="lg:col-span-2">
                @if($savedJobs->count() > 0)
                    <div class="space-y-4">
                        @foreach($savedJobs as $job)
                        <div class="job-card bg-white rounded-xl shadow-sm border p-6 relative">
                            <!-- Checkbox for bulk selection -->
                            <div class="absolute top-4 left-4 hidden bulk-select">
                                <input type="checkbox" class="job-checkbox w-5 h-5 rounded border-gray-300" 
                                       value="{{ $job->id }}">
                            </div>
                            
                            <!-- Status badge -->
                            <div class="absolute top-4 right-4">
                                @if($job->proposals->where('freelancer_id', auth()->id())->isNotEmpty())
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">
                                    <i class="fas fa-paper-plane mr-1"></i> Applied
                                </span>
                                @endif
                            </div>
                            
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-3">
                                        @if($job->is_urgent)
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">
                                            <i class="fas fa-bolt mr-1"></i> URGENT
                                        </span>
                                        @endif
                                        @if($job->is_featured)
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full">
                                            <i class="fas fa-star mr-1"></i> FEATURED
                                        </span>
                                        @endif
                                    </div>
                                    
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                                        <a href="{{ route('jobs.show', $job) }}" class="hover:text-primary-600">
                                            {{ $job->title }}
                                        </a>
                                    </h3>
                                    
                                    <div class="flex items-center text-gray-600 mb-4">
                                        <div class="flex items-center mr-4">
                                            <div class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center mr-2">
                                                <i class="fas fa-user text-primary-600 text-xs"></i>
                                            </div>
                                            <span>{{ $job->client->name ?? 'Client' }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center mr-2">
                                                <i class="fas fa-clock text-primary-600 text-xs"></i>
                                            </div>
                                            <span>Saved {{ $job->pivot?->created_at?->diffForHumans() ?? 'recently' }}</span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-700 mb-4 line-clamp-2">
                                        {{ Str::limit($job->description, 150) }}
                                    </p>
                                    
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @if($job->skills_required)
                                            @foreach(array_slice($job->skills_required, 0, 3) as $skill)
                                            <span class="px-3 py-1 bg-primary-50 text-primary-700 rounded-full text-sm">
                                                {{ $skill }}
                                            </span>
                                            @endforeach
                                            @if(count($job->skills_required) > 3)
                                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">
                                                +{{ count($job->skills_required) - 3 }} more
                                            </span>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    @if($job->deadline)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        <span>Deadline: {{ $job->deadline->format('M d, Y') }}</span>
                                        @php
                                            $daysLeft = now()->diffInDays($job->deadline, false);
                                        @endphp
                                        @if($daysLeft > 0)
                                        <span class="ml-3 px-2 py-1 bg-{{ $daysLeft <= 3 ? 'red' : 'green' }}-100 text-{{ $daysLeft <= 3 ? 'red' : 'green' }}-800 rounded text-xs">
                                            {{ $daysLeft }} days left
                                        </span>
                                        @else
                                        <span class="ml-3 px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">
                                            Expired
                                        </span>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="ml-6 text-right">
                                    <div class="text-2xl font-bold text-gray-900 mb-4">
                                        {{ $job->formatted_budget }}
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <a href="{{ route('jobs.show', $job) }}" 
                                           class="block px-4 py-2 border border-primary-500 text-primary-600 rounded-lg hover:bg-primary-50 text-sm font-medium">
                                            <i class="fas fa-eye mr-2"></i> View Details
                                        </a>
                                        
                                        @if($job->proposals->where('freelancer_id', auth()->id())->isEmpty())
                                        <button onclick="applyToJob('{{ $job->id }}', '{{ addslashes($job->title) }}')" 
                                                class="w-full px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg hover:shadow-lg text-sm font-medium">
                                            <i class="fas fa-paper-plane mr-2"></i> Apply Now
                                        </button>
                                        @endif
                                        
                                        <button onclick="unsaveJob('{{ $job->id }}')" 
                                                class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium unsave-btn">
                                            <i class="fas fa-trash-alt mr-2"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $savedJobs->links() }}
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl shadow-sm border p-12 text-center">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-primary-100 flex items-center justify-center">
                            <i class="fas fa-bookmark text-primary-600 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No saved jobs yet</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Save jobs that interest you to easily find and apply to them later. 
                            Click the bookmark icon on any job listing to save it here.
                        </p>
                        <div class="space-x-4">
                            <a href="{{ route('jobs.index') }}" 
                               class="inline-block px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg hover:shadow-lg font-medium">
                                <i class="fas fa-search mr-2"></i> Browse Jobs
                            </a>
                            <a href="{{ route('dashboard') }}" 
                               class="inline-block px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                                <i class="fas fa-home mr-2"></i> Go to Dashboard
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Filters -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Filters</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300" id="filter-applied">
                                    <span class="ml-2 text-gray-700">Applied</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300" id="filter-not-applied">
                                    <span class="ml-2 text-gray-700">Not Applied</span>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Budget Range</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="budget" class="rounded-full border-gray-300">
                                    <span class="ml-2 text-gray-700">Under $500</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="budget" class="rounded-full border-gray-300">
                                    <span class="ml-2 text-gray-700">$500 - $2,000</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="budget" class="rounded-full border-gray-300">
                                    <span class="ml-2 text-gray-700">$2,000+</span>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date Saved</label>
                            <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option>Any time</option>
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>Last 90 days</option>
                            </select>
                        </div>
                        
                        <button class="w-full py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                            Apply Filters
                        </button>
                        <button class="w-full py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Clear Filters
                        </button>
                    </div>
                </div>

                <!-- Recommended Jobs -->
                @if($recommendedJobs->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-900">Recommended For You</h3>
                        <a href="{{ route('jobs.index') }}" class="text-primary-600 hover:text-primary-700 text-sm">
                            View All
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($recommendedJobs as $job)
                        <div class="border rounded-lg p-4 hover:border-primary-500 transition-colors">
                            <h4 class="font-medium text-gray-900 mb-2">{{ $job->title }}</h4>
                            <div class="flex justify-between items-center">
                                <span class="text-primary-600 font-bold">{{ $job->formatted_budget }}</span>
                                <button onclick="saveJob('{{ $job->id }}')" 
                                        class="text-gray-400 hover:text-primary-600">
                                    <i class="far fa-bookmark"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tips -->
                <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-6 text-white">
                    <h3 class="font-bold mb-3">💡 Pro Tip</h3>
                    <p class="text-sm opacity-90">
                        Apply to saved jobs within 48 hours of saving them for better response rates. 
                        Set reminders to review your saved jobs weekly.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Apply Modal -->
    <div id="bulkApplyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Apply to Multiple Jobs</h3>
                <button onclick="closeBulkApplyModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="mb-6">
                <p class="text-gray-600 mb-4">You're about to apply to <span id="applyCount" class="font-bold">0</span> jobs.</p>
                <div id="selectedJobsList" class="max-h-40 overflow-y-auto border rounded-lg p-3">
                    <!-- Jobs list will be populated here -->
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cover Letter Template</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Use default template</option>
                        <option value="template1">Quick application</option>
                        <option value="template2">Detailed proposal</option>
                        <option value="template3">Custom</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Custom Message (Optional)</label>
                    <textarea class="w-full border border-gray-300 rounded-lg px-3 py-2" rows="3" 
                              placeholder="Add a personal note that will be included in all applications..."></textarea>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-8">
                <button onclick="closeBulkApplyModal()" 
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button onclick="processBulkApply()" 
                        class="px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i> Apply to All
                </button>
            </div>
        </div>
    </div>

    <script>
        // Bulk selection functionality
        let selectedJobs = new Set();
        
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize bulk actions
            initBulkActions();
            
            // Load saved jobs stats
            loadStats();
        });
        
        function initBulkActions() {
            const selectAll = document.getElementById('selectAll');
            const bulkActionsBar = document.getElementById('bulkActionsBar');
            const jobCheckboxes = document.querySelectorAll('.job-checkbox');
            const bulkSelectDivs = document.querySelectorAll('.bulk-select');
            
            // Show/hide bulk select checkboxes
            selectAll?.addEventListener('click', function() {
                const isChecked = this.checked;
                jobCheckboxes.forEach(cb => {
                    cb.checked = isChecked;
                    cb.closest('.job-card').classList.toggle('border-primary-500', isChecked);
                    if (isChecked) {
                        selectedJobs.add(cb.value);
                    } else {
                        selectedJobs.delete(cb.value);
                    }
                });
                updateBulkUI();
            });
            
            // Individual checkbox changes
            jobCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (this.checked) {
                        selectedJobs.add(this.value);
                        this.closest('.job-card').classList.add('border-primary-500');
                    } else {
                        selectedJobs.delete(this.value);
                        this.closest('.job-card').classList.remove('border-primary-500');
                        document.getElementById('selectAll').checked = false;
                    }
                    updateBulkUI();
                });
            });
            
            // Bulk action buttons
            document.getElementById('bulkUnsave')?.addEventListener('click', bulkUnsave);
            document.getElementById('bulkApply')?.addEventListener('click', showBulkApplyModal);
            document.getElementById('cancelBulk')?.addEventListener('click', cancelBulk);
            
            // Enable bulk mode when any checkbox is checked
            function updateBulkUI() {
                const count = selectedJobs.size;
                document.getElementById('selectedCount').textContent = count;
                
                if (count > 0) {
                    bulkActionsBar.classList.remove('hidden');
                    bulkSelectDivs.forEach(div => div.classList.remove('hidden'));
                } else {
                    bulkActionsBar.classList.add('hidden');
                    bulkSelectDivs.forEach(div => div.classList.add('hidden'));
                }
                
                // Update select all checkbox state
                if (count === jobCheckboxes.length) {
                    document.getElementById('selectAll').checked = true;
                } else {
                    document.getElementById('selectAll').checked = false;
                }
            }
        }
        
        function bulkUnsave() {
            if (selectedJobs.size === 0) return;
            
            if (confirm(`Remove ${selectedJobs.size} saved job(s)?`)) {
                fetch('{{ route("freelancer.saved-jobs.bulk") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        action: 'unsave',
                        job_ids: Array.from(selectedJobs)
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    }
                });
            }
        }
        
        function showBulkApplyModal() {
            if (selectedJobs.size === 0) return;
            
            document.getElementById('applyCount').textContent = selectedJobs.size;
            
            // Populate jobs list
            const jobsList = document.getElementById('selectedJobsList');
            jobsList.innerHTML = '';
            selectedJobs.forEach(jobId => {
                const jobCard = document.querySelector(`.job-checkbox[value="${jobId}"]`)?.closest('.job-card');
                if (jobCard) {
                    const title = jobCard.querySelector('h3').textContent.trim();
                    const div = document.createElement('div');
                    div.className = 'flex items-center justify-between py-2 border-b last:border-0';
                    div.innerHTML = `
                        <span class="text-sm truncate">${title}</span>
                        <span class="text-xs text-gray-500">${jobCard.querySelector('.text-2xl').textContent.trim()}</span>
                    `;
                    jobsList.appendChild(div);
                }
            });
            
            document.getElementById('bulkApplyModal').classList.remove('hidden');
        }
        
        function closeBulkApplyModal() {
            document.getElementById('bulkApplyModal').classList.add('hidden');
        }
        
        function processBulkApply() {
            // In a real app, this would submit applications
            alert(`Applications submitted for ${selectedJobs.size} jobs!`);
            closeBulkApplyModal();
            selectedJobs.clear();
            document.getElementById('bulkActionsBar').classList.add('hidden');
            document.querySelectorAll('.job-checkbox').forEach(cb => {
                cb.checked = false;
                cb.closest('.job-card')?.classList.remove('border-primary-500');
            });
        }
        
        function cancelBulk() {
            selectedJobs.clear();
            document.querySelectorAll('.job-checkbox').forEach(cb => {
                cb.checked = false;
                cb.closest('.job-card')?.classList.remove('border-primary-500');
            });
            document.getElementById('bulkActionsBar').classList.add('hidden');
            document.querySelectorAll('.bulk-select').forEach(div => div.classList.add('hidden'));
        }
        
        // Single job actions
        function saveJob(jobId) {
            fetch(`/freelancer/jobs/${jobId}/save`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    if (data.action === 'saved') {
                        location.reload(); // Refresh to show new saved job
                    }
                }
            });
        }
        
        function unsaveJob(jobId) {
            if (!confirm('Remove this job from saved list?')) return;
            
            fetch(`/freelancer/jobs/${jobId}/unsave`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                }
            });
        }
        
        function applyToJob(jobId, jobTitle) {
            // In a real app, this would show an application form
            // For now, redirect to job show page where apply button exists
            window.location.href = `/jobs/${jobId}`;
        }
        
        function loadStats() {
            fetch('{{ route("freelancer.saved-jobs.stats") }}')
                .then(response => response.json())
                .then(data => {
                    // Update stats in the UI if needed
                    console.log('Saved jobs stats:', data);
                });
        }
        
        // Filter functionality
        document.getElementById('filter-applied')?.addEventListener('change', filterJobs);
        document.getElementById('filter-not-applied')?.addEventListener('change', filterJobs);
        
        function filterJobs() {
            const showApplied = document.getElementById('filter-applied')?.checked;
            const showNotApplied = document.getElementById('filter-not-applied')?.checked;
            
            document.querySelectorAll('.job-card').forEach(card => {
                const hasApplied = card.querySelector('.bg-green-100') !== null;
                let shouldShow = false;
                
                if (showApplied && showNotApplied) {
                    shouldShow = true;
                } else if (showApplied && hasApplied) {
                    shouldShow = true;
                } else if (showNotApplied && !hasApplied) {
                    shouldShow = true;
                } else if (!showApplied && !showNotApplied) {
                    shouldShow = true;
                }
                
                card.style.display = shouldShow ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>