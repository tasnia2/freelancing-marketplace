<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - WorkNest</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Work<span class="text-purple-600">Nest</span></span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('profile') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-eye mr-1"></i> View Profile
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-gray-600">Update your profile information to attract more clients</p>
        </div>
        
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        
        <!-- Error Messages -->
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">Please fix the following errors:</p>
                        <ul class="mt-2 text-red-700 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border p-6">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="space-y-6">
                    <!-- Avatar Upload -->
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <img id="avatar-preview" src="{{ $user->getAvatarUrl() }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-24 h-24 rounded-full border-4 border-white shadow-lg">
                            <label for="avatar-upload" class="absolute bottom-0 right-0 w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center cursor-pointer hover:bg-purple-700">
                                <i class="fas fa-camera text-white"></i>
                            </label>
                            <input type="file" id="avatar-upload" name="avatar" accept="image/*" class="hidden" 
                                   onchange="previewAvatar(event)">
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Profile Picture</h3>
                            <p class="text-sm text-gray-600">Upload a professional photo</p>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <input type="text" name="location" value="{{ old('location', $user->location) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                                       placeholder="City, Country">
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Professional Information</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Professional Title *</label>
                                <input type="text" name="title" value="{{ old('title', $user->title) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                                       placeholder="e.g., Senior Web Developer" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Hourly Rate ($)</label>
                                <input type="number" name="hourly_rate" value="{{ old('hourly_rate', $user->hourly_rate) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                                       min="0" step="0.01" placeholder="e.g., 50.00">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bio / Introduction *</label>
                                <textarea name="bio" rows="4" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                                          placeholder="Tell clients about yourself, your experience, and what you can do for them..." required>{{ old('bio', $user->bio) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Skills</h3>
                        <div id="skills-container">
                            @if($user->profile && !empty($user->profile->skills))
                                @foreach($user->profile->skills as $skill)
                                    <div class="skill-input flex items-center mb-2">
                                        <input type="text" name="skills[]" value="{{ $skill }}" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                                               placeholder="e.g., Laravel, React, UI/UX Design">
                                        <button type="button" onclick="removeSkill(this)" class="ml-2 text-red-500 hover:text-red-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="skill-input flex items-center mb-2">
                                    <input type="text" name="skills[]" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                                           placeholder="e.g., Laravel, React, UI/UX Design">
                                    <button type="button" onclick="removeSkill(this)" class="ml-2 text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" onclick="addSkill()" class="mt-2 text-purple-600 hover:text-purple-700">
                            <i class="fas fa-plus mr-1"></i> Add Skill
                        </button>
                    </div>

                    <!-- Social Links -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Links</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                                <input type="url" name="website" value="{{ old('website', $user->profile->website ?? '') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                                       placeholder="https://yourwebsite.com">
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
                                    <input type="url" name="linkedin" value="{{ old('linkedin', $user->profile->linkedin ?? '') }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                                           placeholder="https://linkedin.com/in/yourprofile">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">GitHub</label>
                                    <input type="url" name="github" value="{{ old('github', $user->profile->github ?? '') }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                                           placeholder="https://github.com/yourusername">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 pt-6 border-t">
                        <a href="{{ route('profile') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewAvatar(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('avatar-preview');
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
        
        function addSkill() {
            const container = document.getElementById('skills-container');
            const div = document.createElement('div');
            div.className = 'skill-input flex items-center mb-2';
            div.innerHTML = `
                <input type="text" name="skills[]" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                       placeholder="e.g., Laravel, React, UI/UX Design">
                <button type="button" onclick="removeSkill(this)" class="ml-2 text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }
        
        function removeSkill(button) {
            const skillInputs = document.querySelectorAll('.skill-input');
            if (skillInputs.length > 1) {
                button.closest('.skill-input').remove();
            }
        }
    </script>
</body>
</html>