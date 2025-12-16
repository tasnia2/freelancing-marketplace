@extends('layouts.client')

@section('title', 'Create Contract')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
            Create Contract
        </h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">
            Create a formal agreement with {{ $freelancer->name }}
        </p>
    </div>
    <a href="{{ route('client.proposals.show', $proposal) }}" 
       class="px-4 py-2 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-[#2a3b4a] transition-all duration-300 flex items-center space-x-2">
        <i class="fas fa-arrow-left"></i>
        <span>Back to Proposal</span>
    </a>
</div>
@endsection

@section('content')

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#234C6A] flex items-center justify-center text-white font-bold">
                            1
                        </div>
                        <div class="ml-3">
                            <div class="font-medium text-gray-800 dark:text-white">Basic Info</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Title, description, amount</div>
                        </div>
                    </div>
                    <div class="h-1 flex-1 mx-4 bg-gray-200 dark:bg-gray-700"></div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold">
                            2
                        </div>
                        <div class="ml-3">
                            <div class="font-medium text-gray-500 dark:text-gray-400">Milestones</div>
                            <div class="text-sm text-gray-400 dark:text-gray-600">Deliverables & deadlines</div>
                        </div>
                    </div>
                    <div class="h-1 flex-1 mx-4 bg-gray-200 dark:bg-gray-700"></div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold">
                            3
                        </div>
                        <div class="ml-3">
                            <div class="font-medium text-gray-500 dark:text-gray-400">Terms & Finalize</div>
                            <div class="text-sm text-gray-400 dark:text-gray-600">Review and create</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contract Creation Form -->
            <form id="contractForm" action="{{ route('client.contracts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <input type="hidden" name="freelancer_id" value="{{ $freelancer->id }}">

                <!-- Step 1: Basic Information -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
                    <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-info-circle text-[#234C6A] mr-2"></i>
                            Contract Information
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Contract Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Contract Title *
                                </label>
                                <input type="text" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $job->title) }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                       placeholder="e.g., Website Development Agreement">
                            </div>

                            <!-- Contract Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Detailed Description *
                                </label>
                                <textarea id="description" 
                                          name="description" 
                                          rows="6"
                                          required
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                          placeholder="Describe the scope of work, deliverables, and any specific requirements...">{{ old('description', $job->description) }}</textarea>
                            </div>

                            <!-- Contract Amount -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Contract Amount ($) *
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400">$</span>
                                        </div>
                                        <input type="number" 
                                               id="amount" 
                                               name="amount" 
                                               value="{{ old('amount', $proposal->bid_amount) }}"
                                               min="10"
                                               step="10"
                                               required
                                               class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Start Date *
                                        </label>
                                        <input type="date" 
                                               id="start_date" 
                                               name="start_date" 
                                               value="{{ old('start_date', date('Y-m-d')) }}"
                                               required
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            End Date *
                                        </label>
                                        <input type="date" 
                                               id="end_date" 
                                               name="end_date" 
                                               value="{{ old('end_date', date('Y-m-d', strtotime('+' . $proposal->estimated_days . ' days'))) }}"
                                               required
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parties Information -->
                    <div class="p-8">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-users text-[#456882] mr-2"></i>
                            Parties Involved
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Client (You) -->
                            <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white font-bold mr-4">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800 dark:text-white">You (Client)</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-user-tie w-5 mr-2"></i>
                                        <span>{{ Auth::user()->name }}</span>
                                    </div>
                                    @if(Auth::user()->company)
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-building w-5 mr-2"></i>
                                        <span>{{ Auth::user()->company }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Freelancer -->
                            <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-[#234C6A] to-[#456882] flex items-center justify-center text-white font-bold mr-4">
                                        {{ substr($freelancer->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800 dark:text-white">{{ $freelancer->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Freelancer</div>
                                    </div>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-user-tie w-5 mr-2"></i>
                                        <span>{{ $freelancer->title ?? 'Freelancer' }}</span>
                                    </div>
                                    @if($freelancer->location)
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-map-marker-alt w-5 mr-2"></i>
                                        <span>{{ $freelancer->location }}</span>
                                    </div>
                                    @endif
                                    @if($freelancer->average_rating > 0)
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-star w-5 mr-2 text-yellow-500"></i>
                                        <span>{{ number_format($freelancer->average_rating, 1) }} rating</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Milestones -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
                    <div class="p-8">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-tasks text-[#1B3C53] mr-2"></i>
                            Milestones & Deliverables
                        </h3>
                        
                        <div class="mb-6">
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                Break down the project into manageable milestones. Each milestone should have a clear deliverable and deadline.
                            </p>
                            <button type="button" 
                                    onclick="addMilestone()"
                                    class="px-4 py-2 bg-[#456882] text-white rounded-lg hover:bg-[#234C6A] transition-colors flex items-center space-x-2">
                                <i class="fas fa-plus"></i>
                                <span>Add Milestone</span>
                            </button>
                        </div>

                        <div id="milestonesContainer" class="space-y-6">
                            <!-- Milestones will be added here -->
                            <div id="noMilestones" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <i class="fas fa-tasks text-3xl mb-2"></i>
                                <p>No milestones added yet</p>
                                <p class="text-sm mt-1">Add at least one milestone to continue</p>
                            </div>
                        </div>
                        <input type="hidden" name="milestones" id="milestonesHidden" value="[]">
                    </div>
                </div>

                <!-- Step 3: Terms & Finalize -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
                    <div class="p-8">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-file-contract text-[#234C6A] mr-2"></i>
                            Terms & Conditions
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Standard Terms -->
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-white mb-4">Standard Terms</h4>
                                <div class="space-y-3">
                                    <label class="flex items-start p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                        <input type="checkbox" name="terms[]" value="intellectual_property" class="mt-1 mr-3 text-[#1B3C53] focus:ring-[#1B3C53]" checked>
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">Intellectual Property</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                All work created under this contract becomes the property of the client upon full payment.
                                            </div>
                                        </div>
                                    </label>
                                    <label class="flex items-start p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                        <input type="checkbox" name="terms[]" value="confidentiality" class="mt-1 mr-3 text-[#1B3C53] focus:ring-[#1B3C53]" checked>
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">Confidentiality</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                Both parties agree to keep project details confidential.
                                            </div>
                                        </div>
                                    </label>
                                    <label class="flex items-start p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                        <input type="checkbox" name="terms[]" value="payment_terms" class="mt-1 mr-3 text-[#1B3C53] focus:ring-[#1B3C53]" checked>
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">Payment Terms</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                Payment will be released upon milestone completion and client approval.
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Custom Terms -->
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-white mb-4">Custom Terms (Optional)</h4>
                                <div id="customTermsContainer" class="space-y-3">
                                    <div class="flex space-x-3">
                                        <input type="text" 
                                               id="customTermInput"
                                               class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                               placeholder="Add a custom term...">
                                        <button type="button" 
                                                onclick="addCustomTerm()"
                                                class="px-4 py-2 bg-[#456882] text-white rounded-lg hover:bg-[#234C6A] transition-colors">
                                            Add
                                        </button>
                                    </div>
                                    <div id="customTermsList" class="space-y-2">
                                        <!-- Custom terms will be added here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Attachments -->
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-white mb-4">Attachments (Optional)</h4>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center hover:border-[#456882] transition-colors cursor-pointer" 
                                     onclick="document.getElementById('attachments').click()"
                                     id="dropZone">
                                    <input type="file" 
                                           id="attachments" 
                                           name="attachments[]" 
                                           multiple 
                                           class="hidden"
                                           accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                                    <div class="text-4xl mb-4 text-gray-400">📎</div>
                                    <div class="font-medium text-gray-700 dark:text-gray-300">
                                        Drop files here or click to upload
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                        Max file size: 5MB. PDF, DOC, TXT, JPG, PNG
                                    </div>
                                </div>
                                <div id="fileList" class="mt-4 space-y-2">
                                    <!-- Files will be listed here -->
                                </div>
                            </div>

                            <!-- Summary -->
                            <div class="p-6 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-xl text-white">
                                <h4 class="font-semibold mb-4">Contract Summary</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <div class="opacity-80">Freelancer</div>
                                        <div class="font-medium">{{ $freelancer->name }}</div>
                                    </div>
                                    <div>
                                        <div class="opacity-80">Total Amount</div>
                                        <div class="font-medium">$<span id="summaryAmount">0</span></div>
                                    </div>
                                    <div>
                                        <div class="opacity-80">Duration</div>
                                        <div class="font-medium" id="summaryDuration">0 days</div>
                                    </div>
                                    <div>
                                        <div class="opacity-80">Milestones</div>
                                        <div class="font-medium" id="summaryMilestones">0</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-shield-alt text-[#234C6A] mr-1"></i>
                                        This contract is legally binding
                                    </div>
                                    <button type="submit" 
                                            class="px-8 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-medium text-lg flex items-center space-x-2 shadow-lg hover:shadow-xl">
                                        <i class="fas fa-file-signature"></i>
                                        <span>Create Contract</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Contract Tips -->
            <div class="mt-8 bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-[#456882] mr-2"></i>
                    Contract Creation Tips
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#1B3C53] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Be Specific</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Clearly define deliverables, timelines, and quality standards
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#234C6A] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Set Clear Milestones</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Break down the project into manageable chunks with deadlines
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#456882] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Include Payment Terms</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Specify payment schedule, methods, and conditions
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#1B3C53] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Review Together</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Discuss the contract with the freelancer before finalizing
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize milestones array
            let milestones = [];
            
            // Update summary
            function updateSummary() {
                const amount = document.getElementById('amount').value || 0;
                const startDate = new Date(document.getElementById('start_date').value);
                const endDate = new Date(document.getElementById('end_date').value);
                
                document.getElementById('summaryAmount').textContent = new Intl.NumberFormat().format(amount);
                
                if (!isNaN(startDate) && !isNaN(endDate)) {
                    const diffTime = Math.abs(endDate - startDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    document.getElementById('summaryDuration').textContent = diffDays + ' days';
                }
                
                document.getElementById('summaryMilestones').textContent = milestones.length;
            }
            
            // Listen for form changes
            ['amount', 'start_date', 'end_date'].forEach(id => {
                document.getElementById(id).addEventListener('input', updateSummary);
            });
            
            // Initial summary update
            updateSummary();
            
            // File upload handling
            const dropZone = document.getElementById('dropZone');
            const fileInput = document.getElementById('attachments');
            const fileList = document.getElementById('fileList');

            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-[#456882]', 'bg-gray-50', 'dark:bg-gray-700');
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('border-[#456882]', 'bg-gray-50', 'dark:bg-gray-700');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-[#456882]', 'bg-gray-50', 'dark:bg-gray-700');
                if (e.dataTransfer.files.length) {
                    handleFiles(e.dataTransfer.files);
                }
            });

            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length) {
                    handleFiles(e.target.files);
                }
            });

            function handleFiles(files) {
                for (let file of files) {
                    if (file.size > 5 * 1024 * 1024) {
                        alert(`File ${file.name} is too large. Max size is 5MB.`);
                        continue;
                    }
                    
                    const fileItem = document.createElement('div');
                    fileItem.className = 'flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg';
                    fileItem.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-file text-[#456882] mr-3"></i>
                            <div>
                                <div class="font-medium text-gray-800 dark:text-white">${file.name}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">${formatFileSize(file.size)}</div>
                            </div>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    fileList.appendChild(fileItem);
                }
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Form validation
            document.getElementById('contractForm').addEventListener('submit', function(e) {
                if (milestones.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one milestone.');
                    return false;
                }
                
                const amount = document.getElementById('amount').value;
                if (!amount || amount < 10) {
                    e.preventDefault();
                    alert('Please enter a valid contract amount (minimum $10).');
                    return false;
                }

                // Show loading
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Contract...';
                submitBtn.disabled = true;
            });
        });

        // Milestone management
        let milestoneCounter = 0;

        function addMilestone() {
            milestoneCounter++;
            const container = document.getElementById('milestonesContainer');
            const noMilestones = document.getElementById('noMilestones');
            
            if (noMilestones) {
                noMilestones.remove();
            }
            
            const milestoneDiv = document.createElement('div');
            milestoneDiv.className = 'p-6 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700/50';
            milestoneDiv.innerHTML = `
                <div class="flex justify-between items-start mb-4">
                    <h4 class="font-medium text-gray-800 dark:text-white">Milestone #${milestoneCounter}</h4>
                    <button type="button" onclick="removeMilestone(this)" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title *</label>
                        <input type="text" 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white milestone-title"
                               placeholder="e.g., Design Mockups, Backend Development"
                               oninput="updateMilestones()">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount ($) *</label>
                            <input type="number" 
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white milestone-amount"
                                   min="1"
                                   step="1"
                                   placeholder="100"
                                   oninput="updateMilestones()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Due Date *</label>
                            <input type="date" 
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white milestone-due"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   oninput="updateMilestones()">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description (Optional)</label>
                        <textarea class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white milestone-description"
                                  rows="2"
                                  placeholder="What needs to be delivered?"
                                  oninput="updateMilestones()"></textarea>
                    </div>
                </div>
            `;
            
            container.appendChild(milestoneDiv);
            updateMilestones();
        }

        function removeMilestone(button) {
            const milestoneDiv = button.closest('div.bg-gray-50');
            milestoneDiv.remove();
            milestoneCounter--;
            
            // Update milestone numbers
            const milestones = document.querySelectorAll('.milestone-title');
            milestones.forEach((input, index) => {
                const header = input.closest('.bg-gray-50').querySelector('h4');
                header.textContent = `Milestone #${index + 1}`;
            });
            
            if (milestoneCounter === 0) {
                const container = document.getElementById('milestonesContainer');
                const noMilestones = document.createElement('div');
                noMilestones.id = 'noMilestones';
                noMilestones.className = 'text-center py-8 text-gray-500 dark:text-gray-400';
                noMilestones.innerHTML = `
                    <i class="fas fa-tasks text-3xl mb-2"></i>
                    <p>No milestones added yet</p>
                    <p class="text-sm mt-1">Add at least one milestone to continue</p>
                `;
                container.appendChild(noMilestones);
            }
            
            updateMilestones();
        }

        function updateMilestones() {
            const milestones = [];
            document.querySelectorAll('.bg-gray-50.dark\\:bg-gray-700\\/50').forEach(div => {
                const title = div.querySelector('.milestone-title').value;
                const amount = div.querySelector('.milestone-amount').value;
                const dueDate = div.querySelector('.milestone-due').value;
                const description = div.querySelector('.milestone-description').value;
                
                if (title && amount && dueDate) {
                    milestones.push({
                        title: title,
                        amount: parseFloat(amount),
                        due_date: dueDate,
                        description: description,
                        completed: false
                    });
                }
            });
            
            document.getElementById('milestonesHidden').value = JSON.stringify(milestones);
            
            // Update summary
            const totalAmount = milestones.reduce((sum, m) => sum + m.amount, 0);
            document.getElementById('summaryAmount').textContent = new Intl.NumberFormat().format(totalAmount);
            document.getElementById('summaryMilestones').textContent = milestones.length;
        }

        // Custom terms management
        function addCustomTerm() {
            const input = document.getElementById('customTermInput');
            const term = input.value.trim();
            
            if (term) {
                const list = document.getElementById('customTermsList');
                const termDiv = document.createElement('div');
                termDiv.className = 'flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg';
                termDiv.innerHTML = `
                    <div class="flex items-center">
                        <input type="checkbox" name="terms[]" value="${term}" checked class="mr-3 text-[#1B3C53] focus:ring-[#1B3C53]">
                        <span class="text-gray-800 dark:text-white">${term}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                list.appendChild(termDiv);
                input.value = '';
            }
        }
    </script>
    @endpush

    @push('styles')
    <style>
        .hover-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #dropZone.dragover {
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { border-color: #456882; }
            50% { border-color: #1B3C53; }
        }

        .milestone-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .milestone-card:hover {
            border-left-color: #456882;
            transform: translateX(4px);
        }

        .progress-step.active {
            background: linear-gradient(135deg, #1B3C53, #456882);
            color: white;
            box-shadow: 0 4px 12px rgba(27, 60, 83, 0.3);
        }

        .progress-step.active::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 50%;
            animation: ripple 2s infinite;
        }

        @keyframes ripple {
            0% { box-shadow: 0 0 0 0 rgba(27, 60, 83, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(27, 60, 83, 0); }
            100% { box-shadow: 0 0 0 0 rgba(27, 60, 83, 0); }
        }

        .party-card {
            position: relative;
            overflow: hidden;
        }

        .party-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(27, 60, 83, 0.05), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
    @endpush
@endsection