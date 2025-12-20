<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - WorkNest</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        :root {
            /* Dark Grey Color Palette */
            --dark-grey-dark: #1B3C53;
            --dark-grey-medium: #234C6A;
            --dark-grey-light: #456882;
            --dark-grey-ultra-light: #E3E3E3;
            --dark-grey-bg: #F8FAFC;
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
            background: linear-gradient(135deg, var(--dark-grey-bg) 0%, var(--neutral-light) 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .messages-container {
            min-height: calc(100vh - 40px);
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(27, 60, 83, 0.15);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header */
        .messages-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            background: linear-gradient(135deg, var(--dark-grey-medium) 0%, var(--dark-grey-dark) 100%);
            color: white;
            animation: slideInDown 0.6s ease;
        }

        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .messages-header h1 {
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .messages-header h1 i {
            color: var(--dark-grey-ultra-light);
        }

        .new-message-btn {
            background: white;
            color: var(--dark-grey-medium);
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 20px rgba(27, 60, 83, 0.3);
        }

        .new-message-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(27, 60, 83, 0.4);
            background: var(--dark-grey-ultra-light);
        }

        /* Layout */
        .messages-layout {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 0;
            height: calc(100vh - 120px);
            animation: scaleIn 0.7s ease;
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.98); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Sidebar */
        .conversations-sidebar {
            background: var(--white);
            border-right: 1px solid var(--dark-grey-ultra-light);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .conversation-search {
            padding: 20px;
            border-bottom: 1px solid var(--dark-grey-ultra-light);
            position: relative;
        }

        .conversation-search i {
            position: absolute;
            left: 30px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-grey-light);
        }

        .conversation-search input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid var(--dark-grey-ultra-light);
            border-radius: 12px;
            background: var(--dark-grey-bg);
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .conversation-search input:focus {
            outline: none;
            border-color: var(--dark-grey-light);
            box-shadow: 0 0 0 3px rgba(69, 104, 130, 0.1);
        }

        .conversation-filters {
            padding: 15px 20px;
            display: flex;
            gap: 10px;
            border-bottom: 1px solid var(--dark-grey-ultra-light);
            background: var(--dark-grey-bg);
        }

        .filter-btn {
            padding: 8px 16px;
            border: 2px solid var(--dark-grey-ultra-light);
            background: white;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            color: var(--dark-grey-medium);
            font-weight: 500;
        }

        .filter-btn.active {
            background: var(--dark-grey-medium);
            color: white;
            border-color: var(--dark-grey-medium);
        }

        .filter-btn:hover:not(.active) {
            background: var(--dark-grey-ultra-light);
            border-color: var(--dark-grey-light);
        }

        .conversations-list {
            flex: 1;
            overflow-y: auto;
            padding: 0;
        }

        .conversation-item {
            display: flex;
            align-items: center;
            padding: 18px 20px;
            border-bottom: 1px solid var(--dark-grey-ultra-light);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            animation: fadeInItem 0.5s ease;
            animation-fill-mode: both;
            cursor: pointer;
        }

        @keyframes fadeInItem {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .conversation-item:nth-child(1) { animation-delay: 0.1s; }
        .conversation-item:nth-child(2) { animation-delay: 0.2s; }
        .conversation-item:nth-child(3) { animation-delay: 0.3s; }
        .conversation-item:nth-child(4) { animation-delay: 0.4s; }

        .conversation-item:hover {
            background: var(--dark-grey-bg);
            transform: translateX(5px);
            border-left: 4px solid var(--dark-grey-light);
        }

        .conversation-item.active {
            background: linear-gradient(90deg, rgba(35, 76, 106, 0.1) 0%, rgba(69, 104, 130, 0.05) 100%);
            border-left: 4px solid var(--dark-grey-medium);
        }

        .conversation-avatar {
            position: relative;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .conversation-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--dark-grey-ultra-light);
            background: var(--dark-grey-ultra-light);
        }

        .unread-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger);
            color: white;
            font-size: 11px;
            min-width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            padding: 0 4px;
            border: 2px solid white;
        }

        .conversation-details {
            flex: 1;
            min-width: 0;
        }

        .conversation-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 6px;
        }

        .conversation-name {
            font-weight: 600;
            color: var(--dark-grey-dark);
            margin: 0;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .conversation-time {
            font-size: 12px;
            color: var(--dark-grey-light);
            font-weight: 500;
            white-space: nowrap;
        }

        .conversation-preview {
            color: var(--gray-medium);
            font-size: 13px;
            margin: 0 0 6px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .client-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--success) 0%, #34D399 100%);
            color: white;
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .freelancer-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--dark-grey-light) 0%, var(--dark-grey-medium) 100%);
            color: white;
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .empty-conversations {
            text-align: center;
            padding: 60px 20px;
            color: var(--dark-grey-light);
        }

        .empty-conversations i {
            font-size: 48px;
            margin-bottom: 15px;
            color: var(--dark-grey-ultra-light);
        }

        .empty-conversations p {
            font-size: 16px;
            margin-bottom: 5px;
            color: var(--dark-grey-medium);
            font-weight: 500;
        }

        .empty-conversations small {
            font-size: 14px;
            color: var(--dark-grey-light);
        }

        /* Chat Area */
        .chat-area {
            display: flex;
            flex-direction: column;
            background: var(--white);
            position: relative;
        }

        .empty-chat-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 40px;
            text-align: center;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.9; }
        }

        .empty-chat-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--dark-grey-light), var(--dark-grey-medium));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            animation: float 3s ease-in-out infinite;
            box-shadow: 0 15px 35px rgba(27, 60, 83, 0.3);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .empty-chat-icon i {
            font-size: 48px;
            color: white;
        }

        .empty-chat-state h3 {
            color: var(--dark-grey-dark);
            font-size: 24px;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .empty-chat-state p {
            color: var(--dark-grey-light);
            margin-bottom: 30px;
            max-width: 400px;
            font-size: 16px;
            line-height: 1.5;
        }

        .start-chat-btn {
            background: linear-gradient(135deg, var(--dark-grey-medium), var(--dark-grey-dark));
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            box-shadow: 0 6px 20px rgba(27, 60, 83, 0.3);
        }

        .start-chat-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(27, 60, 83, 0.4);
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeInOverlay 0.3s ease;
            backdrop-filter: blur(5px);
        }

        @keyframes fadeInOverlay {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-container {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideUp 0.4s ease;
            box-shadow: 0 25px 50px rgba(27, 60, 83, 0.2);
            border: 1px solid var(--dark-grey-ultra-light);
        }

        @keyframes modalSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            padding: 25px 30px;
            border-bottom: 1px solid var(--dark-grey-ultra-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, var(--dark-grey-bg) 0%, white 100%);
        }

        .modal-header h3 {
            color: var(--dark-grey-dark);
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-header h3 i {
            color: var(--dark-grey-medium);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: var(--dark-grey-light);
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .modal-close:hover {
            color: var(--dark-grey-dark);
            background: var(--dark-grey-ultra-light);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: var(--dark-grey-dark);
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group label i {
            color: var(--dark-grey-light);
        }

        .form-control, .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--dark-grey-ultra-light);
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: var(--dark-grey-bg);
            color: var(--dark-grey-dark);
        }

        .form-control:focus, .form-group textarea:focus {
            outline: none;
            border-color: var(--dark-grey-light);
            box-shadow: 0 0 0 3px rgba(69, 104, 130, 0.1);
            background: white;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .attachment-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .modal-footer {
            padding: 25px 30px;
            border-top: 1px solid var(--dark-grey-ultra-light);
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            background: var(--dark-grey-bg);
        }

        .btn-secondary, .btn-primary {
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary {
            background: white;
            border: 2px solid var(--dark-grey-ultra-light);
            color: var(--dark-grey-medium);
        }

        .btn-secondary:hover {
            background: var(--dark-grey-ultra-light);
            border-color: var(--dark-grey-light);
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--dark-grey-medium), var(--dark-grey-dark));
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(35, 76, 106, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--dark-grey-dark), var(--dark-grey-medium));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(35, 76, 106, 0.4);
        }

        /* Message bubbles */
        .message-bubble {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            margin: 8px 0;
            position: relative;
        }

        .message-bubble.received {
            background: var(--dark-grey-ultra-light);
            color: var(--dark-grey-dark);
            border-bottom-left-radius: 4px;
            margin-right: auto;
        }

        .message-bubble.sent {
            background: linear-gradient(135deg, var(--dark-grey-medium), var(--dark-grey-dark));
            color: white;
            border-bottom-right-radius: 4px;
            margin-left: auto;
        }

        .message-time {
            font-size: 11px;
            color: var(--dark-grey-light);
            margin-top: 4px;
            text-align: right;
        }

        .message-time.sent {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .messages-layout {
                grid-template-columns: 1fr;
                height: auto;
            }
            
            .conversations-sidebar {
                height: 400px;
                border-right: none;
                border-bottom: 1px solid var(--dark-grey-ultra-light);
            }
            
            .attachment-options {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .messages-header {
                padding: 20px;
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .modal-container {
                width: 95%;
                margin: 10px;
            }
        }
    </style>
</head>
<body>
<div class="messages-container">
    <!-- Header -->
    <div class="messages-header">
        <h1><i class="fas fa-comments"></i> Messages</h1>
        <button class="new-message-btn" onclick="openNewMessageModal()">
            <i class="fas fa-plus"></i> New Message
        </button>
    </div>

    <!-- Main Content -->
    <div class="messages-layout">
        <!-- Left Sidebar - Conversations -->
        <div class="conversations-sidebar">
            <!-- Search -->
            <div class="conversation-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search conversations..." id="searchConversations">
            </div>

            <!-- Filters -->
            <div class="conversation-filters">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="unread">Unread</button>
                <button class="filter-btn" data-filter="clients">Clients</button>
                <button class="filter-btn" data-filter="freelancers">Freelancers</button>
            </div>

            <!-- Conversations List -->
            <div class="conversations-list" id="conversationsList">
                <div class="empty-conversations" id="loadingConversations">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading your conversations...</p>
                </div>
            </div>
        </div>

        <!-- Right Panel - Chat Area -->
        <div class="chat-area" id="chatArea">
            <div class="empty-chat-state">
                <div class="empty-chat-icon">
                    <i class="fas fa-comment-dots"></i>
                </div>
                <h3>Select a conversation</h3>
                <p>Choose a conversation from the list to start messaging</p>
                <button class="start-chat-btn" onclick="openNewMessageModal()">
                    <i class="fas fa-plus"></i> Start New Chat
                </button>
            </div>
        </div>
    </div>
</div>

<!-- New Message Modal -->
<div class="modal-overlay" id="newMessageModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3><i class="fas fa-paper-plane"></i> New Message</h3>
            <button class="modal-close" onclick="closeNewMessageModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="recipientSelect"><i class="fas fa-user"></i> To:</label>
                <select id="recipientSelect" class="form-control">
                    <option value="">Select a recipient...</option>
                    <!-- Will be populated from your database -->
                </select>
            </div>
            <div class="form-group">
                <label for="messageContent"><i class="fas fa-comment-alt"></i> Message:</label>
                <textarea id="messageContent" rows="5" placeholder="Type your message here..."></textarea>
            </div>
            <div class="form-group">
                <label><i class="fas fa-paperclip"></i> Attach to:</label>
                <div class="attachment-options">
                    <select id="jobSelect" class="form-control">
                        <option value="">Select a job (optional)</option>
                        <!-- Will be populated from your database -->
                    </select>
                    <select id="contractSelect" class="form-control">
                        <option value="">Select a contract (optional)</option>
                        <!-- Will be populated from your database -->
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="closeNewMessageModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
            <button class="btn-primary" onclick="sendNewMessage()">
                <i class="fas fa-paper-plane"></i> Send Message
            </button>
        </div>
    </div>
</div>
<script>
// Get CSRF token FIRST
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
// Fix PHP syntax issue
const currentUserId = <?php echo Auth::check() ? Auth::id() : 'null'; ?>;

// Global error handling for fetch requests
const originalFetch = window.fetch;
window.fetch = async function(...args) {
    try {
        const response = await originalFetch.apply(this, args);
        
        // Check for authentication issues
        if (response.status === 401 || response.status === 419) {
            const text = await response.text();
            if (text.includes('login') || text.includes('Login')) {
                if (!window.location.href.includes('/login')) {
                    console.warn('Authentication expired, redirecting to login');
                    window.location.href = '/login';
                }
                return response;
            }
        }
        
        return response;
    } catch (error) {
        console.error('Fetch error:', error);
        throw error;
    }
};

// Validate CSRF token
if (!csrfToken || csrfToken.length < 10) {
    console.error('CSRF token missing or invalid');
    alert('Your session has expired. Please refresh the page.');
    location.reload();
}

// Validate user is logged in
if (!currentUserId || currentUserId === 'null') {
    console.error('User not logged in');
    alert('Please login first.');
    window.location.href = '/login';
}

// Rest of your existing JavaScript code...
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, loading conversations...');
    loadRealConversations();
    loadRealUsersForModal();
    // loadRealJobsAndContracts(); // Comment out if not implemented yet
});

