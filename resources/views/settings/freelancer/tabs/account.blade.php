<div>
    <h2 class="text-xl font-bold text-purple-700 mb-6">Account Settings</h2>
    
    <form action="{{ route('settings.update.account') }}" method="POST" class="settings-form space-y-6">
        @csrf
        
        <div class="border rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" 
                           class="form-input" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" 
                           class="form-input" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="tel" name="phone" value="{{ $user->phone ?? '' }}" 
                           class="form-input">
                </div>
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" 
                    class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                Save Changes
            </button>
        </div>
    </form>
</div>