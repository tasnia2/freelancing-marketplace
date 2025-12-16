<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    Messages
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Communicate with freelancers and clients
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="relative" x-data="{ showSearch: false }">
                    <button @click="showSearch = !showSearch"
                            class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center space-x-2">
                        <i class="fas fa-search text-[#456882]"></i>
                        <span>Search</span>
                    </button>
                    <div x-show="showSearch" @click.away="showSearch = false" 
                         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-4 z-50">
                        <input type="text" 
                               id="searchUsers"
                               placeholder="Search users by name..."
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white">
                        <div id="searchResults" class="mt-2 max-h-60 overflow-y-auto"></div>
                    </div>
                </div>
                
                <button onclick="startNewConversation()"
                        class="px-4 py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>New Message</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- Conversations Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden h-[calc(100vh-12rem)]">
                        <!-- Conversations Header -->
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-800 dark:text-white">Conversations</h3>
                            <div class="flex space-x-2 mt-2">
                                <button onclick="filterConversations('all')" 
                                        class="flex-1 px-3 py-1 text-sm rounded-lg bg-[#1B3C53] text-white">
                                    All
                                </button>
                                <button onclick="filterConversations('unread')" 
                                        class="flex-1 px-3 py-1 text-sm rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Unread
                                </button>
                            </div>
                        </div>
                        
                        <!-- Conversations List -->
                        <div class="overflow-y-auto h-[calc(100%-4rem)]" id="conversationsList">
                            @forelse($conversations as $conversation)
                            <a href="{{ route('client.messages.show', $conversation['user']) }}" 
                               class="block p-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ request()->segment(3) == $conversation['user']->id ? 'bg-gray-50 dark:bg-gray-700/50' : '' }}">
                                <div class="flex items-start">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white font-bold">
                                            {{ substr($conversation['user']->name, 0, 1) }}
                                        </div>
                                        @if($conversation['unread_count'] > 0)
                                        <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                            {{ $conversation['unread_count'] }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="ml-3 flex-1 min-w-0">
                                        <div class="flex justify-between items-start">
                                            <h4 class="font-medium text-gray-800 dark:text-white truncate">
                                                {{ $conversation['user']->name }}
                                            </h4>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $conversation['last_message'] ? $conversation['last_message']->created_at->diffForHumans() : '' }}
                                            </span>
                                        </div>
                                        @if($conversation['last_message'])
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate mt-1">
                                            @if($conversation['last_message']->sender_id == auth()->id())
                                            <span class="text-gray-500">You: </span>
                                            @endif
                                            {{ Str::limit($conversation['last_message']->message, 40) }}
                                        </p>
                                        @endif
                                        <div class="flex items-center mt-1">
                                            <span class="px-2 py-1 rounded-full text-xs 
                                                {{ $conversation['user']->role === 'freelancer' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 
                                                   'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' }}">
                                                {{ ucfirst($conversation['user']->role) }}
                                            </span>
                                            @if($conversation['unread_count'] > 0)
                                            <span class="ml-2 text-xs text-blue-600 dark:text-blue-400">
                                                {{ $conversation['unread_count'] }} new
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="p-8 text-center">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-comments text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400">No conversations yet</p>
                                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Start by messaging a freelancer</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Active Projects -->
                    <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-4">
                        <h4 class="font-semibold text-gray-800 dark:text-white mb-3">Active Projects</h4>
                        <div class="space-y-3">
                            @foreach($activeJobs as $job)
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="font-medium text-gray-800 dark:text-white text-sm">
                                    {{ Str::limit($job->title, 25) }}
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $job->proposals_count }} proposals
                                    </span>
                                    <a href="{{ route('jobs.show', $job) }}" class="text-xs text-[#456882] hover:text-[#1B3C53]">
                                        View
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Chat Area -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden h-[calc(100vh-12rem)]">
                        <!-- Chat Header -->
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <div id="chatHeader">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white font-bold mr-3">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 dark:text-white">Select a conversation</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Click on a conversation to start chatting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Chat Messages -->
                        <div class="h-[calc(100%-8rem)] overflow-y-auto p-4" id="messagesContainer">
                            <div class="flex items-center justify-center h-full">
                                <div class="text-center">
                                    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-r from-[#E3E3E3] to-gray-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                                        <i class="fas fa-comment-alt text-4xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">No conversation selected</h3>
                                    <p class="text-gray-600 dark:text-gray-400">Select a conversation from the list to view messages</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Message Input -->
                        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                            <div id="messageInput" class="hidden">
                                <form id="sendMessageForm" class="space-y-3">
                                    @csrf
                                    <div class="flex space-x-3">
                                        <div class="flex-1">
                                            <div class="relative">
                                                <input type="text" 
                                                       id="messageInputField"
                                                       placeholder="Type your message..."
                                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white pr-12">
                                                <div class="absolute right-2 top-2 flex space-x-2">
                                                    <button type="button" 
                                                            onclick="toggleAttachment()"
                                                            class="p-2 text-gray-500 hover:text-[#456882] dark:text-gray-400 dark:hover:text-white">
                                                        <i class="fas fa-paperclip"></i>
                                                    </button>
                                                    <button type="button" 
                                                            onclick="sendMessage()"
                                                            class="p-2 bg-[#234C6A] text-white rounded-lg hover:bg-[#1B3C53]">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="attachmentPanel" class="mt-2 hidden">
                                                <div class="flex items-center space-x-3">
                                                    <select id="attachJob" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                                                        <option value="">Attach to Job</option>
                                                        @foreach($activeJobs as $job)
                                                        <option value="{{ $job->id }}">{{ Str::limit($job->title, 25) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <select id="attachContract" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                                                        <option value="">Attach to Contract</option>
                                                        @foreach($activeContracts as $contract)
                                                        <option value="{{ $contract->id }}">{{ Str::limit($contract->title, 25) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="file" 
                                                           id="fileAttachment"
                                                           class="hidden"
                                                           multiple
                                                           accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                                                    <button type="button" 
                                                            onclick="document.getElementById('fileAttachment').click()"
                                                            class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-sm">
                                                        <i class="fas fa-paperclip mr-1"></i>Files
                                                    </button>
                                                </div>
                                                <div id="fileList" class="mt-2 space-y-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-lock mr-1"></i>
                                        Messages are encrypted and secure
                                    </div>
                                </form>
                            </div>
                            <div id="noConversationMessage" class="text-center text-gray-500 dark:text-gray-400">
                                Select a conversation to start messaging
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentChatUserId = null;
        let messagePolling = null;
        
        document.addEventListener('DOMContentLoaded', function() {
            // Real-time message polling
            function pollMessages() {
                if (currentChatUserId) {
                    fetch(`/client/messages/${currentChatUserId}?ajax=1`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.html) {
                                document.getElementById('messagesContainer').innerHTML = data.html;
                                scrollToBottom();
                            }
                        });
                }
            }
            
            // Start polling when chat is open
            function startPolling() {
                if (messagePolling) clearInterval(messagePolling);
                messagePolling = setInterval(pollMessages, 3000);
            }
            
            // Stop polling when leaving chat
            function stopPolling() {
                if (messagePolling) {
                    clearInterval(messagePolling);
                    messagePolling = null;
                }
            }
            
            // Load chat when clicking on conversation
            window.loadChat = function(userId, userName, userRole) {
                currentChatUserId = userId;
                
                // Update header
                document.getElementById('chatHeader').innerHTML = `
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white font-bold mr-3">
                            ${userName.charAt(0)}
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 dark:text-white">${userName}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">${userRole}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="markAllAsRead(${userId})" 
                                class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                            Mark as read
                        </button>
                        <a href="/client/freelancers/${userId}" 
                           class="px-3 py-1 text-sm bg-[#234C6A] text-white rounded-lg hover:bg-[#1B3C53]">
                            View Profile
                        </a>
                    </div>
                `;
                
                // Show message input
                document.getElementById('messageInput').classList.remove('hidden');
                document.getElementById('noConversationMessage').classList.add('hidden');
                
                // Load messages
                fetch(`/client/messages/${userId}?ajax=1`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            document.getElementById('messagesContainer').innerHTML = data.html;
                            scrollToBottom();
                            startPolling();
                        }
                    });
                
                // Mark as read
                markAllAsRead(userId);
            };
            
            // Filter conversations
            window.filterConversations = function(filter) {
                const conversations = document.querySelectorAll('#conversationsList > a');
                conversations.forEach(conv => {
                    if (filter === 'all') {
                        conv.classList.remove('hidden');
                    } else if (filter === 'unread') {
                        const hasUnread = conv.querySelector('.bg-red-500');
                        conv.classList.toggle('hidden', !hasUnread);
                    }
                });
            };
            
            // Search users
            document.getElementById('searchUsers').addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase();
                if (query.length > 2) {
                    fetch(`/api/users/search?q=${query}`)
                        .then(response => response.json())
                        .then(users => {
                            const resultsDiv = document.getElementById('searchResults');
                            resultsDiv.innerHTML = users.map(user => `
                                <div class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg cursor-pointer"
                                     onclick="startChatWith(${user.id}, '${user.name}', '${user.role}')">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white text-sm mr-2">
                                            ${user.name.charAt(0)}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800 dark:text-white">${user.name}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 capitalize">${user.role}</div>
                                        </div>
                                    </div>
                                </div>
                            `).join('');
                        });
                }
            });
            
            // Auto-refresh conversations list
            setInterval(() => {
                fetch('/client/messages/api/conversations')
                    .then(response => response.json())
                    .then(data => {
                        // Update unread counts
                        data.conversations.forEach(convo => {
                            const convElement = document.querySelector(`a[href*="${convo.user.id}"]`);
                            if (convElement) {
                                const unreadBadge = convElement.querySelector('.bg-red-500');
                                if (convo.unread_count > 0) {
                                    if (!unreadBadge) {
                                        const badge = document.createElement('div');
                                        badge.className = 'absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center';
                                        badge.textContent = convo.unread_count;
                                        convElement.querySelector('.relative').appendChild(badge);
                                    } else {
                                        unreadBadge.textContent = convo.unread_count;
                                    }
                                } else if (unreadBadge) {
                                    unreadBadge.remove();
                                }
                            }
                        });
                    });
            }, 10000);
            
            // Scroll to bottom of messages
            function scrollToBottom() {
                const container = document.getElementById('messagesContainer');
                container.scrollTop = container.scrollHeight;
            }
            
            // Handle enter key in message input
            document.getElementById('messageInputField').addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
        });
        
        // Send message
        function sendMessage() {
            const message = document.getElementById('messageInputField').value.trim();
            if (!message || !currentChatUserId) return;
            
            const formData = new FormData();
            formData.append('message', message);
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            
            const jobId = document.getElementById('attachJob').value;
            const contractId = document.getElementById('attachContract').value;
            if (jobId) formData.append('job_id', jobId);
            if (contractId) formData.append('contract_id', contractId);
            
            // Add file attachments
            const fileInput = document.getElementById('fileAttachment');
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append('attachments[]', fileInput.files[i]);
            }
            
            fetch(`/client/messages/${currentChatUserId}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('messageInputField').value = '';
                    document.getElementById('fileList').innerHTML = '';
                    pollMessages();
                }
            });
        }
        
        // Mark all as read
        function markAllAsRead(userId = null) {
            const url = userId ? `/client/messages/${userId}/mark-read` : '/client/messages/mark-read-all';
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    if (userId) {
                        const badges = document.querySelectorAll(`a[href*="${userId}"] .bg-red-500`);
                        badges.forEach(badge => badge.remove());
                    } else {
                        document.querySelectorAll('.bg-red-500').forEach(badge => badge.remove());
                    }
                }
            });
        }
        
        // Toggle attachment panel
        function toggleAttachment() {
            const panel = document.getElementById('attachmentPanel');
            panel.classList.toggle('hidden');
        }
        
        // Handle file attachments
        document.getElementById('fileAttachment').addEventListener('change', function(e) {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = '';
            
            for (let file of e.target.files) {
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded-lg';
                fileItem.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-file text-[#456882] mr-2"></i>
                        <span class="text-sm text-gray-800 dark:text-white truncate max-w-xs">${file.name}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                fileList.appendChild(fileItem);
            }
        });
        
        // Start new conversation
        function startNewConversation() {
            // Show modal or search interface
            alert('Feature: Start new conversation - Search for users to message');
        }
        
        // Start chat with user from search
        function startChatWith(userId, userName, userRole) {
            loadChat(userId, userName, userRole);
            document.querySelector('[x-data="{ showSearch: false }"]').click();
        }
    </script>
    @endpush

    @push('styles')
    <style>
        #messagesContainer {
            scroll-behavior: smooth;
        }
        
        .message-bubble {
            max-width: 70%;
            word-wrap: break-word;
        }
        
        .message-bubble.sent {
            background: linear-gradient(135deg, #1B3C53, #234C6A);
            color: white;
            border-radius: 18px 18px 4px 18px;
            margin-left: auto;
        }
        
        .message-bubble.received {
            background: #f3f4f6;
            color: #374151;
            border-radius: 18px 18px 18px 4px;
            margin-right: auto;
        }
        
        .dark .message-bubble.received {
            background: #374151;
            color: #f3f4f6;
        }
        
        .typing-indicator {
            display: flex;
            align-items: center;
        }
        
        .typing-indicator span {
            height: 8px;
            width: 8px;
            background: #9ca3af;
            border-radius: 50%;
            margin: 0 2px;
            animation: typing 1.4s infinite;
        }
        
        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes typing {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-10px); }
        }
        
        .conversation-item.active {
            background: linear-gradient(135deg, rgba(27, 60, 83, 0.1), rgba(69, 104, 130, 0.1));
            border-left: 4px solid #456882;
        }
        
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .dark .scrollbar-thin::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
    </style>
    @endpush
</x-app-layout>