<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile - Freelancer - WorkNest</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8B5CF6',
                        secondary: '#7C3AED',
                        accent: '#A78BFA',
                        light: '#F5F3FF',
                        dark: '#1F1A38'
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 50%, #A78BFA 100%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 92, 246, 0.2);
        }
        
        .skill-tag {
            transition: all 0.3s ease;
        }
        
        .skill-tag:hover {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
            color: white;
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 to-indigo-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg gradient-bg flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800">Work<span class="text-primary">Nest</span></span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-primary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Sidebar -->
            <div class="lg:w-1/3">
                <!-- Profile Card -->
                <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 hover-lift">
                    <div class="text-center">
                        <!-- Avatar with Upload -->
                        <div class="relative inline-block mb-4">
                            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg mx-auto">
                                <img src="{{ auth()->user()->getAvatarUrl() }}" 
                                     alt="{{ auth()->user()->name }}"
                                     class="w-full h-full object-cover"
                                     id="avatar-preview">
                            </div>
                            <label for="avatar-upload" 
                                   class="absolute bottom-2 right-2 bg-primary text-white p-2 rounded-full cursor-pointer hover:bg-secondary">
                                <i class="fas fa-camera"></i>
                            </label>
                        </div>
                        
                        <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-600">{{ auth()->user()->title ?? 'Freelancer' }}</p>
                        
                        <!-- Rating -->
                        <div class="flex items-center justify-center mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-{{ $i <= 4.5 ? 'yellow-400' : 'gray-300' }}"></i>
                            @endfor
                            <span class="ml-2 text-gray-600">4.5 (24 reviews)</span>
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-4 mt-6">
                            <div class="text-center">
                                <div class="text-xl font-bold text-primary">42</div>
                                <div class="text-sm text-gray-600">Jobs Done</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xl font-bold text-primary">96%</div>
                                <div class="text-sm text-gray-600">Success Rate</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xl font-bold text-primary">4.2</div>
                                <div class="text-sm text-gray-600">Avg. Rating</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Progress -->
                <div class="bg-white rounded-2xl shadow-xl p-6 hover-lift">
                    <h3 class="font-bold text-gray-800 mb-4">Profile Strength</h3>
                    <div class="mb-3">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-600">Completeness</span>
                            <span class="text-sm font-bold text-primary">{{ auth()->user()->getProfileCompletenessPercentage() }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <!-- Blade Template -->
                           <div class="bg-gradient-to-r from-green-400 to-blue-500 h-3 rounded-full" 
                              data-width="{{ auth()->user()->getProfileCompletenessPercentage() }}" 
                              id="profile-progress">
                            </div>

                        <script>
                          document.addEventListener('DOMContentLoaded', function() {
                             const progressBar = document.getElementById('profile-progress');
                             if (progressBar) {
                                 const width = progressBar.getAttribute('data-width') + '%';
                                   progressBar.style.width = width;
                                     }
                                   });
                        </script>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas {{ auth()->user()->avatar ? 'fa-check-circle text-green-500' : 'fa-times-circle text-gray-300' }} mr-2"></i>
                            <span class="text-sm">Profile Photo</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas {{ auth()->user()->title ? 'fa-check-circle text-green-500' : 'fa-times-circle text-gray-300' }} mr-2"></i>
                            <span class="text-sm">Professional Title</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas {{ auth()->user()->bio ? 'fa-check-circle text-green-500' : 'fa-times-circle text-gray-300' }} mr-2"></i>
                            <span class="text-sm">Bio/Description</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas {{ auth()->user()->hourly_rate ? 'fa-check-circle text-green-500' : 'fa-times-circle text-gray-300' }} mr-2"></i>
                            <span class="text-sm">Hourly Rate</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas {{ auth()->user()->location ? 'fa-check-circle text-green-500' : 'fa-times-circle text-gray-300' }} mr-2"></i>
                            <span class="text-sm">Location</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Form -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-2xl shadow-xl p-8 hover-lift">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Freelancer Profile</h1>
                            <p class="text-gray-600">Complete your profile to attract more clients</p>
                        </div>
                        <div class="px-4 py-2 gradient-bg text-white rounded-full text-sm font-medium">
                            {{ auth()->user()->isProfileComplete() ? 'Profile Complete' : 'Complete Profile' }}
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('patch')
                        
                        <!-- Hidden avatar input -->
                        <input type="file" id="avatar-upload" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                        
                        <!-- Professional Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Professional Title *</label>
                            <input type="text" name="title" 
                                   value="{{ old('title', auth()->user()->title) }}"
                                   placeholder="e.g., Senior Web Developer"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            <p class="text-xs text-gray-500 mt-1">This appears in search results</p>
                        </div>
                        
                        <!-- Hourly Rate -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hourly Rate ($) *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">$</span>
                                <input type="number" name="hourly_rate" min="5" step="5"
                                       value="{{ old('hourly_rate', auth()->user()->hourly_rate) }}"
                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            </div>
                        </div>
                        
                        <!-- Bio -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bio / Description *</label>
                            <textarea name="bio" rows="4"
                                      placeholder="Describe your skills, experience, and expertise..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none">{{ old('bio', auth()->user()->bio) }}</textarea>
                        </div>
                        
                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                            <input type="text" name="location"
                                   value="{{ old('location', auth()->user()->location) }}"
                                   placeholder="e.g., New York, USA"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                        
                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone"
                                   value="{{ old('phone', auth()->user()->phone) }}"
                                   placeholder="+1 (555) 123-4567"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                        
                        <!-- Skills -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Skills *</label>
                            <div class="flex flex-wrap gap-2 mb-3" id="skills-container">
                                @php
                                    $skills = ['Laravel', 'PHP', 'Vue.js', 'JavaScript', 'Tailwind CSS'];
                                @endphp
                                @foreach($skills as $skill)
                                <span class="skill-tag px-3 py-1 bg-purple-100 text-primary rounded-full text-sm cursor-pointer" onclick="removeSkill(this)">
                                    {{ $skill }} <i class="fas fa-times ml-1"></i>
                                </span>
                                @endforeach
                            </div>
                            <div class="flex">
                                <input type="text" id="skill-input" 
                                       placeholder="Add a skill (press Enter)"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <button type="button" onclick="addSkill()" class="px-4 bg-primary text-white rounded-r-lg hover:bg-secondary">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <input type="hidden" name="skills" id="skills-input" value="{{ json_encode($skills) }}">
                        </div>
                        
                        <!-- Portfolio Links -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Portfolio Links</label>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-globe text-gray-400"></i>
                                    <input type="url" name="website"
                                           value="{{ old('website', auth()->user()->profile->website ?? '') }}"
                                           placeholder="https://yourportfolio.com"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>
                                <div class="flex items-center space-x-3">
                                    <i class="fab fa-github text-gray-400"></i>
                                    <input type="url" name="github"
                                           value="{{ old('github', auth()->user()->profile->github ?? '') }}"
                                           placeholder="https://github.com/username"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>
                                <div class="flex items-center space-x-3">
                                    <i class="fab fa-linkedin text-gray-400"></i>
                                    <input type="url" name="linkedin"
                                           value="{{ old('linkedin', auth()->user()->profile->linkedin ?? '') }}"
                                           placeholder="https://linkedin.com/in/username"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('dashboard') }}" 
                               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 gradient-bg text-white rounded-lg hover:shadow-xl transition-all duration-300">
                                <i class="fas fa-save mr-2"></i> Save Profile
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Portfolio Section -->
                <div class="mt-8 bg-white rounded-2xl shadow-xl p-6 hover-lift">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Portfolio</h3>
                            <p class="text-gray-600 text-sm">Showcase your best work</p>
                        </div>
                        <button class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary">
                            <i class="fas fa-plus mr-2"></i> Add Project
                        </button>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary cursor-pointer">
                            <i class="fas fa-plus text-3xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600">Add your first project</p>
                        </div>
                        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md cursor-pointer">
                            <div class="w-full h-40 bg-gradient-to-r from-primary to-accent rounded-lg mb-4"></div>
                            <h4 class="font-medium text-gray-800">E-commerce Website</h4>
                            <p class="text-gray-600 text-sm mt-1">Built with Laravel & Vue.js</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Avatar Preview
        function previewAvatar(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('avatar-preview');
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
        
        // Skills Management
        function addSkill() {
            const input = document.getElementById('skill-input');
            const skill = input.value.trim();
            
            if (skill && skill.length > 0) {
                const tag = document.createElement('span');
                tag.className = 'skill-tag px-3 py-1 bg-purple-100 text-primary rounded-full text-sm cursor-pointer';
                tag.innerHTML = `${skill} <i class="fas fa-times ml-1" onclick="removeSkill(this.parentNode)"></i>`;
                
                document.getElementById('skills-container').appendChild(tag);
                updateSkillsInput();
                input.value = '';
                input.focus();
            }
        }
        
        function removeSkill(element) {
            element.remove();
            updateSkillsInput();
        }
        
        function updateSkillsInput() {
            const skills = [];
            document.querySelectorAll('#skills-container .skill-tag').forEach(tag => {
                skills.push(tag.textContent.replace('×', '').trim());
            });
            document.getElementById('skills-input').value = JSON.stringify(skills);
        }
        
        document.getElementById('skill-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addSkill();
            }
        });
    </script>
</body>
</html>