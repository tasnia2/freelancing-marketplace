{{-- resources/views/dashboard/client/messages-show.blade.php --}}
@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Animated Header -->
        <div class="mb-8 animate-fade-in-down">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('messages.index') }}" 
                       class="text-blue-600 hover:text-blue-800 transition-colors duration-300">
                        <i class="fas fa-arrow-left text-lg"></i>
                    </a>
                    <div class="flex items-center space-x-3">
                        @if($user->profile && $user->profile->avatar)
                            <img src="{{ asset('storage/' . $user->profile->avatar) }}" 
                                 alt="{{ $user->name }}"
                                 class="w-12 h-12 rounded-full border-2 border-white shadow-lg object-cover">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 
                                      flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                            <p class="text-gray-600">{{ $user->role == 'freelancer' ? 'Freelancer' : 'Client' }}</p>
                        </div>
                    </div>
                </div>
                @if($sharedJobs->count() > 0 || $sharedContracts->count() > 0)
                <div class="relative group">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 
                                 transition-all duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-paperclip mr-2"></i>Attach
                    </button>
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl 
                               opacity-0 invisible group-hover:opacity-100 group-hover:visible 
                               transition-all duration-300 z-50 border border-gray-200">
                        @if($sharedJobs->count() > 0)
                        <div class="p-3 border-b">
                            <p class="text-sm font-medium text-gray-700 mb-2">Shared Jobs</p>
                            @foreach($sharedJobs as $job)
                            <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                <input type="radio" name="job_id" value="{{ $job->id }}" 
                                       class="mr-2 text-blue-600">
                                <span class="text-sm">{{ Str::limit($job->title, 30) }}</span>
                            </label>
                            @endforeach
                        </div>
                        @endif
                        @if($sharedContracts->count() > 0)
                        <div class="p-3">
                            <p class="text-sm font-medium text-gray-700 mb-2">Shared Contracts</p>
                            @foreach($sharedContracts as $contract)
                            <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                <input type="radio" name="contract_id" value="{{ $contract->id }}" 
                                       class="mr-2 text-blue-600">
                                <span class="text-sm">Contract #{{ $contract->id }}</span>
                            </label>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Messages Container -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 
                   animate-slide-up">
            <!-- Messages List -->
            <div id="messages-container" class="h-[500px] overflow-y-auto p-6 bg-gradient-to-b 
                      from-gray-50 to-white">
                @foreach($messages as $message)
                <div class="message-item mb-4 animate-fade-in" 
                     data-message-id="{{ $message->id }}">
                    <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[70%]">
                            <div class="flex items-end space-x-2 {{ $message->sender_id == auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                                <!-- Avatar -->
                                @if($message->sender_id != auth()->id())
                                <div class="flex-shrink-0">
                                    @if($message->sender->profile && $message->sender->profile->avatar)
                                    <img src="{{ asset('storage/' . $message->sender->profile->avatar) }}" 
                                         alt="{{ $message->sender->name }}"
                                         class="w-8 h-8 rounded-full">
                                    @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 
                                              flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($message->sender->name, 0, 1) }}
                                    </div>
                                    @endif
                                </div>
                                @endif
                                
                                <!-- Message Bubble -->
                                <div class="{{ $message->sender_id == auth()->id() 
                                            ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-l-2xl rounded-tr-2xl' 
                                            : 'bg-gray-100 text-gray-800 rounded-r-2xl rounded-tl-2xl' }} 
                                          px-4 py-3 shadow-sm">
                                    <p class="text-sm leading-relaxed">{{ $message->message }}</p>
                                    
                                    <!-- Attachments -->
                                    @if($message->attachments && count($message->attachments) > 0)
                                    <div class="mt-2 space-y-2">
                                        @foreach($message->attachments as $attachment)
                                        <a href="{{ $attachment['url'] ?? '#' }}" 
                                           target="_blank"
                                           class="flex items-center p-2 bg-white bg-opacity-20 rounded-lg 
                                                  hover:bg-opacity-30 transition-all duration-200">
                                            <i class="fas fa-paperclip mr-2"></i>
                                            <span class="text-xs truncate">{{ $attachment['name'] }}</span>
                                        </a>
                                        @endforeach
                                    </div>
                                    @endif
                                    
                                    <!-- Time -->
                                    <div class="mt-1 text-xs opacity-75 {{ $message->sender_id == auth()->id() 
                                                ? 'text-blue-100' : 'text-gray-500' }}">
                                        {{ $message->formatted_time }}
                                        @if($message->sender_id == auth()->id())
                                        <i class="ml-1 fas {{ $message->read ? 'fa-check-double text-green-300' : 'fa-check' }}"></i>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Avatar for own messages -->
                                @if($message->sender_id == auth()->id())
                                <div class="flex-shrink-0">
                                    @if(auth()->user()->profile && auth()->user()->profile->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->profile->avatar) }}" 
                                         alt="{{ auth()->user()->name }}"
                                         class="w-8 h-8 rounded-full">
                                    @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-400 to-green-600 
                                              flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Message Form -->
            <div class="border-t border-gray-200 bg-gray-50 p-4">
                <form id="message-form" action="{{ route('messages.store', $user) }}" 
                      method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <!-- Hidden fields for job/contract -->
                    <input type="hidden" name="job_id" id="job_id_input" value="">
                    <input type="hidden" name="contract_id" id="contract_id_input" value="">
                    
                    <div class="flex items-end space-x-3">
                        <!-- Attachment Button -->
                        <div class="relative">
                            <button type="button" 
                                    onclick="document.getElementById('attachments').click()"
                                    class="w-10 h-10 flex items-center justify-center bg-gray-200 
                                           rounded-full hover:bg-gray-300 transition-colors duration-200
                                           text-gray-600 hover:text-gray-800">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <input type="file" name="attachments[]" id="attachments" 
                                   multiple class="hidden" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <div id="attachment-preview" class="absolute bottom-full mb-2 bg-white 
                                  rounded-lg shadow-lg p-3 min-w-[200px] hidden border border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Selected files:</p>
                                <div id="file-list" class="space-y-1"></div>
                            </div>
                        </div>
                        
                        <!-- Message Input -->
                        <div class="flex-grow relative">
                            <textarea name="message" id="message-input" 
                                      rows="1"
                                      placeholder="Type your message here..."
                                      class="w-full px-4 py-3 bg-white border border-gray-300 
                                             rounded-xl focus:outline-none focus:border-blue-500 
                                             focus:ring-2 focus:ring-blue-200 resize-none
                                             transition-all duration-300"
                                      oninput="autoResize(this)"></textarea>
                        </div>
                        
                        <!-- Send Button -->
                        <button type="submit"
                                id="send-button"
                                class="w-10 h-10 flex items-center justify-center bg-gradient-to-r 
                                       from-blue-600 to-blue-500 rounded-full hover:from-blue-700 
                                       hover:to-blue-600 transition-all duration-300 shadow-md 
                                       hover:shadow-lg text-white">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                    
                    <!-- Attachment Preview -->
                    <div id="attachment-preview-container" class="space-y-2 hidden"></div>
                </form>
                
                <!-- Typing Indicator -->
                <div id="typing-indicator" class="mt-2 hidden animate-pulse">
                    <div class="flex items-center space-x-1">
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                        <span class="text-sm text-gray-500 ml-2">{{ $user->name }} is typing...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
// Auto-resize textarea
function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = Math.min(textarea.scrollHeight, 150) + 'px';
}