function openNewMessageModal() {
    document.getElementById('newMessageModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeNewMessageModal() {
    document.getElementById('newMessageModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('messageContent').value = '';
}

// Load REAL conversations from your database
function loadRealConversations() {
    console.log('Loading conversations...');
    
    fetch('/messages/api/conversations', {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(async response => {
        console.log('Conversations response status:', response.status);
        
        // First check if response is JSON
        const contentType = response.headers.get('content-type');
        
        if (!contentType || !contentType.includes('application/json')) {
            // Response is not JSON, might be HTML
            const text = await response.text();
            console.log('Non-JSON response received:', text.substring(0, 200));
            
            // Check if it's a login redirect
            if (text.includes('login') || text.includes('Login')) {
                console.warn('Authentication expired, redirecting to login');
                window.location.href = '/login';
                return { success: false, error: 'Authentication required' };
            }
            
            throw new Error('Server returned HTML instead of JSON. Status: ' + response.status);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Conversations data received:', data);
        
        const conversationsList = document.getElementById('conversationsList');
        
        if (data.success && data.conversations && data.conversations.length > 0) {
            conversationsList.innerHTML = '';
            
            data.conversations.forEach((conversation, index) => {
                const conversationItem = document.createElement('a');
                conversationItem.href = `/messages/${conversation.user.id}`;
                conversationItem.className = `conversation-item ${index === 0 ? 'active' : ''}`;
                conversationItem.setAttribute('data-user-id', conversation.user.id);
                conversationItem.setAttribute('data-role', conversation.user.role);
                conversationItem.setAttribute('data-unread', conversation.unread_count > 0 ? 'true' : 'false');
                
                // Get last message text
                let lastMessageText = 'No messages yet';
                let lastMessageTime = '';
                
                if (conversation.last_message) {
                    lastMessageText = conversation.last_message.message || 'No message text';
                    if (conversation.last_message.message && conversation.last_message.message.length > 50) {
                        lastMessageText = conversation.last_message.message.substring(0, 50) + '...';
                    }
                    lastMessageTime = conversation.last_message_time ? getTimeAgo(conversation.last_message_time) : '';
                }
                
                const timeAgo = lastMessageTime || getTimeAgo(conversation.last_message_time) || 'No messages';
                
                conversationItem.innerHTML = `
                    <div class="conversation-avatar">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--dark-grey-light), var(--dark-grey-medium)); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; border: 3px solid var(--dark-grey-ultra-light);">
                            ${conversation.user.name ? conversation.user.name.charAt(0).toUpperCase() : 'U'}
                        </div>
                        ${conversation.unread_count > 0 ? 
                            `<span class="unread-badge">${conversation.unread_count}</span>` : ''}
                    </div>
                    <div class="conversation-details">
                        <div class="conversation-header">
                            <h4 class="conversation-name">
                                ${conversation.user.name || 'Unknown User'}
                                <span class="${conversation.user.role === 'client' ? 'client-badge' : 'freelancer-badge'}">
                                    ${conversation.user.role === 'client' ? 'Client' : 'Freelancer'}
                                </span>
                            </h4>
                            <span class="conversation-time">${timeAgo}</span>
                        </div>
                        <p class="conversation-preview">${lastMessageText}</p>
                        ${conversation.user.company && conversation.user.role === 'client' ? 
                            `<small style="color: var(--dark-grey-light); font-size: 11px;">${conversation.user.company}</small>` : ''}
                    </div>
                `;
                
                conversationsList.appendChild(conversationItem);
                
                // Add click event - ONLY if there's already an href
                conversationItem.addEventListener('click', function(e) {
                    // Check if this is a real link (not a placeholder)
                    if (this.href && !this.href.includes('#')) {
                        e.preventDefault();
                        const userId = this.getAttribute('data-user-id');
                        console.log('Loading chat for user:', userId);
                        loadRealChat(userId);
                        
                        // Update active state
                        document.querySelectorAll('.conversation-item').forEach(i => {
                            i.classList.remove('active');
                        });
                        this.classList.add('active');
                    }
                });
            });
            
            // Auto-load first conversation
            if (data.conversations.length > 0) {
                const firstUserId = data.conversations[0].user.id;
                console.log('Auto-loading first conversation:', firstUserId);
                loadRealChat(firstUserId);
            }
        } else {
            conversationsList.innerHTML = `
                <div class="empty-conversations">
                    <i class="fas fa-comments"></i>
                    <p>No conversations yet</p>
                    <small>Start by sending a message to someone</small>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error loading conversations:', error);
        
        const conversationsList = document.getElementById('conversationsList');
        
        if (error.message.includes('Authentication') || error.message.includes('login')) {
            conversationsList.innerHTML = `
                <div class="empty-conversations">
                    <i class="fas fa-sign-in-alt"></i>
                    <p>Session Expired</p>
                    <small>Please <a href="/login" style="color: var(--dark-grey-medium); text-decoration: underline;">login</a> to continue</small>
                </div>
            `;
        } else if (error.message.includes('HTML')) {
            conversationsList.innerHTML = `
                <div class="empty-conversations">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>API Error</p>
                    <small>Check if route exists: /messages/api/conversations</small>
                    <button onclick="location.reload()" style="margin-top: 10px; padding: 8px 16px; background: var(--dark-grey-medium); color: white; border: none; border-radius: 8px; cursor: pointer;">
                        Retry
                    </button>
                </div>
            `;
        } else {
            conversationsList.innerHTML = `
                <div class="empty-conversations">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Connection Error</p>
                    <small>Unable to load conversations. Please check your connection.</small>
                </div>
            `;
        }
    });
}

// Load REAL users from your database for modal
function loadRealUsersForModal() {
    fetch('/api/users/all', {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(async response => {
        const contentType = response.headers.get('content-type');
        
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            
            if (text.includes('login') || text.includes('Login')) {
                return { success: false, error: 'Authentication required' };
            }
            
            throw new Error('HTML response received');
        }
        
        return response.json();
    })
    .then(data => {
        const recipientSelect = document.getElementById('recipientSelect');
        
        // Clear existing options (except the first one)
        while (recipientSelect.options.length > 1) {
            recipientSelect.remove(1);
        }
        
        if (data.success && data.users && data.users.length > 0) {
            // Filter out current user
            const otherUsers = data.users.filter(user => user.id !== currentUserId);
            
            // Group users by role
            const clients = otherUsers.filter(user => user.role === 'client');
            const freelancers = otherUsers.filter(user => user.role === 'freelancer');
            
            // Add clients group
            if (clients.length > 0) {
                const clientGroup = document.createElement('optgroup');
                clientGroup.label = "Clients";
                clients.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    const displayName = user.company ? 
                        `${user.name} (${user.company})` : user.name;
                    option.textContent = displayName;
                    clientGroup.appendChild(option);
                });
                recipientSelect.appendChild(clientGroup);
            }
            
            // Add freelancers group
            if (freelancers.length > 0) {
                const freelancerGroup = document.createElement('optgroup');
                freelancerGroup.label = "Freelancers";
                freelancers.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    const displayName = user.title ? 
                        `${user.name} (${user.title})` : user.name;
                    option.textContent = displayName;
                    freelancerGroup.appendChild(option);
                });
                recipientSelect.appendChild(freelancerGroup);
            }
        } else {
            // Fallback: Use static data if API fails
            loadFallbackUsers();
        }
    })
    .catch(error => {
        console.error('Error loading users:', error);
        loadFallbackUsers();
    });
}

function loadFallbackUsers() {
    const recipientSelect = document.getElementById('recipientSelect');
    recipientSelect.innerHTML += `
        <optgroup label="Your Real Clients">
            <option value="3">limu (My Company)</option>
            <option value="4">Tahnia Akther (My Company)</option>
            <option value="6">client1 (My Company)</option>
            <option value="8">tamanna (My Company)</option>
            <option value="9">Insia (My Company)</option>
            <option value="10">client3 (My Company)</option>
        </optgroup>
        <optgroup label="Your Real Freelancers">
            <option value="1">Tasnia akter (New Freelancer)</option>
            <option value="2">raisha (New Freelancer)</option>
            <option value="5">freelencer1</option>
            <option value="7">client2</option>
        </optgroup>
    `;
}

// Load chat with REAL user - FIXED VERSION
function loadRealChat(userId) {
    console.log('Loading chat for user ID:', userId);
    
    const chatArea = document.getElementById('chatArea');
    chatArea.innerHTML = `
        <div style="display: flex; flex-direction: column; height: 100%;">
            <!-- Loading header -->
            <div style="padding: 20px; border-bottom: 1px solid var(--dark-grey-ultra-light); display: flex; align-items: center; gap: 12px; background: white;">
                <div style="width: 45px; height: 45px; border-radius: 50%; background: var(--dark-grey-ultra-light); display: flex; align-items: center; justify-content: center;"></div>
                <div>
                    <h3 style="margin: 0; color: var(--dark-grey-dark); font-size: 16px; font-weight: 600;">Loading...</h3>
                </div>
            </div>
            
            <!-- Loading messages -->
            <div style="flex: 1; overflow-y: auto; padding: 20px; background: var(--dark-grey-bg); display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <div style="text-align: center; padding: 40px; color: var(--dark-grey-medium);">
                    <div style="border: 3px solid var(--dark-grey-ultra-light); border-top: 3px solid var(--dark-grey-medium); border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
                    <p>Loading messages...</p>
                </div>
            </div>
        </div>
    `;
    
    // Use the CORRECT API endpoint - IMPORTANT: Use /messages/api/with/{user}
    fetch(`/messages/api/with/${userId}`, {  // CHANGED TO CORRECT ENDPOINT
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(async response => {
        console.log('Chat API response status:', response.status);
        
        if (response.status === 401 || response.status === 419) {
            throw new Error('Authentication required');
        }
        
        const data = await response.json();
        console.log('Chat data received:', data);
        
        if (data.success && data.messages) {
            renderChatArea(userId, data.messages, data.user || {});
        } else {
            showErrorChat('Could not load messages for this user');
        }
    })
    .catch(error => {
        console.error('Error loading chat:', error);
        showErrorChat('Connection error: ' + error.message);
    });
}

function showErrorChat(message) {
    const chatArea = document.getElementById('chatArea');
    chatArea.innerHTML = `
        <div class="empty-chat-state">
            <div class="empty-chat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3>Error loading chat</h3>
            <p>${message}</p>
            <button class="start-chat-btn" onclick="location.reload()">
                <i class="fas fa-redo"></i> Retry
            </button>
        </div>
    `;
}

function renderChatArea(userId, messages, userData) {
    console.log('Rendering chat area for user:', userData);
    console.log('Number of messages:', messages.length);
    
    const chatArea = document.getElementById('chatArea');
    
    // Group messages by date
    const messagesByDate = {};
    messages.forEach(msg => {
        const date = new Date(msg.created_at).toLocaleDateString('en-US', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        if (!messagesByDate[date]) {
            messagesByDate[date] = [];
        }
        messagesByDate[date].push(msg);
    });
    
    // Create messages HTML
    let messagesHtml = '';
    
    // If no messages
    if (Object.keys(messagesByDate).length === 0) {
        messagesHtml = `
            <div style="text-align: center; padding: 60px 20px; color: var(--dark-grey-light);">
                <i class="fas fa-comments" style="font-size: 48px; margin-bottom: 20px; opacity: 0.5;"></i>
                <h3 style="margin-bottom: 10px; color: var(--dark-grey-medium);">No messages yet</h3>
                <p>Start the conversation!</p>
            </div>
        `;
    } else {
        Object.keys(messagesByDate).forEach(date => {
            messagesHtml += `
                <div style="text-align: center; margin: 20px 0;">
                    <span style="background: var(--dark-grey-ultra-light); color: var(--dark-grey-medium); padding: 6px 16px; border-radius: 12px; font-size: 12px; font-weight: 500;">
                        ${date}
                    </span>
                </div>
            `;
            
            messagesByDate[date].forEach(msg => {
                const isSent = parseInt(msg.sender_id) === parseInt(currentUserId);
                const time = new Date(msg.created_at).toLocaleTimeString([], {
                    hour: '2-digit', 
                    minute: '2-digit',
                    hour12: true
                });
                
                // Get sender name
                let senderName = 'User';
                if (msg.sender && msg.sender.name) {
                    senderName = msg.sender.name;
                } else if (msg.sender_name) {
                    senderName = msg.sender_name;
                }
                
                messagesHtml += `
                    <div style="display: flex; justify-content: ${isSent ? 'flex-end' : 'flex-start'}; margin: 8px 0; padding: 0 10px;">
                        <div style="max-width: 70%;">
                            ${!isSent ? `
                                <div style="font-size: 12px; color: var(--dark-grey-light); margin-bottom: 4px; margin-left: 8px;">
                                    ${senderName}
                                </div>
                            ` : ''}
                            <div class="message-bubble ${isSent ? 'sent' : 'received'}" 
                                 style="${isSent ? 'background: linear-gradient(135deg, var(--dark-grey-medium), var(--dark-grey-dark)); color: white;' : 'background: var(--dark-grey-ultra-light); color: var(--dark-grey-dark);'} 
                                        padding: 12px 16px; border-radius: 18px; ${isSent ? 'border-bottom-right-radius: 4px;' : 'border-bottom-left-radius: 4px;'}">
                                <div style="word-wrap: break-word; font-size: 14px; line-height: 1.4;">${escapeHtml(msg.message)}</div>
                                <div class="message-time ${isSent ? 'sent' : ''}" style="font-size: 11px; color: ${isSent ? 'rgba(255,255,255,0.8)' : 'var(--dark-grey-light)'}; margin-top: 4px; text-align: right;">
                                    ${time}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        });
    }
    
    const userName = userData.name || 'User';
    const userRole = userData.role || 'user';
    const userCompany = userData.company || '';
    const displayName = userCompany && userRole === 'client' ? 
        `${userName} (${userCompany})` : userName;
    
    chatArea.innerHTML = `
        <div style="display: flex; flex-direction: column; height: 100%;">
            <!-- Chat Header -->
            <div style="padding: 20px; border-bottom: 1px solid var(--dark-grey-ultra-light); display: flex; align-items: center; justify-content: space-between; background: white;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, var(--dark-grey-light), var(--dark-grey-medium)); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px;">
                        ${userName.charAt(0).toUpperCase()}
                    </div>
                    <div>
                        <h3 style="margin: 0; color: var(--dark-grey-dark); font-size: 16px; font-weight: 600;">${displayName}</h3>
                        <p style="margin: 2px 0 0; color: var(--dark-grey-light); font-size: 12px;">
                            <span class="${userRole === 'client' ? 'client-badge' : 'freelancer-badge'}" 
                                  style="display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 600; background: ${userRole === 'client' ? 'var(--success)' : 'var(--dark-grey-medium)'}; color: white;">
                                ${userRole === 'client' ? 'Client' : 'Freelancer'}
                            </span>
                        </p>
                    </div>
                </div>
                <button onclick="showUserOptions(${userId})" style="background: none; border: none; color: var(--dark-grey-medium); cursor: pointer; padding: 8px; border-radius: 8px; hover:background: var(--dark-grey-ultra-light);">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
            </div>
            
            <!-- Messages Area -->
            <div style="flex: 1; overflow-y: auto; padding: 10px; background: var(--dark-grey-bg);" id="messagesContainer">
                ${messagesHtml}
            </div>
            
            <!-- Message Input -->
            <div style="padding: 20px; border-top: 1px solid var(--dark-grey-ultra-light); background: white;">
                <form id="messageForm" onsubmit="sendMessageToUser(event, ${userId})">
                    <div style="display: flex; gap: 10px;">
                        <input type="text" name="message" placeholder="Type your message..." 
                               required
                               style="flex: 1; padding: 14px 16px; border: 2px solid var(--dark-grey-ultra-light); border-radius: 12px; font-size: 15px; transition: all 0.3s ease;"
                               onfocus="this.style.borderColor='var(--dark-grey-light)'; this.style.boxShadow='0 0 0 3px rgba(69, 104, 130, 0.1)'"
                               onblur="this.style.borderColor='var(--dark-grey-ultra-light)'; this.style.boxShadow='none'">
                        <button type="submit" style="background: linear-gradient(135deg, var(--dark-grey-medium), var(--dark-grey-dark)); color: white; border: none; padding: 0 24px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(35, 76, 106, 0.3)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
    
    // Scroll to bottom
    setTimeout(() => {
        const container = document.getElementById('messagesContainer');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }, 100);
}

function sendMessageToUser(e, userId) {
    e.preventDefault();
    console.log('Sending message to user:', userId);
    
    const form = e.target;
    const messageInput = form.querySelector('input[name="message"]');
    const message = messageInput.value.trim();
    
    if (!message) {
        showToast('Please enter a message', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('message', message);
    formData.append('_token', csrfToken);
    
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    submitBtn.disabled = true;
    
    fetch(`/messages/${userId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(async response => {
        // First check if response is JSON
        const contentType = response.headers.get('content-type');
        
        if (!contentType || !contentType.includes('application/json')) {
            // Response is not JSON, might be HTML
            const text = await response.text();
            
            // Check if it's a login redirect
            if (text.includes('login') || text.includes('Login')) {
                showToast('Your session has expired. Redirecting to login...', 'error');
                setTimeout(() => window.location.href = '/login', 2000);
                return null;
            }
            
            throw new Error('Server returned HTML instead of JSON. Check authentication.');
        }
        
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            form.reset();
            showToast('Message sent successfully!', 'success');
            // Reload the chat to show the new message
            setTimeout(() => loadRealChat(userId), 500);
            // Refresh conversations list
            setTimeout(() => loadRealConversations(), 1000);
        } else {
            showToast('Failed to send message: ' + (data?.error || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        showToast('Failed to send message. Please try again.', 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function sendNewMessage() {
    const recipient = document.getElementById('recipientSelect').value;
    const message = document.getElementById('messageContent').value.trim();
    const jobId = document.getElementById('jobSelect').value;
    const contractId = document.getElementById('contractSelect').value;
    
    if (!recipient) {
        showToast('Please select a recipient.', 'error');
        return;
    }
    
    if (!message) {
        showToast('Please enter a message.', 'error');
        return;
    }
    
    const data = {
        message: message,
        job_id: jobId || null,
        contract_id: contractId || null
    };
    
    fetch(`/messages/${recipient}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })
    .then(async response => {
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        
        if (!contentType || !contentType.includes('application/json')) {
            // Response is not JSON, might be HTML
            const text = await response.text();
            
            // Check if it's a login redirect
            if (text.includes('login') || text.includes('Login')) {
                showToast('Your session has expired. Redirecting to login...', 'error');
                setTimeout(() => window.location.href = '/login', 2000);
                throw new Error('Authentication required');
            }
            
            throw new Error('Server returned HTML instead of JSON. Check authentication.');
        }
        
        return response.json();
    })
    .then(data => {
        if (data.success) {
            closeNewMessageModal();
            showToast('Message sent successfully!', 'success');
            // Redirect to the new conversation
            setTimeout(() => {
                window.location.href = `/messages/${recipient}`;
            }, 1000);
        } else {
            showToast('Failed to send message: ' + (data.error || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        
        if (error.message.includes('Authentication') || error.message.includes('login')) {
            showToast('Session expired. Please login again.', 'error');
            setTimeout(() => window.location.href = '/login', 1500);
        } else {
            showToast('Failed to send message. Please try again.', 'error');
        }
    });
}

// Filter conversations
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('filter-btn')) {
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        e.target.classList.add('active');
        
        const filter = e.target.getAttribute('data-filter');
        filterConversations(filter);
    }
});

function filterConversations(filter) {
    const items = document.querySelectorAll('.conversation-item');
    
    items.forEach(item => {
        const role = item.getAttribute('data-role');
        const hasUnread = item.getAttribute('data-unread') === 'true';
        
        switch(filter) {
            case 'unread':
                item.style.display = hasUnread ? 'flex' : 'none';
                break;
            case 'clients':
                item.style.display = role === 'client' ? 'flex' : 'none';
                break;
            case 'freelancers':
                item.style.display = role === 'freelancer' ? 'flex' : 'none';
                break;
            default:
                item.style.display = 'flex';
        }
    });
}

// Search conversations
document.getElementById('searchConversations').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.conversation-item');
    
    items.forEach(item => {
        const name = item.querySelector('.conversation-name').textContent.toLowerCase();
        const companyElement = item.querySelector('small');
        const company = companyElement ? companyElement.textContent.toLowerCase() : '';
        
        if (name.includes(searchTerm) || company.includes(searchTerm)) {
            item.style.display = 'flex';
            // Add highlight effect
            item.style.animation = 'highlightPulse 0.5s ease';
        } else {
            item.style.display = 'none';
        }
    });
});

// Utility functions
function getTimeAgo(dateString) {
    if (!dateString) return 'No messages';
    
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);
    
    if (diffMins < 1) return 'Just now';
    if (diffMins < 60) return `${diffMins}m ago`;
    if (diffHours < 24) return `${diffHours}h ago`;
    if (diffDays < 7) return `${diffDays}d ago`;
    return date.toLocaleDateString([], {month: 'short', day: 'numeric'});
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function showToast(message, type = 'success') {
    // Remove existing toasts
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.className = `toast-notification`;
    toast.innerHTML = `
        <div style="position: fixed; top: 20px; right: 20px; background: ${type === 'success' ? 'var(--success)' : 'var(--danger)'}; 
                    color: white; padding: 16px 24px; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.2); 
                    z-index: 9999; display: flex; align-items: center; gap: 12px; animation: slideInRight 0.3s ease;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function showUserOptions(userId) {
    // Implement user options menu
    alert(`User ID: ${userId}\nOptions menu would appear here`);
}

// Close modal on outside click
document.getElementById('newMessageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeNewMessageModal();
    }
});

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes highlightPulse {
        0% { background-color: transparent; }
        50% { background-color: var(--dark-grey-ultra-light); }
        100% { background-color: transparent; }
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
</body>
</html>