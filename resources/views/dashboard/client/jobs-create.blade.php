<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    {{ __('Post a New Job') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('Fill in the details below to find the perfect freelancer') }}
                </p>
            </div>
            <a href="{{ route('client.jobs') }}" 
               class="px-4 py-2 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>{{ __('Back to Jobs') }}</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-300">
                                {{ __('There were ' . $errors->count() . ' errors with your submission') }}
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-400">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm text-green-800 dark:text-green-300">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Progress Steps -->
            <div class="mb-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#234C6A] flex items-center justify-center text-white font-bold shadow-lg">
                            1
                        </div>
                        <div class="ml-4">
                            <div class="font-semibold text-gray-800 dark:text-white">{{ __('Job Details') }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Title, description, requirements') }}</div>
                        </div>
                    </div>
                    <div class="h-1 flex-1 mx-6 bg-gradient-to-r from-[#1B3C53] to-[#456882]"></div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-[#234C6A] to-[#456882] flex items-center justify-center text-white font-bold shadow-lg">
                            2
                        </div>
                        <div class="ml-4">
                            <div class="font-semibold text-gray-800 dark:text-white">{{ __('Budget & Timeline') }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Pricing and deadlines') }}</div>
                        </div>
                    </div>
                    <div class="h-1 flex-1 mx-6 bg-gradient-to-r from-[#456882] to-gray-200 dark:to-gray-700"></div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold">
                            3
                        </div>
                        <div class="ml-4">
                            <div class="font-medium text-gray-500 dark:text-gray-400">{{ __('Review & Post') }}</div>
                            <div class="text-sm text-gray-400 dark:text-gray-600">{{ __('Final check and publish') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <form id="jobForm" action="{{ route('client.jobs.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @csrf
                    
                    <!-- Section 1: Job Information -->
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#1B3C53] to-[#234C6A] flex items-center justify-center mr-4">
                                <i class="fas fa-info text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ __('Job Information') }}</h3>
                                <p class="text-gray-600 dark:text-gray-400">{{ __('Basic details about your project') }}</p>
                            </div>
                        </div>

                        <!-- Job Title -->
                        <div class="mb-8">
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('Job Title') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   required
                                   class="w-full px-5 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-3 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white text-lg placeholder-gray-400 transition-all duration-300"
                                   placeholder="{{ __('e.g., Need a Laravel Developer for E-commerce Website') }}">
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-lightbulb text-[#456882] mr-1"></i>
                                {{ __('Be specific to attract the right freelancers') }}
                            </p>
                        </div>

                        <!-- Job Description -->
                        <div class="mb-8">
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('Job Description') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="border-2 border-gray-300 dark:border-gray-600 rounded-xl overflow-hidden focus-within:border-[#1B3C53] transition-all duration-300">
                                <div class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 p-3 flex space-x-3">
                                    <button type="button" onclick="formatText('bold')" 
                                            class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors" 
                                            title="Bold">
                                        <i class="fas fa-bold text-gray-600 dark:text-gray-300"></i>
                                    </button>
                                    <button type="button" onclick="formatText('italic')" 
                                            class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors"
                                            title="Italic">
                                        <i class="fas fa-italic text-gray-600 dark:text-gray-300"></i>
                                    </button>
                                    <button type="button" onclick="formatText('underline')" 
                                            class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors"
                                            title="Underline">
                                        <i class="fas fa-underline text-gray-600 dark:text-gray-300"></i>
                                    </button>
                                    <button type="button" onclick="formatText('list')" 
                                            class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors"
                                            title="Bullet List">
                                        <i class="fas fa-list-ul text-gray-600 dark:text-gray-300"></i>
                                    </button>
                                </div>
                                <textarea id="description" 
                                          name="description" 
                                          rows="12"
                                          required
                                          class="w-full px-5 py-4 border-0 focus:ring-0 dark:bg-gray-700 dark:text-white text-base resize-none"
                                          placeholder="{{ __('Describe your project in detail. What needs to be done? What are the requirements? What are the expected deliverables?') }}">{{ old('description') }}</textarea>
                            </div>
                            <div class="flex justify-between mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-keyboard text-[#456882] mr-1"></i>
                                    {{ __('Minimum 100 characters') }}
                                </p>
                                <p id="charCount" class="text-sm text-gray-500 dark:text-gray-400">0 characters</p>
                            </div>
                        </div>

                        <!-- Skills Required -->
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('Skills Required') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-4">
                                <div class="flex space-x-3">
                                    <input type="text" 
                                           id="skillInput"
                                           class="flex-1 px-5 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-3 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white"
                                           placeholder="{{ __('e.g., Laravel, Vue.js, MySQL (Press Enter to add)') }}">
                                    <button type="button" 
                                            onclick="addSkill()"
                                            class="px-6 py-3 bg-gradient-to-r from-[#456882] to-[#234C6A] text-white rounded-xl hover:from-[#234C6A] hover:to-[#1B3C53] transition-all duration-300 font-semibold shadow-lg hover:shadow-xl">
                                        <i class="fas fa-plus mr-2"></i>{{ __('Add') }}
                                    </button>
                                </div>
                                <div id="skillsList" class="flex flex-wrap gap-3">
                                    <!-- Skills will be added here dynamically -->
                                </div>
                                <input type="hidden" name="skills" id="skillsHidden" value='{{ old('skills', "[]") }}'>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-tags text-[#456882] mr-1"></i>
                                    {{ __('Add at least 1 skill. These help freelancers find your job.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Experience Level -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('Experience Level Required') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="relative">
                                    <input type="radio" 
                                           name="experience_level" 
                                           value="entry" 
                                           {{ old('experience_level') === 'entry' ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="p-5 border-2 border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:border-[#456882] transition-all duration-300 peer-checked:border-[#1B3C53] peer-checked:bg-gradient-to-r peer-checked:from-[#1B3C53]/5 peer-checked:to-[#234C6A]/5 dark:peer-checked:from-[#1B3C53]/20 dark:peer-checked:to-[#234C6A]/20">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-4">
                                                <i class="fas fa-seedling text-green-600 dark:text-green-400"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800 dark:text-white">{{ __('Entry Level') }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Simple tasks, budget-friendly') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" 
                                           name="experience_level" 
                                           value="intermediate" 
                                           {{ old('experience_level') === 'intermediate' ? 'checked' : 'checked' }}
                                           class="sr-only peer">
                                    <div class="p-5 border-2 border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:border-[#456882] transition-all duration-300 peer-checked:border-[#1B3C53] peer-checked:bg-gradient-to-r peer-checked:from-[#1B3C53]/5 peer-checked:to-[#234C6A]/5 dark:peer-checked:from-[#1B3C53]/20 dark:peer-checked:to-[#234C6A]/20">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center mr-4">
                                                <i class="fas fa-chart-line text-yellow-600 dark:text-yellow-400"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800 dark:text-white">{{ __('Intermediate') }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Moderate complexity') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" 
                                           name="experience_level" 
                                           value="expert" 
                                           {{ old('experience_level') === 'expert' ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="p-5 border-2 border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:border-[#456882] transition-all duration-300 peer-checked:border-[#1B3C53] peer-checked:bg-gradient-to-r peer-checked:from-[#1B3C53]/5 peer-checked:to-[#234C6A]/5 dark:peer-checked:from-[#1B3C53]/20 dark:peer-checked:to-[#234C6A]/20">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center mr-4">
                                                <i class="fas fa-crown text-red-600 dark:text-red-400"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800 dark:text-white">{{ __('Expert') }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Complex projects, premium') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Budget & Timeline -->
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#234C6A] to-[#456882] flex items-center justify-center mr-4">
                                <i class="fas fa-dollar-sign text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ __('Budget & Timeline') }}</h3>
                                <p class="text-gray-600 dark:text-gray-400">{{ __('Set your budget and project duration') }}</p>
                            </div>
                        </div>

                        <!-- Job Type -->
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('Job Type') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <label class="relative job-type-option" id="fixedPriceLabel">
                                    <input type="radio" 
                                           name="job_type" 
                                           value="fixed" 
                                           {{ old('job_type') === 'fixed' ? 'checked' : 'checked' }}
                                           class="sr-only peer">
                                    <div class="p-6 border-2 border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer text-center hover:border-[#456882] transition-all duration-300 peer-checked:border-[#1B3C53] peer-checked:bg-gradient-to-r peer-checked:from-[#1B3C53]/5 peer-checked:to-[#234C6A]/5 dark:peer-checked:from-[#1B3C53]/20 dark:peer-checked:to-[#234C6A]/20">
                                        <div class="text-4xl mb-4">💼</div>
                                        <div class="font-bold text-gray-800 dark:text-white text-lg">{{ __('Fixed Price') }}</div>
                                        <div class="text-gray-500 dark:text-gray-400 mt-2">{{ __('One-time payment for the entire project') }}</div>
                                    </div>
                                </label>
                                <label class="relative job-type-option" id="hourlyLabel">
                                    <input type="radio" 
                                           name="job_type" 
                                           value="hourly" 
                                           {{ old('job_type') === 'hourly' ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="p-6 border-2 border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer text-center hover:border-[#456882] transition-all duration-300 peer-checked:border-[#1B3C53] peer-checked:bg-gradient-to-r peer-checked:from-[#1B3C53]/5 peer-checked:to-[#234C6A]/5 dark:peer-checked:from-[#1B3C53]/20 dark:peer-checked:to-[#234C6A]/20">
                                        <div class="text-4xl mb-4">⏱️</div>
                                        <div class="font-bold text-gray-800 dark:text-white text-lg">{{ __('Hourly Rate') }}</div>
                                        <div class="text-gray-500 dark:text-gray-400 mt-2">{{ __('Pay by the hour based on work done') }}</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Fixed Price Fields -->
                        <div id="fixedPriceFields" class="space-y-6">
                            <div>
                                <label for="budget" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    {{ __('Budget') }} ($) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                        <span class="text-2xl font-bold text-gray-500 dark:text-gray-400">$</span>
                                    </div>
                                    <input type="number" 
                                           id="budget" 
                                           name="budget" 
                                           value="{{ old('budget', '500') }}"
                                           min="10"
                                           step="10"
                                           required
                                           class="w-full pl-16 pr-5 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-3 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white text-2xl font-bold placeholder-gray-400">
                                </div>
                                <div class="mt-4">
                                    <div class="flex flex-wrap gap-3">
                                        <button type="button" onclick="setBudget(100)" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">$100</button>
                                        <button type="button" onclick="setBudget(500)" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">$500</button>
                                        <button type="button" onclick="setBudget(1000)" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">$1,000</button>
                                        <button type="button" onclick="setBudget(5000)" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">$5,000</button>
                                        <button type="button" onclick="setBudget(10000)" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">$10,000</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hourly Rate Fields (Hidden by default) -->
                        <div id="hourlyFields" class="space-y-6 hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="hourly_rate" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                        {{ __('Hourly Rate') }} ($/hr) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                            <span class="text-2xl font-bold text-gray-500 dark:text-gray-400">$</span>
                                        </div>
                                        <input type="number" 
                                               id="hourly_rate" 
                                               name="hourly_rate" 
                                               value="{{ old('hourly_rate', '25') }}"
                                               min="5"
                                               step="5"
                                               class="w-full pl-16 pr-5 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-3 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white text-2xl font-bold placeholder-gray-400">
                                    </div>
                                </div>
                                <div>
                                    <label for="hours_per_week" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                        {{ __('Hours Per Week') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           id="hours_per_week" 
                                           name="hours_per_week" 
                                           value="{{ old('hours_per_week', '40') }}"
                                           min="1"
                                           max="168"
                                           class="w-full px-5 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-3 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white text-2xl font-bold placeholder-gray-400">
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-clock text-[#456882] mr-1"></i>
                                        {{ __('Estimated weekly hours') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project Length -->
                        <div class="mb-8">
                            <label for="project_length" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('Project Length') }} <span class="text-red-500">*</span>
                            </label>
                            <select id="project_length" 
                                    name="project_length"
                                    required
                                    class="w-full px-5 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-3 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white text-lg">
                                <option value="less_than_1_month" {{ old('project_length') === 'less_than_1_month' ? 'selected' : '' }}>{{ __('Less than 1 month') }}</option>
                                <option value="1_to_3_months" {{ old('project_length') === '1_to_3_months' ? 'selected' : 'selected' }}>{{ __('1 to 3 months') }}</option>
                                <option value="3_to_6_months" {{ old('project_length') === '3_to_6_months' ? 'selected' : '' }}>{{ __('3 to 6 months') }}</option>
                                <option value="more_than_6_months" {{ old('project_length') === 'more_than_6_months' ? 'selected' : '' }}>{{ __('More than 6 months') }}</option>
                            </select>
                        </div>

                        <!-- Deadline -->
                        <div>
                            <label for="deadline" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('Deadline') }} ({{ __('Optional') }})
                            </label>
                            <input type="date" 
                                   id="deadline" 
                                   name="deadline" 
                                   value="{{ old('deadline') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full px-5 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-3 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white text-lg">
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-calendar-alt text-[#456882] mr-1"></i>
                                {{ __('Setting a deadline can help attract freelancers') }}
                            </p>
                        </div>
                    </div>

                    <!-- Section 3: Additional Options -->
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#456882] to-[#1B3C53] flex items-center justify-center mr-4">
                                <i class="fas fa-cog text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ __('Additional Options') }}</h3>
                                <p class="text-gray-600 dark:text-gray-400">{{ __('Extra settings for your job post') }}</p>
                            </div>
                        </div>

                        <!-- Urgent Job -->
                        <div class="flex items-center justify-between p-5 border-2 border-gray-300 dark:border-gray-600 rounded-xl mb-6 hover:border-[#456882] transition-colors">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center mr-4">
                                    <i class="fas fa-bolt text-red-600 dark:text-red-400"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 dark:text-white">{{ __('Mark as Urgent') }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        {{ __('Get more visibility with an urgent badge') }}
                                    </div>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_urgent" 
                                       value="1"
                                       {{ old('is_urgent') ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-[#1B3C53] peer-checked:to-[#234C6A]"></div>
                            </label>
                        </div>

                        <!-- Remote Work -->
                        <div class="flex items-center justify-between p-5 border-2 border-gray-300 dark:border-gray-600 rounded-xl mb-6 hover:border-[#456882] transition-colors">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-4">
                                    <i class="fas fa-globe text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 dark:text-white">{{ __('Remote Work') }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        {{ __('Indicate if this is a remote position') }}
                                    </div>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_remote" 
                                       value="1"
                                       {{ old('is_remote', true) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-[#456882] peer-checked:to-[#234C6A]"></div>
                            </label>
                        </div>

                        <!-- Attachments -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('Attachments') }} ({{ __('Optional') }})
                            </label>
                            <div class="border-3 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-10 text-center hover:border-[#456882] transition-colors cursor-pointer" 
                                 onclick="document.getElementById('attachments').click()"
                                 id="dropZone">
                                <div class="text-5xl mb-6 text-gray-400">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="font-bold text-gray-700 dark:text-gray-300 text-lg mb-2">
                                    {{ __('Drop files here or click to upload') }}
                                </div>
                                <div class="text-gray-500 dark:text-gray-400">
                                    {{ __('Max file size: 5MB. Supported: PDF, DOC, TXT, JPG, PNG') }}
                                </div>
                                <input type="file" 
                                       id="attachments" 
                                       name="attachments[]" 
                                       multiple 
                                       class="hidden"
                                       accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                            </div>
                            <div id="fileList" class="mt-6 space-y-3">
                                <!-- Files will be listed here -->
                            </div>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="p-8 bg-gradient-to-r from-[#1B3C53]/5 to-[#456882]/5 dark:from-[#1B3C53]/20 dark:to-[#456882]/20">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <div class="mb-6 md:mb-0">
                                <div class="flex items-center text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-shield-alt text-[#234C6A] text-xl mr-3"></i>
                                    <div>
                                        <div class="font-bold">{{ __('Secure & Protected') }}</div>
                                        <div class="text-sm">{{ __('Your payment and data are safe with us') }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-headset text-[#456882] mr-2"></i>
                                    <span class="text-sm">{{ __('24/7 support available') }}</span>
                                </div>
                            </div>
                            <div class="flex space-x-4">
                                <a href="{{ route('client.jobs') }}" 
                                   class="px-8 py-4 border-2 border-[#456882] text-[#1B3C53] dark:text-white rounded-xl hover:bg-[#E3E3E3] dark:hover:bg-gray-700 transition-all duration-300 font-bold text-lg">
                                    {{ __('Cancel') }}
                                </a>
                                <button type="submit" 
                                        id="submitBtn"
                                        class="px-10 py-4 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-xl hover:from-[#234C6A] hover:to-[#456882] hover:scale-105 transition-all duration-300 font-bold text-lg shadow-xl hover:shadow-2xl flex items-center space-x-3">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>{{ __('Post Job Now') }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-center text-gray-500 dark:text-gray-400 text-sm mt-8">
                            <i class="fas fa-info-circle text-[#456882] mr-1"></i>
                            {{ __('By posting this job, you agree to our Terms of Service and Privacy Policy') }}
                        </p>
                    </div>
                </form>
            </div>

            <!-- Tips Section -->
            <div class="mt-10 bg-gradient-to-r from-[#E3E3E3] to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-8">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-lightbulb text-[#456882] text-2xl mr-3"></i>
                    {{ __('Tips for a Great Job Post') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-lg">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-[#1B3C53] to-[#234C6A] flex items-center justify-center mb-4">
                            <i class="fas fa-bullseye text-white"></i>
                        </div>
                        <div class="font-bold text-gray-800 dark:text-white mb-2">{{ __('Be Specific') }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Clearly define project requirements and deliverables') }}
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-lg">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-[#234C6A] to-[#456882] flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-white"></i>
                        </div>
                        <div class="font-bold text-gray-800 dark:text-white mb-2">{{ __('Set Realistic Budget') }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Research market rates for similar projects') }}
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-lg">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-[#456882] to-[#1B3C53] flex items-center justify-center mb-4">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                        <div class="font-bold text-gray-800 dark:text-white mb-2">{{ __('Include Examples') }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Add attachments or links for reference') }}
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-lg">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center mb-4">
                            <i class="fas fa-comments text-white"></i>
                        </div>
                        <div class="font-bold text-gray-800 dark:text-white mb-2">{{ __('Quick Response') }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Respond promptly to freelancer questions') }}
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

            // Character counter for description
            const description = document.getElementById('description');
            const charCount = document.getElementById('charCount');
            
            description.addEventListener('input', function() {
                charCount.textContent = this.value.length + ' characters';
            });
            
            // Trigger initial count
            charCount.textContent = description.value.length + ' characters';

            // Job type toggle
            const jobTypeRadios = document.querySelectorAll('input[name="job_type"]');
            const fixedPriceFields = document.getElementById('fixedPriceFields');
            const hourlyFields = document.getElementById('hourlyFields');
            const fixedPriceLabel = document.getElementById('fixedPriceLabel');
            const hourlyLabel = document.getElementById('hourlyLabel');

            function toggleJobTypeFields() {
                const selectedType = document.querySelector('input[name="job_type"]:checked').value;
                
                if (selectedType === 'fixed') {
                    fixedPriceFields.classList.remove('hidden');
                    hourlyFields.classList.add('hidden');
                    document.getElementById('budget').required = true;
                    document.getElementById('hourly_rate').required = false;
                    document.getElementById('hours_per_week').required = false;
                    
                    fixedPriceLabel.querySelector('div').classList.add('border-[#1B3C53]', 'bg-gradient-to-r', 'from-[#1B3C53]/5', 'to-[#234C6A]/5', 'dark:from-[#1B3C53]/20', 'dark:to-[#234C6A]/20');
                    hourlyLabel.querySelector('div').classList.remove('border-[#1B3C53]', 'bg-gradient-to-r', 'from-[#1B3C53]/5', 'to-[#234C6A]/5', 'dark:from-[#1B3C53]/20', 'dark:to-[#234C6A]/20');
                } else {
                    fixedPriceFields.classList.add('hidden');
                    hourlyFields.classList.remove('hidden');
                    document.getElementById('budget').required = false;
                    document.getElementById('hourly_rate').required = true;
                    document.getElementById('hours_per_week').required = true;
                    
                    fixedPriceLabel.querySelector('div').classList.remove('border-[#1B3C53]', 'bg-gradient-to-r', 'from-[#1B3C53]/5', 'to-[#234C6A]/5', 'dark:from-[#1B3C53]/20', 'dark:to-[#234C6A]/20');
                    hourlyLabel.querySelector('div').classList.add('border-[#1B3C53]', 'bg-gradient-to-r', 'from-[#1B3C53]/5', 'to-[#234C6A]/5', 'dark:from-[#1B3C53]/20', 'dark:to-[#234C6A]/20');
                }
            }

            jobTypeRadios.forEach(radio => {
                radio.addEventListener('change', toggleJobTypeFields);
            });

            // Trigger initial state
            toggleJobTypeFields();

            // File upload handling
            const dropZone = document.getElementById('dropZone');
            const fileInput = document.getElementById('attachments');
            const fileList = document.getElementById('fileList');

            // Drag and drop functionality
            ['dragover', 'dragenter'].forEach(event => {
                dropZone.addEventListener(event, (e) => {
                    e.preventDefault();
                    dropZone.classList.add('border-[#456882]', 'bg-gray-50', 'dark:bg-gray-700');
                });
            });

            ['dragleave', 'dragend'].forEach(event => {
                dropZone.addEventListener(event, () => {
                    dropZone.classList.remove('border-[#456882]', 'bg-gray-50', 'dark:bg-gray-700');
                });
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-[#456882]', 'bg-gray-50', 'dark:bg-gray-700');
                if (e.dataTransfer.files.length) {
                    handleFiles(e.dataTransfer.files);
                    fileInput.files = e.dataTransfer.files;
                }
            });

            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length) {
                    handleFiles(e.target.files);
                }
            });

            function handleFiles(files) {
                Array.from(files).forEach(file => {
                    if (file.size > 5 * 1024 * 1024) {
                        alert(`File "${file.name}" is too large. Maximum size is 5MB.`);
                        return;
                    }
                    
                    const fileItem = document.createElement('div');
                    fileItem.className = 'flex items-center justify-between p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm';
                    fileItem.innerHTML = `
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#1B3C53]/10 to-[#456882]/10 dark:from-[#1B3C53]/20 dark:to-[#456882]/20 flex items-center justify-center mr-4">
                                <i class="fas fa-file text-[#456882]"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800 dark:text-white">${file.name}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">${formatFileSize(file.size)}</div>
                            </div>
                        </div>
                        <button type="button" 
                                onclick="this.parentElement.remove()" 
                                class="text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    fileList.appendChild(fileItem);
                });
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Form submission
            document.getElementById('jobForm').addEventListener('submit', function(e) {
                const skills = JSON.parse(document.getElementById('skillsHidden').value);
                if (skills.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one skill');
                    return;
                }

                const submitBtn = document.getElementById('submitBtn');
                submitBtn.innerHTML = `
                    <i class="fas fa-spinner fa-spin"></i>
                    <span class="ml-2">Posting Job...</span>
                `;
                submitBtn.disabled = true;
                submitBtn.classList.remove('hover:scale-105', 'hover:shadow-2xl');
            });

            // Skill input - Enter key support
            document.getElementById('skillInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addSkill();
                }
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
                    formattedText = selectedText.split('\n').map(line => `• ${line}`).join('\n');
                    break;
            }

            textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
            textarea.focus();
            textarea.setSelectionRange(start + formattedText.length, start + formattedText.length);
            
            // Update character count
            document.getElementById('charCount').textContent = textarea.value.length + ' characters';
        }

        // Skills management
        function addSkill() {
            const input = document.getElementById('skillInput');
            const skill = input.value.trim();
            
            if (!skill) {
                alert('Please enter a skill');
                return;
            }
            
            if (skillExists(skill)) {
                alert('This skill has already been added');
                input.value = '';
                return;
            }
            
            const skillsList = document.getElementById('skillsList');
            const skillsHidden = document.getElementById('skillsHidden');
            
            // Get current skills array
            let skills = JSON.parse(skillsHidden.value || '[]');
            skills.push(skill);
            
            // Update hidden input
            skillsHidden.value = JSON.stringify(skills);
            
            // Add visual tag
            const skillTag = document.createElement('div');
            skillTag.className = 'inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] text-white font-medium shadow-md hover:shadow-lg transition-shadow';
            skillTag.innerHTML = `
                <span>${skill}</span>
                <button type="button" 
                        onclick="removeSkill('${skill}')" 
                        class="ml-2 hover:text-red-200">
                    <i class="fas fa-times text-sm"></i>
                </button>
            `;
            skillsList.appendChild(skillTag);
            
            input.value = '';
            input.focus();
        }

        function removeSkill(skill) {
            const skillsHidden = document.getElementById('skillsHidden');
            let skills = JSON.parse(skillsHidden.value || '[]');
            
            // Remove skill from array
            skills = skills.filter(s => s !== skill);
            skillsHidden.value = JSON.stringify(skills);
            
            // Remove from UI
            const skillTags = document.querySelectorAll('#skillsList div');
            skillTags.forEach(tag => {
                if (tag.textContent.includes(skill)) {
                    tag.remove();
                }
            });
        }

        function skillExists(skill) {
            const skillsHidden = document.getElementById('skillsHidden');
            const skills = JSON.parse(skillsHidden.value || '[]');
            return skills.some(s => s.toLowerCase() === skill.toLowerCase());
        }

        // Initialize skills from old input
        function addSkillToUI(skill) {
            const skillsList = document.getElementById('skillsList');
            const skillTag = document.createElement('div');
            skillTag.className = 'inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] text-white font-medium shadow-md';
            skillTag.innerHTML = `
                <span>${skill}</span>
                <button type="button" 
                        onclick="removeSkill('${skill}')" 
                        class="ml-2 hover:text-red-200">
                    <i class="fas fa-times text-sm"></i>
                </button>
            `;
            skillsList.appendChild(skillTag);
        }

        // Budget preset
        function setBudget(amount) {
            document.getElementById('budget').value = amount;
        }
    </script>
    @endpush

    @push('styles')
    <style>
        .job-type-option.selected > div {
            border-color: #1B3C53;
            background: linear-gradient(135deg, rgba(27, 60, 83, 0.05), rgba(69, 104, 130, 0.05));
            box-shadow: 0 10px 25px rgba(27, 60, 83, 0.1);
        }
        
        .dark .job-type-option.selected > div {
            background: linear-gradient(135deg, rgba(27, 60, 83, 0.15), rgba(69, 104, 130, 0.15));
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        #dropZone.dragover {
            animation: pulseGlow 2s infinite;
            border-style: solid !important;
        }

        @keyframes pulseGlow {
            0%, 100% { 
                border-color: #456882;
                box-shadow: 0 0 20px rgba(69, 104, 130, 0.3);
            }
            50% { 
                border-color: #1B3C53;
                box-shadow: 0 0 30px rgba(27, 60, 83, 0.5);
            }
        }

        input[type="checkbox"]:checked + div {
            background: linear-gradient(135deg, #1B3C53, #456882);
        }

        .progress-step.active {
            background: linear-gradient(135deg, #1B3C53, #456882);
            color: white;
            box-shadow: 0 8px 25px rgba(27, 60, 83, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        textarea {
            min-height: 200px;
        }
        
        input, select, textarea {
            transition: all 0.3s ease;
        }
        
        input:focus, select:focus, textarea:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(27, 60, 83, 0.1);
        }
    </style>
    @endpush
</x-app-layout>