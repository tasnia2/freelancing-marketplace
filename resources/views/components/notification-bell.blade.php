<div x-data="{ open: false, unreadCount: {{ auth()->user()->unreadNotificationsCount() }} }" 
     class="relative"
     x-init="
        // Listen for new notifications
        Echo.private('notifications.{{ auth()->id() }}')
            .listen('NotificationCreated', (e) => {
                unreadCount++;
                showNotification(e);
            });
     ">
    
    <button @click="open = !open; if(unreadCount > 0) { 
        fetch('/notifications/read-all', { method: 'POST' });
        unreadCount = 0; 
    }"
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
            @foreach(auth()->user()->notifications()->recent(5)->get() as $notification)
            <div class="p-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 
                        {{ !$notification->read ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                <div class="flex items-start">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 {{ $notification->color }}">
                        <i class="{{ $notification->icon }}"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-800 dark:text-white">{{ $notification->title }}</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $notification->message }}</p>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->time_ago }}</span>
                            @if(!$notification->read)
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <a href="#"
             class="block text-center text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white">

                View all notifications
            </a>
        </div>
    </div>
</div>

<script>
function showNotification(data) {
    // Create notification toast
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-gradient-to-r from-[#1B3C53] to-[#456882] text-white px-6 py-4 rounded-lg shadow-xl z-50 transform translate-x-full transition-transform duration-500 max-w-sm';
    toast.innerHTML = `
        <div class="flex items-start">
            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 ${data.color}">
                <i class="${data.icon}"></i>
            </div>
            <div class="flex-1">
                <div class="font-medium">${data.title}</div>
                <p class="text-sm opacity-90 mt-1">${data.message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
    }, 10);
    
    setTimeout(() => {
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 500);
    }, 5000);
}
</script>