// Handle attachments
document.getElementById('attachments').addEventListener('change', function(e) {
    const preview = document.getElementById('attachment-preview');
    const fileList = document.getElementById('file-list');
    const container = document.getElementById('attachment-preview-container');
    
    fileList.innerHTML = '';
    container.innerHTML = '';
    
    if (this.files.length > 0) {
        // Show preview dropdown
        preview.classList.remove('hidden');
        
        Array.from(this.files).forEach((file, index) => {
            // Add to file list dropdown
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between text-xs';
            fileItem.innerHTML = `
                <span class="truncate flex-grow">${file.name}</span>
                <span class="text-gray-500 ml-2">(${(file.size / 1024).toFixed(1)} KB)</span>
            `;
            fileList.appendChild(fileItem);
            
            // Add to preview container
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgPreview = document.createElement('div');
                    imgPreview.className = 'flex items-center space-x-2 p-2 bg-gray-50 rounded-lg';
                    imgPreview.innerHTML = `
                        <img src="${e.target.result}" class="w-12 h-12 object-cover rounded" alt="Preview">
                        <div class="flex-grow">
                            <p class="text-sm font-medium truncate">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
                        </div>
                        <button type="button" onclick="removeAttachment(${index})" 
                                class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    container.appendChild(imgPreview);
                };
                reader.readAsDataURL(file);
            } else {
                const docPreview = document.createElement('div');
                docPreview.className = 'flex items-center space-x-2 p-2 bg-gray-50 rounded-lg';
                docPreview.innerHTML = `
                    <div class="w-12 h-12 bg-blue-100 rounded flex items-center justify-center">
                        <i class="fas fa-file text-blue-500"></i>
                    </div>
                    <div class="flex-grow">
                        <p class="text-sm font-medium truncate">${file.name}</p>
                        <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
                    </div>
                    <button type="button" onclick="removeAttachment(${index})" 
                            class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                container.appendChild(docPreview);
            }
        });
        
        container.classList.remove('hidden');
        
        // Hide preview when clicking outside
        setTimeout(() => {
            document.addEventListener('click', function hidePreview(e) {
                if (!preview.contains(e.target) && e.target.id !== 'attachments') {
                    preview.classList.add('hidden');
                    document.removeEventListener('click', hidePreview);
                }
            });
        }, 100);
    }
});

