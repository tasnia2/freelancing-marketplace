<aside class="settings-sidebar">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h2 class="text-xl font-bold mb-6 text-purple-700">Settings</h2>
        
        <div class="space-y-1">
            <a href="#" data-tab="account" class="settings-tab flex items-center text-gray-700 hover:text-purple-600 active">
                <i class="fas fa-user-circle w-5 mr-3"></i>
                <span>Account</span>
            </a>
            
            <a href="#" data-tab="profile" class="settings-tab flex items-center text-gray-700 hover:text-purple-600">
                <i class="fas fa-id-card w-5 mr-3"></i>
                <span>Profile & Skills</span>
            </a>
            
            <a href="#" data-tab="availability" class="settings-tab flex items-center text-gray-700 hover:text-purple-600">
                <i class="fas fa-calendar-alt w-5 mr-3"></i>
                <span>Availability & Rates</span>
            </a>
            
            <a href="#" data-tab="portfolio" class="settings-tab flex items-center text-gray-700 hover:text-purple-600">
                <i class="fas fa-briefcase w-5 mr-3"></i>
                <span>Portfolio Settings</span>
            </a>
            
            <a href="#" data-tab="proposals" class="settings-tab flex items-center text-gray-700 hover:text-purple-600">
                <i class="fas fa-paper-plane w-5 mr-3"></i>
                <span>Proposal Settings</span>
            </a>
            
            <a href="#" data-tab="payment" class="settings-tab flex items-center text-gray-700 hover:text-purple-600">
                <i class="fas fa-credit-card w-5 mr-3"></i>
                <span>Payment & Taxes</span>
            </a>
            
            <a href="#" data-tab="notifications" class="settings-tab flex items-center text-gray-700 hover:text-purple-600">
                <i class="fas fa-bell w-5 mr-3"></i>
                <span>Notifications</span>
            </a>
            
            <a href="#" data-tab="privacy" class="settings-tab flex items-center text-gray-700 hover:text-purple-600">
                <i class="fas fa-shield-alt w-5 mr-3"></i>
                <span>Privacy & Security</span>
            </a>
            
            <div class="border-t my-4"></div>
            
            <a href="#" data-tab="danger" class="settings-tab flex items-center text-red-600 hover:text-red-700">
                <i class="fas fa-exclamation-triangle w-5 mr-3"></i>
                <span>Danger Zone</span>
            </a>
        </div>
        
        <!-- Profile Completeness -->
        <div class="mt-8 p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg border border-purple-200">
            <h4 class="font-medium text-purple-800 mb-2">Profile Strength</h4>
            <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full" 
                     style="width: '{{ auth()->user()->getProfileCompletenessPercentageRoleBased() }}%'"></div>
            </div>
            <p class="text-sm text-purple-700">{{ auth()->user()->getProfileCompletenessPercentageRoleBased() }}% Complete</p>
            <a href="{{ route('profile.edit') }}" class="text-sm text-purple-600 hover:text-purple-700 mt-2 block">
                Complete Profile →
            </a>
        </div>
    </div>
</aside>