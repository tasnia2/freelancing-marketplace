<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    {{ __('Edit Job') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('Update your job details') }}
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

            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-300">
                                {{ __('Please fix the following errors:') }}
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

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <form action="{{ route('client.jobs.update', $job) }}" method="POST" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @csrf
                    @method('PUT')
                    
                    <!-- Job Information -->
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">{{ __('Job Information') }}</h3>
                        
                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Job Title') }} *
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $job->title) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Job Description') }} *
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="8"
                                      required
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">{{ old('description', $job->description) }}</textarea>
                        </div>

                        <!-- Skills -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Skills Required') }} *
                            </label>
                            <input type="text" 
                                   id="skillsInput"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg mb-3"
                                   placeholder="{{ __('Type skills separated by commas') }}">
                            <div id="skillsContainer" class="flex flex-wrap gap-2 mb-2">
                                @foreach($job->skills_required as $skill)
                                    <span class="skill-tag" data-skill="{{ $skill }}">
                                        {{ $skill }}
                                        <button type="button" onclick="removeSkill('{{ $skill }}')" class="ml-2">×</button>
                                    </span>
                                @endforeach
                            </div>
                            <input type="hidden" name="skills" id="skillsHidden" value='{{ json_encode($job->skills_required) }}'>
                        </div>

                        <!-- Experience Level -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Experience Level') }} *
                            </label>
                            <select name="experience_level" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="entry" {{ old('experience_level', $job->experience_level) == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                <option value="intermediate" {{ old('experience_level', $job->experience_level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="expert" {{ old('experience_level', $job->experience_level) == 'expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                        </div>

                        <!-- Job Type -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Job Type') }} *
                            </label>
                            <select name="job_type" 
                                    id="jobType"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="fixed" {{ old('job_type', $job->job_type) == 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                                <option value="hourly" {{ old('job_type', $job->job_type) == 'hourly' ? 'selected' : '' }}>Hourly Rate</option>
                            </select>
                        </div>

                        <!-- Budget -->
                        <div id="budgetField" class="mb-6">
                             <label for="budget" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                              {{ __('Budget') }} ($) @if($job->job_type == 'fixed') * @endif
                            </label>
                           <input type="number" 
                            id="budget" 
                            name="budget" 
                            value="{{ old('budget', $job->budget) }}"
                            min="10"
                            step="10"
                            @if($job->job_type == 'fixed') required @endif
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                            @error('budget')
                           <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hourly Rate (hidden if not hourly) -->
                        <div id="hourlyFields" class="mb-6 {{ $job->job_type != 'hourly' ? 'hidden' : '' }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="hourly_rate" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Hourly Rate') }} ($) *
                                    </label>
                                    <input type="number" 
                                           id="hourly_rate" 
                                           name="hourly_rate" 
                                           value="{{ old('hourly_rate', $job->hourly_rate) }}"
                                           min="5"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="hours_per_week" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('Hours/Week') }}
                                    </label>
                                    <input type="number" 
                                           id="hours_per_week" 
                                           name="hours_per_week" 
                                           value="{{ old('hours_per_week', $job->hours_per_week) }}"
                                           min="1"
                                           max="168"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Project Length -->
                        <div class="mb-6">
                            <label for="project_length" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Project Length') }} *
                            </label>
                            <select name="project_length"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="less_than_1_month" {{ old('project_length', $job->project_length) == 'less_than_1_month' ? 'selected' : '' }}>Less than 1 month</option>
                                <option value="1_to_3_months" {{ old('project_length', $job->project_length) == '1_to_3_months' ? 'selected' : '' }}>1 to 3 months</option>
                                <option value="3_to_6_months" {{ old('project_length', $job->project_length) == '3_to_6_months' ? 'selected' : '' }}>3 to 6 months</option>
                                <option value="more_than_6_months" {{ old('project_length', $job->project_length) == 'more_than_6_months' ? 'selected' : '' }}>More than 6 months</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Status') }} *
                            </label>
                            <select name="status"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="draft" {{ old('status', $job->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="open" {{ old('status', $job->status) == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ old('status', $job->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status', $job->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $job->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <!-- Remote Work -->
                        <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg mb-6">
                            <div>
                                <div class="font-medium text-gray-800 dark:text-white">{{ __('Remote Work') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('This is a remote position') }}
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_remote" 
                                       value="1"
                                       {{ old('is_remote', $job->is_remote) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#456882]"></div>
                            </label>
                        </div>

                        <!-- Urgent -->
                        <div class="flex items-center justify-between p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                            <div>
                                <div class="font-medium text-gray-800 dark:text-white">{{ __('Urgent Job') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Mark as urgent for more visibility') }}
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_urgent" 
                                       value="1"
                                       {{ old('is_urgent', $job->is_urgent) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1B3C53]"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="p-8">
                        <div class="flex justify-between items-center">
                            <a href="{{ route('client.jobs') }}" 
                               class="px-6 py-3 border border-[#456882] text-[#1B3C53] dark:text-white rounded-lg hover:bg-[#E3E3E3] dark:hover:bg-gray-700 transition-all duration-300">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 font-medium">
                                {{ __('Update Job') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Skills management
            const skillsInput = document.getElementById('skillsInput');
            const skillsContainer = document.getElementById('skillsContainer');
            const skillsHidden = document.getElementById('skillsHidden');
            
            let skills = JSON.parse(skillsHidden.value || '[]');
            
            function updateSkills() {
                skillsHidden.value = JSON.stringify(skills);
                renderSkills();
            }
            
            function renderSkills() {
                skillsContainer.innerHTML = '';
                skills.forEach(skill => {
                    const span = document.createElement('span');
                    span.className = 'inline-flex items-center px-3 py-1 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] text-white';
                    span.innerHTML = `
                        ${skill}
                        <button type="button" onclick="removeSkill('${skill}')" class="ml-2 hover:text-red-200">
                            ×
                        </button>
                    `;
                    skillsContainer.appendChild(span);
                });
            }
            
            window.removeSkill = function(skill) {
                skills = skills.filter(s => s !== skill);
                updateSkills();
            }
            
            skillsInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const skill = this.value.trim();
                    if (skill && !skills.includes(skill)) {
                        skills.push(skill);
                        updateSkills();
                        this.value = '';
                    }
                }
            });
            
            renderSkills();
            
            // Job type toggle
            const jobType = document.getElementById('jobType');
            const budgetField = document.getElementById('budgetField');
            const hourlyFields = document.getElementById('hourlyFields');
            
            function toggleJobType() {
                if (jobType.value === 'hourly') {
                    budgetField.classList.add('hidden');
                    hourlyFields.classList.remove('hidden');
                } else {
                    budgetField.classList.remove('hidden');
                    hourlyFields.classList.add('hidden');
                }
            }
            
            jobType.addEventListener('change', toggleJobType);
            toggleJobType(); // Initial call
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .skill-tag {
            background: linear-gradient(135deg, #1B3C53, #456882);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            margin: 0.25rem;
        }
        
        .skill-tag button {
            margin-left: 0.5rem;
            cursor: pointer;
            background: none;
            border: none;
            color: white;
        }
    </style>
    @endpush
</x-app-layout>