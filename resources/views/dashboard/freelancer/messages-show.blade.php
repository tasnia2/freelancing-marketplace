@extends('layouts.client')

@section('title', 'Messages - WorkNest')

@section('header')
<div class="flex justify-between items-center">
    <div class="flex items-center">
        <a href="{{ route('messages.index') }}" class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white mr-3">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight">
                    {{ $user->name }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    @if($user->isClient())
                        Client • {{ $user->company ?? 'No company' }}
                    @else
                        Freelancer • {{ $user->title ?? 'No title' }}
                    @endif
                </p>
            </div>
        </div>
    </div>
    
    <div class="flex space-x-3">
        <!-- Shared Jobs Dropdown -->
        @if($sharedJobs->count() > 0)
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" 
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300 flex items-center">
                <i class="fas fa-briefcase mr-2"></i>
                Shared Jobs
                <i class="fas fa-chevron-down ml-2 text-xs"></i>
            </button>
            <div x-show="open" @click.away="open = false" 
                 class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-xl z-50 py-2 border border-gray-200 dark:border-gray-700">
                @foreach($sharedJobs as $job)
                <a href="{{ route('jobs.show', $job) }}" 
                   class="flex items-center px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $job->title }}</p>
                        <p class="text-xs text-gray-500">${{ number_format($job->budget) }}</p>
                    </div>
                    <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $job->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucfirst($job->status) }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <!-- Messages Container -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <!-- Messages List -->
            <div class="h-[500px] overflow-y-auto mb-6 space-y-4" id="messages-container">
                @foreach($messages as $message)
                <div class="flex {{ $message->is_from_current_user ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[70%]">
                        <div class="flex items-end {{ $message->is_from_current_user ? 'flex-row-reverse' : '' }}">
                            @if(!$message->is_from_current_user)
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white text-sm mr-2">
                                {{ substr($message->sender->name, 0, 1) }}
                            </div>
                            @endif
                            
                            <div class="{{ $message->is_from_current_user ? 'bg-[#456882] text-white rounded-2xl rounded-tr-none' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-2xl rounded-tl-none' }} p-4">
                                <p class="whitespace-pre-wrap">{{ $message->message }}</p>
                                @if($message->has_attachments)
                                <div class="mt-2">
                                    @foreach($message->attachments as $attachment)
                                    <a href="{{ $attachment['url'] }}" target="_blank" 
                                       class="inline-flex items-center px-3 py-1 bg-white/20 rounded-lg text-sm hover:bg-white/30 transition-colors">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        {{ $attachment['name'] }}
                                    </a>
                                    @endforeach
                                </div>
                                @endif
                                <p class="text-xs mt-2 {{ $message->is_from_current_user ? 'text-white/70' : 'text-gray-500' }}">
                                    {{ $message->formatted_time }}
                                    @if($message->is_from_current_user && $message->read)
                                    <i class="fas fa-check-double ml-1 text-green-300"></i>
                                    @endif
                                </p>
                            </div>
                            
                            @if($message->is_from_current_user)
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-500 to-teal-500 flex items-center justify-center text-white text-sm ml-2">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Message Input Form -->
            <form method="POST" action="{{ route('messages.store', $user) }}" 
                  enctype="multipart/form-data" id="message-form" class="space-y-4">
                @csrf
                
                <div class="flex space-x-3">
                    <div class="flex-1">
                        <textarea name="message" 
                                  rows="3" 
                                  placeholder="Type your message here..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-[#456882] focus:ring-2 focus:ring-[#456882]/20 resize-none"
                                  id="message-input"></textarea>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <!-- ADD ID="send-button" HERE -->
                        <button type="submit" id="send-button"
                                class="px-6 py-3 bg-gradient-to-r from-[#456882] to-[#234C6A] text-white font-bold rounded-xl hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 flex items-center justify-center">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                        <label for="attachments" 
                               class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300 flex items-center justify-center cursor-pointer">
                            <i class="fas fa-paperclip"></i>
                            <input type="file" 
                                   id="attachments" 
                                   name="attachments[]" 
                                   multiple 
                                   class="hidden">
                        </label>
                    </div>
                </div>
                
                <!-- File preview -->
                <div id="file-preview" class="hidden">
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-file text-[#456882]"></i>
                            <span class="text-sm text-gray-700 dark:text-gray-300" id="file-names"></span>
                        </div>
                        <button type="button" onclick="clearFiles()" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll to bottom of messages
    const messagesContainer = document.getElementById('messages-container');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    
    // File input handling
    const fileInput = document.getElementById('attachments');
    const filePreview = document.getElementById('file-preview');
    const fileNames = document.getElementById('file-names');
    
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            const names = Array.from(this.files).map(f => f.name).join(', ');
            fileNames.textContent = names;
            filePreview.classList.remove('hidden');
        } else {
            filePreview.classList.add('hidden');
        }
    });
    
    // Auto-resize textarea
    const messageInput = document.getElementById('message-input');
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Auto-focus message input
    messageInput.focus();
});

