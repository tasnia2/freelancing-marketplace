<div>
    <h2 class="text-xl font-bold mb-6" style="color: #1B3C53;">Account Settings</h2>
    
    <form action="{{ route('settings.update.account') }}" method="POST" class="settings-form space-y-6">
        @csrf
        
        <div class="border rounded-lg p-6" style="border-color: #E3E3E3;">
            <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1" style="color: #234C6A;">Full Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" 
                           class="form-input" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-1" style="color: #234C6A;">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" 
                           class="form-input" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-1" style="color: #234C6A;">Phone</label>
                    <input type="tel" name="phone" value="{{ $user->phone ?? '' }}" 
                           class="form-input">
                </div>
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" 
                    class="px-4 py-2 text-white rounded" 
                    style="background-color: #1B3C53;">
                Save Changes
            </button>
        </div>
    </form>
</div>