<div x-data="{ open: false, unreadCount: {{ auth()->user()->unreadNotifications()->count() ?? 0 }} }" 
     class="relative">
    
    <button @click="open = !open" 
            class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
        <i class="fas fa-bell text-xl"></i>
        <span x-show="unreadCount > 0" 
              class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center"
              x-text="unreadCount"></span>
    </button>
    
    <!-- Notification Dropdown -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 z-50 max-h-96 overflow-y-auto">
        
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-800 dark:text-white">Notifications</h3>
        </div>
        
        <div id="notificationsList">
            @php
                // Simple notifications array for now
                $notifications = auth()->user()->notifications ?? collect();
                $recentNotifications = $notifications->take(5);
            @endphp
            
            @forelse($recentNotifications as $notification)
            <div class="p-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                <div class="flex items-start">
                    <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-3">
                        <i class="fas fa-bell text-blue-500 dark:text-blue-300"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-800 dark:text-white">
                            {{ $notification->title ?? 'New Notification' }}
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ $notification->message ?? 'You have a new notification' }}
                        </p>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $notification->created_at->diffForHumans() ?? 'Just now' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <i class="fas fa-bell-slash text-3xl text-gray-300 dark:text-gray-600 mb-3"></i>
                <p class="text-gray-500 dark:text-gray-400">No notifications yet</p>
            </div>
            @endforelse
        </div>
        
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <a href="#"
               class="block text-center text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white">
                View all notifications
            </a>
        </div>
    </div>
</div>