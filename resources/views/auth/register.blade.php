{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.guest')

@section('title', 'Register - Work Nest')

@section('content')
<div x-data="registerWizard()" x-init="init()">
    <!-- Progress Steps -->
    <div class="mb-8">
        <!-- Progress Bar -->
        <div class="step-progress mb-4">
            <div class="step-fill" :style="'width: ' + ((step / 3) * 100) + '%'"></div>
        </div>
        
        <!-- Step Indicators -->
        <div class="flex justify-between mb-1">
            @foreach(['Account', 'Profile', 'Role'] as $index => $title)
                <div class="text-center">
                    <div class="step-circle mx-auto mb-1"
                         :class="step > {{ $index + 1 }} 
                             ? 'bg-green-500 text-white' 
                             : step === {{ $index + 1 }}
                             ? 'bg-gradient-to-br from-purple-500 to-pink-500 text-white shadow-md'
                             : 'bg-gray-200 text-gray-500'">
                        {{ $index + 1 }}
                    </div>
                    <span class="text-xs font-medium"
                          :class="step >= {{ $index + 1 }} ? 'text-gray-800' : 'text-gray-500'">
                        {{ $title }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Registration Form -->
    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf
        
        <!-- Hidden inputs for all data -->
        <input type="hidden" name="name" x-model="form.name">
        <input type="hidden" name="email" x-model="form.email">
        <input type="hidden" name="password" x-model="form.password">
        <input type="hidden" name="phone" x-model="form.phone">
        <input type="hidden" name="location" x-model="form.location">
        <input type="hidden" name="bio" x-model="form.bio">
        <input type="hidden" name="role" x-model="form.role">
        <input type="hidden" name="profile_picture" x-model="form.profilePicture">
        
        <!-- Step 1: Account -->
        <div x-show="step === 1" x-transition.opacity>
            <h3 class="text-lg font-bold text-gray-800 mb-6">Create Your Account</h3>
            
            <!-- Name -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                <input type="text" x-model="form.name" required
                       class="w-full input-field"
                       placeholder="John Doe">
                <div x-show="errors.name" class="mt-1 text-sm text-red-600" x-text="errors.name"></div>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                <input type="email" x-model="form.email" required
                       class="w-full input-field"
                       placeholder="you@example.com">
                <div x-show="errors.email" class="mt-1 text-sm text-red-600" x-text="errors.email"></div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
<!-- Password -->
<div class="mb-8">
    <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
    <input type="password" x-model="form.password" 
           x-on:input="checkPasswordStrength()" required
           class="w-full input-field"
           placeholder="••••••••">
    
    <!-- Password Strength Indicator - Text Only -->
    <div x-show="form.password.length > 0" class="mt-3">
        <div class="flex items-center">
            <span class="text-sm font-medium text-gray-600 mr-2">Strength:</span>
            <span class="text-sm font-semibold"
                  :class="{
                      'text-red-600': passwordStrength.score <= 1,
                      'text-yellow-600': passwordStrength.score == 2,
                      'text-blue-600': passwordStrength.score == 3,
                      'text-green-600': passwordStrength.score >= 4
                  }"
                  x-text="passwordStrength.text"></span>
        </div>
    </div>
    
    <p class="mt-3 text-xs text-gray-500">Minimum 8 characters</p>
    
    <div x-show="errors.password" class="mt-1 text-sm text-red-600" x-text="errors.password"></div>
    @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
            <!-- Navigation -->
            <div class="flex justify-end">
                <button type="button" @click="nextStep()" 
                        class="btn-primary px-8 py-3 text-sm">
                    Continue <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>

<!-- Step 2: Profile -->
<div x-show="step === 2" x-transition.opacity>
    <h3 class="text-lg font-bold text-gray-800 mb-6">Complete Your Profile</h3>
    
    <!-- Profile Picture -->
<!-- Profile Picture - 20MB Version -->
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-3">Profile Picture (Optional)</label>
    
    <div class="flex items-center space-x-4">
        <!-- Preview Container -->
        <div class="relative">
            <div class="w-20 h-20 rounded-full border-2 border-gray-300 overflow-hidden bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                <!-- Image Preview -->
                <img x-show="form.profilePicture" :src="form.profilePicture" 
                     alt="Profile Preview" class="w-full h-full object-cover">
                
                <!-- Default Avatar -->
                <div x-show="!form.profilePicture" class="text-center">
                    <i class="fas fa-user text-purple-300 text-2xl"></i>
                </div>
            </div>
            
            <!-- Change Photo Button -->
            <label for="profile-picture" 
                   class="absolute -bottom-1 -right-1 bg-purple-500 text-white p-1.5 rounded-full cursor-pointer shadow-sm hover:bg-purple-600 transition text-xs">
                <i class="fas fa-camera"></i>
            </label>
            
            <!-- Delete Button (if image exists) -->
            <button x-show="form.profilePicture" @click="form.profilePicture = ''"
                    class="absolute -bottom-1 -left-1 bg-red-500 text-white p-1.5 rounded-full cursor-pointer shadow-sm hover:bg-red-600 transition text-xs">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Upload Section -->
        <div class="flex-1">
            <div class="space-y-2">
                <!-- File Input (Hidden) -->
                <input type="file" id="profile-picture" accept="image/*" 
                       class="hidden" @change="handleProfilePicture">
                
                <!-- Upload Button -->
                <label for="profile-picture" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg cursor-pointer transition border border-gray-300">
                    <i class="fas fa-upload mr-2 text-sm"></i> Choose Photo
                </label>
                
               
                
                <!-- Current File Info -->
                <div x-show="form.profilePicture" class="text-xs text-green-600">
                    <i class="fas fa-check-circle mr-1"></i>
                    Photo selected
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Phone -->
    <div class="mb-5">
        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
        <input type="tel" x-model="form.phone"
               class="w-full input-field"
               placeholder="+1 (555) 123-4567">
    </div>

    <!-- Location -->
    <div class="mb-5">
        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
        <input type="text" x-model="form.location"
               class="w-full input-field"
               placeholder="City, Country">
    </div>

    <!-- Bio -->
    <div class="mb-8">
        <label class="block text-sm font-medium text-gray-700 mb-2">Bio (Optional)</label>
        <textarea x-model="form.bio" rows="2"
                  class="w-full input-field resize-none"
                  placeholder="Tell us about yourself..."></textarea>
    </div>

    <!-- Navigation -->
    <div class="flex justify-between">
        <button type="button" @click="prevStep()"
                class="btn-secondary px-6 py-3 text-sm">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </button>
        <button type="button" @click="nextStep()" 
                class="btn-primary px-8 py-3 text-sm">
            Continue <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</div>

        <!-- Step 3: Role -->
        <div x-show="step === 3" x-transition.opacity>
            <h3 class="text-lg font-bold text-gray-800 mb-6">Choose Your Role</h3>
            
            <!-- Role Cards -->
            <div class="space-y-4 mb-8">
                <!-- Freelancer -->
                <div @click="form.role = 'freelancer'"
                     :class="form.role === 'freelancer' ? 'active' : ''"
                     class="role-card">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                <i class="fas fa-laptop-code text-white text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h4 class="font-bold text-gray-800 mb-1">I'm a Freelancer</h4>
                            <p class="text-gray-600 text-xs mb-2">
                                I want to offer my skills and find projects
                            </p>
                            <div class="space-y-1 text-xs text-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    <span>Find work worldwide</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    <span>Set your own rates</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 ml-4">
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                 :class="form.role === 'freelancer' 
                                     ? 'border-purple-500 bg-purple-500' 
                                     : 'border-gray-300'">
                                <i class="fas fa-check text-white text-xs" 
                                   x-show="form.role === 'freelancer'"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Client -->
                <div @click="form.role = 'client'"
                     :class="form.role === 'client' ? 'active' : ''"
                     class="role-card">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center">
                                <i class="fas fa-briefcase text-white text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h4 class="font-bold text-gray-800 mb-1">I'm a Client</h4>
                            <p class="text-gray-600 text-xs mb-2">
                                I want to hire talent and get projects done
                            </p>
                            <div class="space-y-1 text-xs text-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    <span>Access top freelancers</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    <span>Manage projects easily</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 ml-4">
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                 :class="form.role === 'client' 
                                     ? 'border-green-500 bg-green-500' 
                                     : 'border-gray-300'">
                                <i class="fas fa-check text-white text-xs" 
                                   x-show="form.role === 'client'"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Terms -->
            <div class="mb-6">
                <div class="flex items-start">
                    <input id="terms" name="terms" type="checkbox" required
                           class="w-4 h-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500 mt-0.5">
                    <label for="terms" class="ml-2 text-sm text-gray-700">
                        I agree to the <a href="#" class="text-purple-600 hover:underline">Terms</a> 
                        and <a href="#" class="text-purple-600 hover:underline">Privacy Policy</a>
                    </label>
                </div>
            </div>

            <!-- Navigation & Submit -->
            <div class="flex justify-between items-center">
                <button type="button" @click="prevStep()"
                        class="btn-secondary px-6 py-3 text-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </button>
                
                <button type="button" @click="submitForm()" :disabled="!form.role || submitting"
                        :class="(!form.role || submitting) 
                            ? 'bg-gray-400 cursor-not-allowed px-8 py-3 text-sm' 
                            : 'btn-primary px-8 py-3 text-sm'">
                    <span x-show="!submitting">
                        <i class="fas fa-rocket mr-2"></i> Complete
                    </span>
                    <span x-show="submitting" class="flex items-center">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Creating...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function registerWizard() {
    return {
        step: 1,
        submitting: false,
        errors: {},
        form: {
            name: '',
            email: '',
            password: '',
            phone: '',
            location: '',
            bio: '',
            role: '{{ request()->get("role", "freelancer") }}',
            profilePicture: ''
        },
         // === ADD THIS ===
passwordStrength: {
    score: 0,
    percentage: 0,  // ADD THIS
    text: 'Very Weak'
},
        
        init() {
            const urlParams = new URLSearchParams(window.location.search);
            const roleParam = urlParams.get('role');
            if (roleParam && ['freelancer', 'client'].includes(roleParam)) {
                this.form.role = roleParam;
                this.step = 3;
            }
        },
 checkPasswordStrength() {
    const password = this.form.password;
    let score = 0;
    
    // 5 criteria check
    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;
    
    // Calculate percentage (0-100%)
    const percentage = score * 20; // 0, 20, 40, 60, 80, 100
    
    // Update both score and percentage
    this.passwordStrength.score = score;
    this.passwordStrength.percentage = percentage;
    
    // Set text
    if (score === 0) {
        this.passwordStrength.text = 'Very Weak';
    } else if (score === 1) {
        this.passwordStrength.text = 'Weak';
    } else if (score === 2) {
        this.passwordStrength.text = 'Fair';
    } else if (score === 3) {
        this.passwordStrength.text = 'Good';
    } else if (score === 4) {
        this.passwordStrength.text = 'Strong';
    } else {
        this.passwordStrength.text = 'Very Strong';
    }
},
// Add this method to handle profile picture upload
handleProfilePicture(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    // Check file size (max 20MB)
    if (file.size > 20 * 1024 * 1024) {
        alert('File size should be less than 20MB');
        return;
    }
    
    // Check file type
    if (!file.type.match('image.*')) {
        alert('Please select an image file (JPG, PNG, GIF)');
        return;
    }
    
    // Create preview
    const reader = new FileReader();
    reader.onload = (e) => {
        this.form.profilePicture = e.target.result;
    };
    reader.readAsDataURL(file);
},
        
        validateStep1() {
            this.errors = {};
            let isValid = true;
            
            if (!this.form.name.trim()) {
                this.errors.name = 'Name is required';
                isValid = false;
            }
            
            if (!this.form.email.trim()) {
                this.errors.email = 'Email is required';
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) {
                this.errors.email = 'Please enter a valid email';
                isValid = false;
            }
            
            if (!this.form.password) {
                this.errors.password = 'Password is required';
                isValid = false;
            } else if (this.form.password.length < 8) {
                this.errors.password = 'Password must be at least 8 characters';
                isValid = false;
            }
            
            return isValid;
        },
        
        nextStep() {
            if (this.step === 1 && !this.validateStep1()) {
                return;
            }
            
            if (this.step < 3) {
                this.step++;
            }
        },
        
        prevStep() {
            if (this.step > 1) {
                this.step--;
            }
        },
        
        submitForm() {
            // Clear previous errors
            this.errors = {};
            
            // Validate all steps
            if (!this.validateStep1()) {
                this.step = 1;
                return;
            }
            
            if (!this.form.role) {
                alert('Please select a role');
                return;
            }
            
            if (!document.getElementById('terms').checked) {
                alert('Please agree to the terms and conditions');
                return;
            }
            
            this.submitting = true;
            
            // Update hidden inputs with current data
            document.querySelector('input[name="name"]').value = this.form.name;
            document.querySelector('input[name="email"]').value = this.form.email;
            document.querySelector('input[name="password"]').value = this.form.password;
            document.querySelector('input[name="phone"]').value = this.form.phone || '';
            document.querySelector('input[name="location"]').value = this.form.location || '';
            document.querySelector('input[name="bio"]').value = this.form.bio || '';
            document.querySelector('input[name="role"]').value = this.form.role;
            document.querySelector('input[name="profile_picture"]').value = this.form.profilePicture || '';
            
            // Submit the form normally (Laravel will handle validation)
            document.getElementById('registerForm').submit();
        }
    }
}
</script>
@endsection