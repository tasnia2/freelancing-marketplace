<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with {{ $user->name }} - WorkNest</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        :root {
            /* Purple Color Palette */
            --purple-dark: #6B21A8;
            --purple-medium: #7C3AED;
            --purple-light: #8B5CF6;
            --purple-ultra-light: #A78BFA;
            --purple-pastel: #DDD6FE;
            --purple-bg: #FAF5FF;
            --neutral-light: #F3F4F6;
            --white: #ffffff;
            --gray-light: #f8f9fa;
            --gray-medium: #6c757d;
            --success: #10B981;
            --danger: #EF4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--purple-bg) 0%, var(--neutral-light) 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .messages-container {
            min-height: calc(100vh - 40px);
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(123, 97, 255, 0.15);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header */
        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            background: linear-gradient(135deg, var(--purple-medium) 0%, var(--purple-dark) 100%);
            color: white;
            border-bottom: 1px solid var(--purple-pastel);
        }

        .back-button {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 15px;
            text-decoration: none;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-3px);
        }

        .user-info {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .user-avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple-light), var(--purple-medium));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: bold;
            margin-right: 15px;
            border: 3px solid var(--purple-pastel);
        }

        .user-details h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .user-details p {
            font-size: 14px;
            color: var(--purple-pastel);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .shared-jobs-btn {
            background: white;
            color: var(--purple-medium);
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(123, 97, 255, 0.2);
        }

        .shared-jobs-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(123, 97, 255, 0.3);
        }

        /* Messages Area */
        .messages-area {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 200px);
        }

        .messages-list {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
            background: var(--purple-bg);
        }

        .message-item {
            margin-bottom: 20px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message-sent {
            display: flex;
            justify-content: flex-end;
        }

        .message-received {
            display: flex;
            justify-content: flex-start;
        }

        .message-bubble {
            max-width: 70%;
            padding: 14px 18px;
            border-radius: 20px;
            position: relative;
            word-wrap: break-word;
        }

        .message-bubble.sent {
            background: linear-gradient(135deg, var(--purple-medium), var(--purple-dark));
            color: white;
            border-bottom-right-radius: 6px;
        }

        .message-bubble.received {
            background: white;
            color: var(--purple-dark);
            border: 1px solid var(--purple-pastel);
            border-bottom-left-radius: 6px;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.1);
        }

        .message-text {
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .message-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
        }

        .message-time {
            opacity: 0.8;
        }

        .message-time.received {
            color: var(--purple-medium);
        }

        .message-time.sent {
            color: rgba(255, 255, 255, 0.8);
        }

        .message-read {
            margin-left: 8px;
            color: var(--success);
        }

        .message-sender {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
            font-size: 13px;
            color: var(--purple-medium);
            font-weight: 500;
        }

        .sender-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple-light), var(--purple-medium));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
            margin-right: 8px;
        }

        /* Message Input */
        .message-input-area {
            padding: 25px;
            background: white;
            border-top: 1px solid var(--purple-pastel);
        }

        .message-form {
            display: flex;
            gap: 15px;
        }

        .message-input-wrapper {
            flex: 1;
            position: relative;
        }

        .message-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid var(--purple-pastel);
            border-radius: 16px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: var(--purple-bg);
            color: var(--purple-dark);
            resize: none;
            min-height: 56px;
            max-height: 120px;
        }

        .message-input:focus {
            outline: none;
            border-color: var(--purple-light);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
            background: white;
        }

        .send-btn {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 18px;
            background: linear-gradient(135deg, var(--purple-medium), var(--purple-dark));
            color: white;
            box-shadow: 0 6px 20px rgba(123, 97, 255, 0.3);
        }

        .send-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(123, 97, 255, 0.4);
        }

        .send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            top: 30px;
            right: 30px;
            padding: 16px 24px;
            border-radius: 12px;
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 1000;
            animation: slideInRight 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .toast.success {
            background: var(--success);
        }

        .toast.error {
            background: var(--danger);
        }

        .toast.warning {
            background: #F59E0B;
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Scrollbar Styling */
        .messages-list::-webkit-scrollbar {
            width: 8px;
        }

        .messages-list::-webkit-scrollbar-track {
            background: var(--purple-pastel);
            border-radius: 10px;
        }

        .messages-list::-webkit-scrollbar-thumb {
            background: var(--purple-light);
            border-radius: 10px;
        }

        .messages-list::-webkit-scrollbar-thumb:hover {
            background: var(--purple-medium);
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .messages-container {
                border-radius: 16px;
            }
            
            .chat-header {
                padding: 20px;
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .message-bubble {
                max-width: 85%;
            }
        }
    </style>
</head>
<body>
    <div class="messages-container">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="user-info">
                <a href="{{ route('messages.index') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                </a>
                
                <div class="user-avatar">
                    {{ substr($user->name, 0, 1) }}
                </div>
                
                <div class="user-details">
                    <h2>{{ $user->name }}</h2>
                    <p>
                        <span class="role-badge">
                            {{ $user->isClient() ? 'Client' : 'Freelancer' }}
                        </span>
                        <span>
                            @if($user->isClient())
                                {{ $user->company ?? 'No company' }}
                            @else
                                {{ $user->title ?? 'No title' }}
                            @endif
                        </span>
                    </p>
                </div>
            </div>
            
            @if($sharedJobs->count() > 0)
            <button class="shared-jobs-btn" onclick="toggleSharedJobs()">
                <i class="fas fa-briefcase"></i>
                Shared Jobs ({{ $sharedJobs->count() }})
            </button>
            @endif
        </div>

        <!-- Messages List -->
        <div class="messages-area">
            <div class="messages-list" id="messages-list">
                @foreach($messages as $message)
                @php
                    $isSent = $message->sender_id == Auth::id();
                @endphp
                <div class="message-item {{ $isSent ? 'message-sent' : 'message-received' }}">
                    @if(!$isSent)
                    <div class="message-sender">
                        <div class="sender-avatar">
                            {{ substr($message->sender->name, 0, 1) }}
                        </div>
                        {{ $message->sender->name }}
                    </div>
                    @endif
                    
                    <div class="message-bubble {{ $isSent ? 'sent' : 'received' }}">
                        <div class="message-text">{{ $message->message }}</div>
                        
                        <div class="message-meta">
                            <span class="message-time {{ $isSent ? 'sent' : 'received' }}">
                                {{ $message->created_at->format('h:i A') }}
                            </span>
                            
                            @if($isSent && $message->read)
                            <span class="message-read">
                                <i class="fas fa-check-double"></i>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="message-input-area">
                <form method="POST" action="{{ route('messages.store', $user) }}" class="message-form" id="message-form">
                    @csrf
                    
                    <div class="message-input-wrapper">
                        <textarea name="message" 
                                  placeholder="Type your message here..." 
                                  class="message-input" 
                                  id="message-input" 
                                  rows="1"></textarea>
                    </div>
                    
                    <button type="submit" class="send-btn" id="send-button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container"></div>

   <script>
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
const currentUserId = parseInt('{{ Auth::id() ?? 0 }}');
const recipientId = parseInt('{{ $user->id ?? 0 }}');
    
    // Debug
    console.log('Current User:', currentUserId);
    console.log('Recipient:', recipientId);
    
    // Check authentication on page load
    if (!currentUserId || currentUserId === 0) {
        console.error('User not authenticated');
        showToast('Please login to continue', 'error');
        setTimeout(() => {
            window.location.href = '/login';
        }, 1500);
    }
    
    // Format time function - FIXED
    function formatTime(dateString) {
        if (!dateString) return 'Just now';
        
        try {
            const date = new Date(dateString);
            if (isNaN(date.getTime())) {
                return 'Just now';
            }
            
            const now = new Date();
            const diffMs = now - date;
            const diffMins = Math.floor(diffMs / 60000);
            
            if (diffMins < 1) return 'Just now';
            if (diffMins < 60) return `${diffMins}m ago`;
            
            const diffHours = Math.floor(diffMins / 60);
            if (diffHours < 24) return `${diffHours}h ago`;
            
            // Return formatted time
            return date.toLocaleTimeString([], { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            });
        } catch (e) {
            return 'Just now';
        }
    }
    
    // Load existing messages on page load
 async function loadExistingMessages() {
    console.log('Loading messages for user:', recipientId);
    
    const messagesList = document.getElementById('messages-list');
    const loadingElement = document.getElementById('loading-messages');
    
    if (!messagesList) {
        console.error('Messages list element not found!');
        return;
    }
    
    try {
        // Show loading
        if (loadingElement) {
            loadingElement.style.display = 'block';
        }
        
        // Use the API endpoint
        const response = await fetch(`/messages/api/with/${recipientId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        
        const data = await response.json();
        console.log('API Response:', data);
        
        // Hide loading
        if (loadingElement) {
            loadingElement.style.display = 'none';
        }
        
        // Clear existing messages (but keep loading element if it exists)
        if (loadingElement) {
            messagesList.innerHTML = '';
            messagesList.appendChild(loadingElement);
            loadingElement.style.display = 'none';
        } else {
            messagesList.innerHTML = '';
        }
        
        if (data.success && data.messages && data.messages.length > 0) {
            console.log(`Found ${data.messages.length} messages`);
            
            // Add each message
            data.messages.forEach(message => {
                addMessageToUI(message);
            });
            
            // Scroll to bottom
            scrollToBottom();
        } else {
            console.log('No messages found or empty response');
            messagesList.innerHTML = `
                <div class="no-messages" style="text-align: center; padding: 40px; color: var(--dark-grey-light);">
                    <i class="fas fa-comments fa-3x" style="opacity: 0.5; margin-bottom: 15px;"></i>
                    <h3 style="margin-bottom: 10px;">No messages yet</h3>
                    <p>Start the conversation!</p>
                </div>
            `;
        }
        
    } catch (error) {
        console.error('Error loading messages:', error);
        
        // Hide loading
        if (loadingElement) {
            loadingElement.style.display = 'none';
        }
        
        messagesList.innerHTML = `
            <div class="error-messages" style="text-align: center; padding: 40px; color: var(--danger);">
                <i class="fas fa-exclamation-triangle fa-3x" style="margin-bottom: 15px;"></i>
                <h3 style="margin-bottom: 10px;">Failed to load messages</h3>
                <p>Please try again</p>
                <small>Error: ${error.message}</small>
            </div>
        `;
    }
}
    
    // Universal function to add message to UI (works for both existing and new)
    function addMessageToUI(messageData) {
        const messagesList = document.getElementById('messages-list');
        if (!messagesList) return;
        
        // Determine if message is sent by current user
        // Handle both data structures:
        // 1. From API: messageData.sender_id
        // 2. From send response: messageData.sender.id
        const senderId = messageData.sender_id || (messageData.sender ? messageData.sender.id : null);
        const isSent = senderId == currentUserId;
        
        // Get sender name
        let senderName = '';
        if (messageData.sender_name) {
            senderName = messageData.sender_name;
        } else if (messageData.sender && messageData.sender.name) {
            senderName = messageData.sender.name;
        } else {
            senderName = isSent ? 'You' : 'User';
        }
        
        // Create message element
        const messageElement = document.createElement('div');
        messageElement.className = `message-item ${isSent ? 'message-sent' : 'message-received'}`;
        
        // Build HTML
        let html = '';
        
        // Show sender info for received messages
        if (!isSent) {
            html += `
                <div class="message-sender">
                    <div class="sender-avatar">
                        ${senderName.charAt(0).toUpperCase()}
                    </div>
                    ${senderName}
                </div>
            `;
        }
        
        // Message bubble
        const messageTime = messageData.formatted_time || 
                           formatTime(messageData.created_at) || 
                           'Just now';
        
        html += `
            <div class="message-bubble ${isSent ? 'sent' : 'received'}">
                <div class="message-text">${escapeHtml(messageData.message)}</div>
                <div class="message-meta">
                    <span class="message-time ${isSent ? 'sent' : 'received'}">
                        ${messageTime}
                    </span>
                </div>
            </div>
        `;
        
        messageElement.innerHTML = html;
        messagesList.appendChild(messageElement);
    }
    
    // Helper: Escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Scroll to bottom
    function scrollToBottom() {
        const messagesList = document.getElementById('messages-list');
        if (messagesList) {
            messagesList.scrollTop = messagesList.scrollHeight;
        }
    }
    
    // Setup message form - UPDATED
    function setupMessageForm() {
        const form = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');
        
        if (!form || !messageInput || !sendButton) {
            console.error('Message form elements not found!');
            return;
        }
        
        // Auto-resize textarea
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            const newHeight = Math.min(this.scrollHeight, 120);
            this.style.height = newHeight + 'px';
        });
        
        // Auto-focus
        messageInput.focus();
        
        // Form submission
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            if (!message) {
                showToast('Please enter a message', 'warning');
                return;
            }
            
            if (!currentUserId || currentUserId === 0) {
                showToast('Your session has expired. Please login again.', 'error');
                setTimeout(() => window.location.href = '/login', 1500);
                return;
            }
            
            // Disable button
            sendButton.disabled = true;
            const originalText = sendButton.innerHTML;
            sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            
            try {
                const formData = new FormData();
                formData.append('message', message);
                formData.append('_token', csrfToken);
                
                const response = await fetch(`/messages/${recipientId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const contentType = response.headers.get('content-type');
                let data;
                
                if (contentType && contentType.includes('application/json')) {
                    data = await response.json();
                } else {
                    const text = await response.text();
                    throw new Error('Invalid response format: ' + text.substring(0, 100));
                }
                
                if (data.success) {
                    // Clear input
                    messageInput.value = '';
                    messageInput.style.height = 'auto';
                    
                    // Add message to UI
                    if (data.message) {
                        addMessageToUI(data.message);
                        scrollToBottom();
                    }
                    
                    showToast('Message sent!', 'success');
                } else {
                    throw new Error(data.error || 'Failed to send message');
                }
                
            } catch (error) {
                console.error('Send error:', error);
                showToast('Error: ' + error.message, 'error');
            } finally {
                // Re-enable button
                sendButton.disabled = false;
                sendButton.innerHTML = originalText;
            }
        });
    }
    
    // Toast function
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) {
            console.warn('Toast container not found');
            return;
        }
        
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        let icon = 'check-circle';
        if (type === 'error') icon = 'exclamation-circle';
        if (type === 'warning') icon = 'exclamation-triangle';
        
        toast.innerHTML = `
            <i class="fas fa-${icon}"></i>
            <span>${message}</span>
        `;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Initialize everything
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing chat...');
        setupMessageForm();
        loadExistingMessages(); // CRITICAL: Load existing messages
    });
    
    // Also add polling for new messages (optional)
    setInterval(() => {
        loadExistingMessages();
    }, 10000); // Check every 10 seconds
</script>
</body>
</html>