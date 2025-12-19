<div class="bg-white rounded-lg shadow-sm border p-6">
    <h3 class="font-bold text-gray-900 mb-4">Settings Menu</h3>
    
    <div class="space-y-1">
        @if(auth()->user()->isFreelancer())
            <!-- Freelancer Tabs -->
            <a href="#" data-tab="account" 
               class="block px-4 py-2 rounded border text-purple-700 bg-purple-50 border-purple-500">
                <i class="fas fa-user-circle mr-2"></i> Account
            </a>
            <a href="#" data-tab="profile" 
               class="block px-4 py-2 rounded border text-gray-700 hover:bg-gray-50">
                <i class="fas fa-id-card mr-2"></i> Profile & Skills
            </a>
            <a href="#" data-tab="availability" 
               class="block px-4 py-2 rounded border text-gray-700 hover:bg-gray-50">
                <i class="fas fa-calendar-alt mr-2"></i> Availability & Rates
            </a>
            <a href="#" data-tab="notifications" 
               class="block px-4 py-2 rounded border text-gray-700 hover:bg-gray-50">
                <i class="fas fa-bell mr-2"></i> Notifications
            </a>
            <a href="#" data-tab="privacy" 
               class="block px-4 py-2 rounded border text-gray-700 hover:bg-gray-50">
                <i class="fas fa-shield-alt mr-2"></i> Privacy & Security
            </a>
        @else
            <!-- Client Tabs -->
            <a href="#" data-tab="account" 
               class="block px-4 py-2 rounded border text-white" style="background-color: #1B3C53; border-color: #234C6A;">
                <i class="fas fa-user-circle mr-2"></i> Account
            </a>
            <a href="#" data-tab="company" 
               class="block px-4 py-2 rounded border text-gray-700 hover:bg-gray-50" style="border-color: #E3E3E3;">
                <i class="fas fa-building mr-2"></i> Company Profile
            </a>
            <a href="#" data-tab="jobs" 
               class="block px-4 py-2 rounded border text-gray-700 hover:bg-gray-50" style="border-color: #E3E3E3;">
                <i class="fas fa-tasks mr-2"></i> Job Posting
            </a>
            <a href="#" data-tab="notifications" 
               class="block px-4 py-2 rounded border text-gray-700 hover:bg-gray-50" style="border-color: #E3E3E3;">
                <i class="fas fa-bell mr-2"></i> Notifications
            </a>
            <a href="#" data-tab="privacy" 
               class="block px-4 py-2 rounded border text-gray-700 hover:bg-gray-50" style="border-color: #E3E3E3;">
                <i class="fas fa-shield-alt mr-2"></i> Privacy & Security
            </a>
        @endif
    </div>
</div>