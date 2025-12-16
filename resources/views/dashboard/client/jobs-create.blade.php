<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    Post a New Job
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Fill in the details below to find the perfect freelancer
                </p>
            </div>
            <a href="{{ route('client.jobs') }}" 
               class="px-4 py-2 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-[#2a3b4a] transition-all duration-300 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Jobs</span>
            </a>
        </div>
    </x-slot>

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
                            <div class="font-medium text-gray-800 dark:text-white">Job Details</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Title, description, requirements</div>
                        </div>
                    </div>
                    <div class="h-1 flex-1 mx-4 bg-gray-200 dark:bg-gray-700"></div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold">
                            2
                        </div>
                        <div class="ml-3">
                            <div class="font-medium text-gray-500 dark:text-gray-400">Budget & Timeline</div>
                            <div class="text-sm text-gray-400 dark:text-gray-600">Pricing and deadlines</div>
                        </div>
                    </div>
                    <div class="h-1 flex-1 mx-4 bg-gray-200 dark:bg-gray-700"></div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold">
                            3
                        </div>
                        <div class="ml-3">
                            <div class="font-medium text-gray-500 dark:text-gray-400">Review & Post</div>
                            <div class="text-sm text-gray-400 dark:text-gray-600">Final check and publish</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Creation Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <form id="jobForm" action="{{ route('client.jobs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-info-circle text-[#234C6A] mr-2"></i>
                            Job Information
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Job Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Job Title *
                                </label>
                                <input type="text" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                       placeholder="e.g., Need a Laravel Developer for E-commerce Website">
                                @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Job Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Job Description *
                                </label>
                                <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 dark:bg-gray-700 border-b border-gray-300 dark:border-gray-600 p-2 flex space-x-2">
                                        <button type="button" onclick="formatText('bold')" class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded">
                                            <i class="fas fa-bold"></i>
                                        </button>
                                        <button type="button" onclick="formatText('italic')" class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded">
                                            <i class="fas fa-italic"></i>
                                        </button>
                                        <button type="button" onclick="formatText('underline')" class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded">
                                            <i class="fas fa-underline"></i>
                                        </button>
                                        <button type="button" onclick="formatText('list')" class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded">
                                            <i class="fas fa-list-ul"></i>
                                        </button>
                                    </div>
                                    <textarea id="description" 
                                              name="description" 
                                              rows="10"
                                              required
                                              class="w-full px-4 py-3 border-0 focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                              placeholder="Describe your project in detail. Include requirements, goals, and any specific instructions...">{{ old('description') }}</textarea>
                                </div>
                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-lightbulb text-[#456882] mr-1"></i>
                                    Tip: Be specific about requirements to attract the right freelancers
                                </div>
                                @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Skills Required -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Skills Required *
                                </label>
                                <div id="skillsContainer" class="space-y-2">
                                    <div class="flex space-x-2">
                                        <input type="text" 
                                               id="skillInput"
                                               class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                               placeholder="e.g., Laravel, Vue.js, MySQL">
                                        <button type="button" 
                                                onclick="addSkill()"
                                                class="px-4 py-2 bg-[#456882] text-white rounded-lg hover:bg-[#234C6A] transition-colors">
                                            Add
                                        </button>
                                    </div>
                                    <div id="skillsList" class="flex flex-wrap gap-2 mt-2">
                                        <!-- Skills will be added here -->
                                    </div>

                                </div>
                                @error('skills')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Experience Level -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Experience Level Required *
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                        <input type="radio" name="experience_level" value="entry" 
                                               {{ old('experience_level') === 'entry' ? 'checked' : '' }}
                                               class="mr-3 text-[#1B3C53] focus:ring-[#1B3C53]">
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">Entry Level</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Simple tasks, budget-friendly</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                        <input type="radio" name="experience_level" value="intermediate" 
                                               {{ old('experience_level') === 'intermediate' ? 'checked' : (old('experience_level') ? '' : 'checked') }}
                                               class="mr-3 text-[#1B3C53] focus:ring-[#1B3C53]">
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">Intermediate</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Moderate complexity</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-[#456882] transition-colors">
                                        <input type="radio" name="experience_level" value="expert" 
                                               {{ old('experience_level') === 'expert' ? 'checked' : '' }}
                                               class="mr-3 text-[#1B3C53] focus:ring-[#1B3C53]">
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">Expert</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Complex projects, premium</div>
                                        </div>
                                    </label>
                                </div>
                                @error('experience_level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Budget & Timeline -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-dollar-sign text-[#456882] mr-2"></i>
                            Budget & Timeline
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Job Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Job Type *
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <label id="fixedPriceLabel" class="job-type-option">
                                        <input type="radio" name="job_type" value="fixed" 
                                               {{ old('job_type') === 'fixed' ? 'checked' : (old('job_type') ? '' : 'checked') }}
                                               class="hidden">
                                        <div class="p-4 border border-gray-300 dark:border-gray-600 rounded-lg text-center cursor-pointer transition-all duration-300">
                                            <div class="text-2xl mb-2">💼</div>
                                            <div class="font-medium text-gray-800 dark:text-white">Fixed Price</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">One-time payment</div>
                                        </div>
                                    </label>
                                    <label id="hourlyLabel" class="job-type-option">
                                        <input type="radio" name="job_type" value="hourly" 
                                               {{ old('job_type') === 'hourly' ? 'checked' : '' }}
                                               class="hidden">
                                        <div class="p-4 border border-gray-300 dark:border-gray-600 rounded-lg text-center cursor-pointer transition-all duration-300">
                                            <div class="text-2xl mb-2">⏱️</div>
                                            <div class="font-medium text-gray-800 dark:text-white">Hourly Rate</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pay by the hour</div>
                                        </div>
                                    </label>
                                </div>
                                @error('job_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fixed Price Fields -->
                            <div id="fixedPriceFields" class="space-y-4">
                                <div>
                                    <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Budget ($) *
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400">$</span>
                                        </div>
                                        <input type="number" 
                                               id="budget" 
                                               name="budget" 
                                               value="{{ old('budget') }}"
                                               min="10"
                                               step="10"
                                               class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                               placeholder="e.g., 500">
                                    </div>
                                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex space-x-4">
                                            <button type="button" onclick="setBudget(100)" class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded hover:bg-gray-200 dark:hover:bg-gray-600">$100</button>
                                            <button type="button" onclick="setBudget(500)" class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded hover:bg-gray-200 dark:hover:bg-gray-600">$500</button>
                                            <button type="button" onclick="setBudget(1000)" class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded hover:bg-gray-200 dark:hover:bg-gray-600">$1,000</button>
                                            <button type="button" onclick="setBudget(5000)" class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded hover:bg-gray-200 dark:hover:bg-gray-600">$5,000</button>
                                        </div>
                                    </div>
                                    @error('budget')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Hourly Rate Fields -->
                            <div id="hourlyFields" class="space-y-4 hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="hourly_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Hourly Rate ($/hr) *
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 dark:text-gray-400">$</span>
                                            </div>
                                            <input type="number" 
                                                   id="hourly_rate" 
                                                   name="hourly_rate" 
                                                   value="{{ old('hourly_rate') }}"
                                                   min="5"
                                                   step="5"
                                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                   placeholder="e.g., 25">
                                        </div>
                                        @error('hourly_rate')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="hours_per_week" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Hours/Week *
                                        </label>
                                        <input type="number" 
                                               id="hours_per_week" 
                                               name="hours_per_week" 
                                               value="{{ old('hours_per_week', 40) }}"
                                               min="1"
                                               max="168"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                        @error('hours_per_week')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Project Length -->
                            <div>
                                <label for="project_length" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Project Length *
                                </label>
                                <select id="project_length" 
                                        name="project_length"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                    <option value="less_than_1_month" {{ old('project_length') === 'less_than_1_month' ? 'selected' : '' }}>Less than 1 month</option>
                                    <option value="1_to_3_months" {{ old('project_length') === '1_to_3_months' ? 'selected' : (old('project_length') ? '' : 'selected') }}>1 to 3 months</option>
                                    <option value="3_to_6_months" {{ old('project_length') === '3_to_6_months' ? 'selected' : '' }}>3 to 6 months</option>
                                    <option value="more_than_6_months" {{ old('project_length') === 'more_than_6_months' ? 'selected' : '' }}>More than 6 months</option>
                                </select>
                                @error('project_length')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deadline -->
                            <div>
                                <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Deadline (Optional)
                                </label>
                                <input type="date" 
                                       id="deadline" 
                                       name="deadline" 
                                       value="{{ old('deadline') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-clock text-[#456882] mr-1"></i>
                                    Setting a deadline can help attract freelancers
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Additional Options -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-cog text-[#1B3C53] mr-2"></i>
                            Additional Options
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Urgent Job -->
                            <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                                <div>
                                    <div class="font-medium text-gray-800 dark:text-white">Mark as Urgent</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Get more visibility with an urgent badge
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="is_urgent" 
                                           value="1"
                                           {{ old('is_urgent') ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1B3C53]"></div>
                                </label>
                            </div>

                            <!-- Remote Work -->
                            <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                                <div>
                                    <div class="font-medium text-gray-800 dark:text-white">Remote Work</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Indicate if this is a remote position
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="is_remote" 
                                           value="1"
                                           {{ old('is_remote', true) ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#456882]"></div>
                                </label>
                            </div>

                            <!-- Attachments -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Attachments (Optional)
                                </label>
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

                            <!-- Submit Button -->
                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-lock text-[#234C6A] mr-1"></i>
                                        Your payment details are secure
                                    </div>
                                    <button type="submit" 
                                            class="px-8 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-medium text-lg flex items-center space-x-2 shadow-lg hover:shadow-xl">
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Post Job Now</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tips Section -->
            <div class="mt-8 bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-[#456882] mr-2"></i>
                    Tips for a Great Job Post
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#1B3C53] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Be Specific</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Clearly define project requirements and deliverables
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#234C6A] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Set Realistic Budget</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Research market rates for similar projects
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#456882] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Include Examples</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Add attachments or links for reference
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-8 h-8 rounded-full bg-[#1B3C53] flex items-center justify-center text-white mr-3 flex-shrink-0">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800 dark:text-white">Quick Response</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Respond promptly to freelancer questions
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
            // Initialize skills from old input
            const oldSkills = JSON.parse(document.getElementById('skillsHidden').value || '[]');
            oldSkills.forEach(skill => addSkillToUI(skill));

            // Job type toggle
            const fixedPriceFields = document.getElementById('fixedPriceFields');
            const hourlyFields = document.getElementById('hourlyFields');
            const fixedPriceLabel = document.getElementById('fixedPriceLabel');
            const hourlyLabel = document.getElementById('hourlyLabel');

            document.querySelectorAll('input[name="job_type"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'fixed') {
                        fixedPriceFields.classList.remove('hidden');
                        hourlyFields.classList.add('hidden');
                        fixedPriceLabel.classList.add('selected');
                        hourlyLabel.classList.remove('selected');
                    } else {
                        fixedPriceFields.classList.add('hidden');
                        hourlyFields.classList.remove('hidden');
                        fixedPriceLabel.classList.remove('selected');
                        hourlyLabel.classList.add('selected');
                    }
                });
            });

            // Trigger initial state
            if (document.querySelector('input[name="job_type"]:checked').value === 'hourly') {
                fixedPriceFields.classList.add('hidden');
                hourlyFields.classList.remove('hidden');
                fixedPriceLabel.classList.remove('selected');
                hourlyLabel.classList.add('selected');
            }

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
            document.getElementById('jobForm').addEventListener('submit', function () {
             const submitBtn = this.querySelector('button[type="submit"]');
             submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Posting Job...';
             submitBtn.disabled = true;
             });

        });

        // Text formatting functions
        function formatText(command) {
            const textarea = document.getElementById('description');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            let formattedText = selectedText;

            switch(command) {
                case 'bold':
                    formattedText = `**${selectedText}**`;
                    break;
                case 'italic':
                    formattedText = `*${selectedText}*`;
                    break;
                case 'underline':
                    formattedText = `<u>${selectedText}</u>`;
                    break;
                case 'list':
                    formattedText = selectedText.split('\n').map(line => `- ${line}`).join('\n');
                    break;
            }

            textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
            textarea.focus();
            textarea.setSelectionRange(start + formattedText.length, start + formattedText.length);
        }

        

        function skillExists(skill) {
            const skills = JSON.parse(document.getElementById('skillsHidden').value);
            return skills.includes(skill.toLowerCase());
        }

       

        



        // Budget preset
        function setBudget(amount) {
            document.getElementById('budget').value = amount;
        }

        // Style job type options
        document.querySelectorAll('.job-type-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.job-type-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });
        function addSkill() {
         const input = document.getElementById('skillInput');
         const skill = input.value.trim();

         if (!skill || skillExists(skill)) return;

        const skillsList = document.getElementById('skillsList');

        const tag = document.createElement('div');
        tag.className =
        'inline-flex items-center px-3 py-1 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] text-white';
        tag.innerHTML = `
        ${skill}
        <button type="button" onclick="removeSkill(this)" class="ml-2">
            <i class="fas fa-times text-xs"></i>
        </button>
        `;

        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'skills[]';
        hidden.value = skill;

        tag.appendChild(hidden);
        skillsList.appendChild(tag);

        input.value = '';
        }

       function removeSkill(btn) {
       btn.parentElement.remove();
      }

     function skillExists(skill) {
      return [...document.querySelectorAll('input[name="skills[]"]')]
        .some(i => i.value.toLowerCase() === skill.toLowerCase());
      }

    </script>
    @endpush

    @push('styles')
    <style>
        .job-type-option.selected > div {
            border-color: #456882;
            background: linear-gradient(135deg, rgba(27, 60, 83, 0.1), rgba(69, 104, 130, 0.1));
            box-shadow: 0 4px 12px rgba(27, 60, 83, 0.1);
        }

        .dark .job-type-option.selected > div {
            background: linear-gradient(135deg, rgba(27, 60, 83, 0.3), rgba(69, 104, 130, 0.3));
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        #dropZone.dragover {
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { border-color: #456882; }
            50% { border-color: #1B3C53; }
        }

        .skill-tag {
            transition: all 0.2s ease;
        }

        .skill-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(27, 60, 83, 0.2);
        }

        input[type="checkbox"]:checked + div {
            background: linear-gradient(135deg, #1B3C53, #456882);
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
    </style>
    @endpush
</x-app-layout>