function clearFiles() {
    document.getElementById('attachments').value = '';
    document.getElementById('file-preview').classList.add('hidden');
}

document.getElementById('message-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    console.log('=== MESSAGE SEND START ===');
    
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
        console.log('Sending to:', this.action);
        
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        console.log('Response status:', response.status);
        
        const responseText = await response.text();
        console.log('Raw response text:', responseText);
        
        let data;
        try {
            data = JSON.parse(responseText);
            console.log('Parsed JSON:', data);
        } catch (parseError) {
            console.error('JSON parse error:', parseError);
            throw new Error('Server returned invalid JSON');
        }
        
        if (data.success && data.html) {
            console.log('✅ Success! HTML received');
            console.log('HTML content:', data.html);
            console.log('HTML length:', data.html.length);
            
            // Create temporary container
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data.html.trim();
            
            console.log('Temp div children:', tempDiv.children.length);
            
            // Look for message item
            let messageElement = tempDiv.querySelector('.message-item');
            if (!messageElement) {
                console.log('No .message-item class, using first child');
                messageElement = tempDiv.firstElementChild;
            }
            
            if (messageElement) {
                console.log('Found message element:', messageElement);
                console.log('Message element HTML:', messageElement.outerHTML);
                
                // Add animation
                messageElement.style.opacity = '0';
                messageElement.style.transform = 'translateY(10px)';
                
                // Add to container
                messagesContainer.appendChild(messageElement);
                console.log('✅ Message added to container');
                
                // Animate in
                setTimeout(() => {
                    messageElement.style.transition = 'all 0.3s ease';
                    messageElement.style.opacity = '1';
                    messageElement.style.transform = 'translateY(0)';
                }, 10);
                
                // Scroll to bottom
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                console.log('✅ Scrolled to bottom');
                
                // Clear form
                messageInput.value = '';
                messageInput.style.height = 'auto';
                
                // Clear attachments
                document.getElementById('attachments').value = '';
                document.getElementById('file-preview').classList.add('hidden');
                
                // Show success
                showToast('Message sent successfully!', 'success');
                
            } else {
                console.error('❌ No message element found in HTML');
                console.error('Temp div innerHTML:', tempDiv.innerHTML);
                showToast('Message sent but could not display it', 'warning');
            }
            
        } else {
            console.error('❌ Server returned error:', data);
            const errorMsg = data.error || 'Failed to send message';
            showToast(errorMsg, 'error');
        }
        
    } catch (error) {
        console.error('❌ AJAX Error:', error);
        showToast('Error: ' + error.message, 'error');
        
    } finally {
        // Re-enable button
        sendButton.disabled = false;
        sendButton.innerHTML = originalButtonHTML;
        console.log('=== MESSAGE SEND END ===');
    }
});
</script>
@endpush