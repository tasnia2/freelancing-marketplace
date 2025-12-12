<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile - WorkNest</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .skill-tag {
            transition: all 0.3s ease;
        }
        
        .skill-tag:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation (same as dashboard) -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800">WorkNest</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Profile Edit Form -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-lg p-8 hover-lift">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Complete Your Profile</h1>
                    <p class="text-gray-600">A complete profile gets 3x more job opportunities</p>
                </div>
                <div class="px-4 py-2 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-full text-sm font-medium">
                    {{ auth()->user()->isProfileComplete() ? '100% Complete' : 'Complete Your Profile' }}
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Profile Strength</span>
                    <span class="text-sm font-bold text-blue-600">
                        {{ auth()->user()->isProfileComplete() ? '100%' : '60%' }}
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
               <div class="bg-gradient-to-r from-green-400 to-blue-500 h-3 rounded-full" 
                data-width="{{ auth()->user()->isProfileComplete() ? '100' : '60' }}" 
                  id="profile-progress"></div>
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
            
            <!-- Form -->
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Profile Picture -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                            <div class="flex items-center space-x-4">
                                <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <input type="file" name="avatar" accept="image/*" class="text-sm text-gray-500">
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF • Max 5MB</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Headline -->
                        <div>
                            <label for="headline" class="block text-sm font-medium text-gray-700 mb-2">Professional Headline *</label>
                            <input type="text" id="headline" name="headline" 
                                   value="{{ old('headline', auth()->user()->profile->headline ?? '') }}"
                                   placeholder="e.g., Senior Web Developer"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">This appears next to your name in search results</p>
                        </div>
                        
                        <!-- Hourly Rate -->
                        <div>
                            <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">Hourly Rate ($) *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">$</span>
                                <input type="number" id="hourly_rate" name="hourly_rate" min="5" step="5"
                                       value="{{ old('hourly_rate', auth()->user()->hourly_rate ?? '') }}"
                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <input type="text" id="location" name="location"
                                   value="{{ old('location', auth()->user()->location ?? '') }}"
                                   placeholder="e.g., New York, USA"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Bio/Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Bio / Description *</label>
                            <textarea id="description" name="description" rows="6"
                                      placeholder="Describe your skills, experience, and what you can offer to clients..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none">{{ old('description', auth()->user()->profile->description ?? '') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Minimum 150 characters recommended</p>
                        </div>
                        
                        <!-- Skills -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Skills *</label>
                            <div class="flex flex-wrap gap-2 mb-3" id="skills-container">
                                @php
                                    $skills = auth()->user()->profile->skills ?? ['Web Development', 'Laravel', 'PHP'];
                                    $skills = is_string($skills) ? json_decode($skills, true) : $skills;
                                @endphp
                                
                                @if($skills)
                                    @foreach($skills as $skill)
                                    <span class="skill-tag px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm cursor-pointer" onclick="removeSkill(this)">
                                        {{ $skill }} <i class="fas fa-times ml-1"></i>
                                    </span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="flex">
                                <input type="text" id="skill-input" 
                                       placeholder="Add a skill (press Enter)"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <button type="button" onclick="addSkill()" class="px-4 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <input type="hidden" name="skills" id="skills-input" value="{{ json_encode($skills ?? []) }}">
                        </div>
                    </div>
                </div>
                
                <!-- Social Links -->
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Social Links</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                            <input type="url" id="website" name="website"
                                   value="{{ old('website', auth()->user()->profile->website ?? '') }}"
                                   placeholder="https://yourportfolio.com"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-2">LinkedIn</label>
                            <input type="url" id="linkedin" name="linkedin"
                                   value="{{ old('linkedin', auth()->user()->profile->linkedin ?? '') }}"
                                   placeholder="https://linkedin.com/in/yourname"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="github" class="block text-sm font-medium text-gray-700 mb-2">GitHub</label>
                            <input type="url" id="github" name="github"
                                   value="{{ old('github', auth()->user()->profile->github ?? '') }}"
                                   placeholder="https://github.com/yourusername"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="twitter" class="block text-sm font-medium text-gray-700 mb-2">Twitter</label>
                            <input type="url" id="twitter" name="twitter"
                                   value="{{ old('twitter', auth()->user()->profile->twitter ?? '') }}"
                                   placeholder="https://twitter.com/yourusername"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
                
                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('dashboard') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i> Save Profile
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Missing Sections -->
        <div class="mt-8 grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl p-6 border border-gray-200 text-center hover-lift">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-images text-blue-600"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Portfolio</h3>
                <p class="text-gray-600 text-sm mb-4">Showcase your best work</p>
                <button class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm hover:bg-blue-100">
                    Add Portfolio Items
                </button>
            </div>
            
            <div class="bg-white rounded-xl p-6 border border-gray-200 text-center hover-lift">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-100 to-teal-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-certificate text-green-600"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Certifications</h3>
                <p class="text-gray-600 text-sm mb-4">Add verified credentials</p>
                <button class="px-4 py-2 bg-green-50 text-green-600 rounded-lg text-sm hover:bg-green-100">
                    Add Certifications
                </button>
            </div>
            
            <div class="bg-white rounded-xl p-6 border border-gray-200 text-center hover-lift">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-orange-100 to-red-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-history text-orange-600"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Work History</h3>
                <p class="text-gray-600 text-sm mb-4">Add past experience</p>
                <button class="px-4 py-2 bg-orange-50 text-orange-600 rounded-lg text-sm hover:bg-orange-100">
                    Add Experience
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript for Skills -->
    <script>
        function addSkill() {
            const input = document.getElementById('skill-input');
            const skill = input.value.trim();
            
            if (skill && skill.length > 0) {
                // Create skill tag
                const tag = document.createElement('span');
                tag.className = 'skill-tag px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm cursor-pointer';
                tag.innerHTML = `${skill} <i class="fas fa-times ml-1" onclick="removeSkill(this.parentNode)"></i>`;
                
                // Add to container
                document.getElementById('skills-container').appendChild(tag);
                
                // Update hidden input
                updateSkillsInput();
                
                // Clear input
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
        
        // Add skill on Enter key
        document.getElementById('skill-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addSkill();
            }
        });
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const skills = JSON.parse(document.getElementById('skills-input').value || '[]');
            if (skills.length === 0) {
                e.preventDefault();
                alert('Please add at least one skill');
                document.getElementById('skill-input').focus();
            }
        });
    </script>
</body>
</html>