<aside class="settings-sidebar">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h2 class="text-xl font-bold mb-6" style="color: #1B3C53;">Settings</h2>
        
        <div class="space-y-1">
            <a href="#" data-tab="account" class="settings-tab flex items-center text-gray-700 hover:text-blue-700 active" style="--hover-color: #234C6A;">
                <i class="fas fa-user-circle w-5 mr-3"></i>
                <span>Account</span>
            </a>
            
            <a href="#" data-tab="company" class="settings-tab flex items-center text-gray-700 hover:text-blue-700">
                <i class="fas fa-building w-5 mr-3"></i>
                <span>Company Profile</span>
            </a>
            
            <a href="#" data-tab="jobs" class="settings-tab flex items-center text-gray-700 hover:text-blue-700">
                <i class="fas fa-tasks w-5 mr-3"></i>
                <span>Job Posting</span>
            </a>
            
            <a href="#" data-tab="hiring" class="settings-tab flex items-center text-gray-700 hover:text-blue-700">
                <i class="fas fa-user-check w-5 mr-3"></i>
                <span>Hiring Preferences</span>
            </a>
            
            <a href="#" data-tab="payment" class="settings-tab flex items-center text-gray-700 hover:text-blue-700">
                <i class="fas fa-credit-card w-5 mr-3"></i>
                <span>Payment & Billing</span>
            </a>
            
            @if(auth()->user()->company && auth()->user()->company_has_team)
            <a href="#" data-tab="team" class="settings-tab flex items-center text-gray-700 hover:text-blue-700">
                <i class="fas fa-users w-5 mr-3"></i>
                <span>Team Management</span>
            </a>
            @endif
            
            <a href="#" data-tab="notifications" class="settings-tab flex items-center text-gray-700 hover:text-blue-700">
                <i class="fas fa-bell w-5 mr-3"></i>
                <span>Notifications</span>
            </a>
            
            <a href="#" data-tab="privacy" class="settings-tab flex items-center text-gray-700 hover:text-blue-700">
                <i class="fas fa-shield-alt w-5 mr-3"></i>
                <span>Privacy & Security</span>
            </a>
            
            <div class="border-t my-4"></div>
            
            <a href="#" data-tab="danger" class="settings-tab flex items-center text-red-600 hover:text-red-700">
                <i class="fas fa-exclamation-triangle w-5 mr-3"></i>
                <span>Danger Zone</span>
            </a>
        </div>
        
        <!-- Quick Stats -->
        <div class="mt-8 p-4 rounded-lg border" style="background-color: #E3E3E3; border-color: #456882;">
            <h4 class="font-medium mb-2" style="color: #1B3C53;">Account Summary</h4>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm" style="color: #234C6A;">Active Jobs:</span>
                    <span class="text-sm font-medium" style="color: #1B3C53;">{{ auth()->user()->jobsPosted()->where('status', 'active')->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm" style="color: #234C6A;">Total Spent:</span>
                    <span class="text-sm font-medium" style="color: #1B3C53;">${{ number_format(auth()->user()->getTotalSpentAttribute(), 0) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm" style="color: #234C6A;">Freelancers Hired:</span>
                    <span class="text-sm font-medium" style="color: #1B3C53;">{{ auth()->user()->jobsPosted()->whereHas('proposals', function($q) {
                        $q->where('status', 'accepted');
                    })->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</aside>