function removeAttachment(index) {
    const dt = new DataTransfer();
    const input = document.getElementById('attachments');
    
    Array.from(input.files).forEach((file, i) => {
        if (i !== index) dt.items.add(file);
    });
    
    input.files = dt.files;
    document.getElementById('attachments').dispatchEvent(new Event('change'));
}

// Handle form submission with AJAX
document.getElementById('message-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');
    const messagesContainer = document.getElementById('messages-container');
    
    // Check if message is empty
    if (!messageInput.value.trim()) {
        alert('Please enter a message');
        return;
    }
    
    // Disable button and show loading
    sendButton.disabled = true;
    const originalButtonHTML = sendButton.innerHTML;
    sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
    try {
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const responseText = await response.text();
        let data;
        
        try {
            data = JSON.parse(responseText);
        } catch (parseError) {
            console.error('Failed to parse JSON:', parseError);
            console.error('Response was:', responseText);
            throw new Error('Invalid response from server');
        }
        
        if (data.success && data.html) {
            // Add new message to the container
            const messageDiv = document.createElement('div');
            messageDiv.innerHTML = data.html.trim();
            
            if (messageDiv.firstElementChild) {
                messagesContainer.appendChild(messageDiv.firstElementChild);
                
                // Scroll to bottom with smooth animation
                messagesContainer.scrollTo({
                    top: messagesContainer.scrollHeight,
                    behavior: 'smooth'
                });
                
                // Clear form
                messageInput.value = '';
                messageInput.style.height = 'auto';
                document.getElementById('attachments').value = '';
                
                // Clear preview
                const previewContainer = document.getElementById('attachment-preview-container');
                if (previewContainer) {
                    previewContainer.innerHTML = '';
                    previewContainer.classList.add('hidden');
                }
                
                // Reset hidden inputs
                document.getElementById('job_id_input').value = '';
                document.getElementById('contract_id_input').value = '';
                
                // Show success notification
                showNotification('Message sent successfully!', 'success');
            }
        } else {
            const errorMsg = data.error || 'Failed to send message';
            showNotification(errorMsg, 'error');
            console.error('Server error:', data);
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Failed to send message. Please try again.', 'error');
    } finally {
        // Re-enable button
        sendButton.disabled = false;
        sendButton.innerHTML = originalButtonHTML;
    }
});

// Notification function
function showNotification(message, type = 'success') {
    // Remove existing notifications
    const existing = document.querySelector('.worknest-notification');
    if (existing) existing.remove();
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = `worknest-notification fixed top-4 right-4 px-6 py-4 rounded-lg shadow-xl z-50 animate-fade-in ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white font-medium`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Auto-scroll to bottom on page load
window.addEventListener('load', function() {
    const messagesContainer = document.getElementById('messages-container');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});

// Handle job/contract selection
document.querySelectorAll('input[name="job_id"], input[name="contract_id"]').forEach(input => {
    input.addEventListener('change', function() {
        if (this.name === 'job_id') {
            document.getElementById('job_id_input').value = this.value;
            document.getElementById('contract_id_input').value = '';
        } else {
            document.getElementById('contract_id_input').value = this.value;
            document.getElementById('job_id_input').value = '';
        }
    });
});

// Ensure CSRF token exists
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token meta tag is missing!');
        // Try to add it dynamically
        const meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = '{{ csrf_token() }}';
        document.head.appendChild(meta);
    }
});
</script>

<!-- Add CSS animations -->
<style>
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-down {
    animation: fadeInDown 0.5s ease-out;
}

.animate-slide-up {
    animation: slideUp 0.5s ease-out;
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}

.message-item {
    animation: fadeInUp 0.3s ease-out;
}

/* Custom scrollbar */
#messages-container::-webkit-scrollbar {
    width: 6px;
}

#messages-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#messages-container::-webkit-scrollbar-thumb {
    background: #456882;
    border-radius: 10px;
}

#messages-container::-webkit-scrollbar-thumb:hover {
    background: #234C6A;
}

/* Smooth scrolling */
#messages-container {
    scroll-behavior: smooth;
}

/* Notification animation */
.worknest-notification {
    animation: fadeIn 0.3s ease-out;
}
</style>
@endsection