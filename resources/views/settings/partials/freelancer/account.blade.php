<!-- resources/views/settings/freelancer/tabs/account.blade.php -->
<div>
    <h2 class="text-2xl font-bold mb-6 text-purple-700">Account Settings</h2>
    
    <form action="{{ route('settings.update.account') }}" method="POST" class="settings-form">
        @csrf
        
        <div class="space-y-6">
            <!-- Personal Info -->
            <div class="settings-card p-6 border rounded-lg">
                <h3 class="text-lg font-semibold mb-4 text-gray-900">Personal Information</h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" 
                               class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ $user->email }}" 
                               class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="phone" value="{{ $user->phone ?? '' }}" 
                               class="form-input" placeholder="+1 (555) 123-4567">
                    </div>
                </div>
            </div>
            
            <!-- Preferences -->
            <div class="settings-card p-6 border rounded-lg">
                <h3 class="text-lg font-semibold mb-4 text-gray-900">Preferences</h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">Language</label>
                        <select name="language" class="form-input">
                            <option value="en" {{ ($user->meta()->where('key', 'language')->first()?->value ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="es" {{ ($user->meta()->where('key', 'language')->first()?->value ?? 'en') == 'es' ? 'selected' : '' }}>Spanish</option>
                            <option value="fr" {{ ($user->meta()->where('key', 'language')->first()?->value ?? 'en') == 'fr' ? 'selected' : '' }}>French</option>
                            <option value="de" {{ ($user->meta()->where('key', 'language')->first()?->value ?? 'en') == 'de' ? 'selected' : '' }}>German</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Timezone</label>
                        <select name="timezone" class="form-input">
                            @foreach(timezone_identifiers_list() as $tz)
                                <option value="{{ $tz }}" {{ $tz == ($user->meta()->where('key', 'timezone')->first()?->value ?? 'UTC') ? 'selected' : '' }}>
                                    {{ $tz }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="save-btn text-white" 
                        style="background: linear-gradient(to right, #8b5cf6, #7c3aed);">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </div>
        </div>
    </form>
</div>