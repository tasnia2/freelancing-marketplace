<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('messages.index') }}"  
                   class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                        Messages
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        Chat with {{ $user->name }}
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <!-- User info -->
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white font-bold mr-3">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-medium text-gray-800 dark:text-white">{{ $user->name }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->user_type === 'freelancer' ? 'Freelancer' : 'Client' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Left Sidebar - Shared Items -->
                <div class="lg:col-span-1">
                    <!-- Shared Jobs -->
                    @if($sharedJobs && $sharedJobs->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-4 mb-4">
                            <h3 class="font-bold text-gray-800 dark:text-white mb-3">Shared Jobs</h3>
                            <div class="space-y-3">
                                @foreach($sharedJobs as $job)
                                    <div class="p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-[#456882] transition-colors">
                                        <div class="font-medium text-gray-800 dark:text-white text-sm">{{ $job->title }}</div>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                ${{ number_format($job->budget) }}
                                            </span>
                                            <a href="{{ route('jobs.show', $job) }}" 
                                               class="text-xs text-[#456882] hover:underline">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Shared Contracts -->
                    @if($sharedContracts && $sharedContracts->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-4">
                            <h3 class="font-bold text-gray-800 dark:text-white mb-3">Shared Contracts</h3>
                            <div class="space-y-3">
                                @foreach($sharedContracts as $contract)
                                    <div class="p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-[#456882] transition-colors">
                                        <div class="font-medium text-gray-800 dark:text-white text-sm">{{ $contract->title }}</div>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                ${{ number_format($contract->amount) }}
                                            </span>
                                            <span class="text-xs px-2 py-1 rounded {{ $contract->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                {{ ucfirst($contract->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Main Chat Area -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col h-[calc(100vh-12rem)]">
                        <!-- Messages Container -->
                        <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 space-y-4">
                            @if($messages->count() > 0)
                                @foreach($messages as $message)
                                    <div class="message-item {{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                                        <div class="inline-block max-w-[70%]">
                                            <div class="flex items-end space-x-2 {{ $message->sender_id === auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                                                <!-- Avatar -->
                                                <div class="w-8 h-8 rounded-full flex-shrink-0 
                                                    {{ $message->sender_id === auth()->id() 
                                                        ? 'bg-gradient-to-r from-[#1B3C53] to-[#234C6A]' 
                                                        : 'bg-gradient-to-r from-[#456882] to-[#1B3C53]' }} 
                                                    flex items-center justify-center text-white text-sm">
                                                    {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                                                </div>
                                                
                                                <!-- Message Bubble -->
                                                <div class="{{ $message->sender_id === auth()->id() 
                                                    ? 'bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-l-xl rounded-tr-xl' 
                                                    : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-r-xl rounded-tl-xl' }} 
                                                    px-4 py-3">
                                                    <div class="text-sm">{{ $message->message }}</div>
                                                    
                                                    <!-- Attachments -->
                                                    @if($message->attachments && count($message->attachments) > 0)
                                                        <div class="mt-2 space-y-2">
                                                            @foreach($message->attachments as $attachment)
                                                                <div class="flex items-center p-2 bg-white/20 dark:bg-gray-800/20 rounded-lg">
                                                                    <i class="fas fa-paperclip mr-2"></i>
                                                                    <span class="text-xs truncate flex-1">{{ $attachment['name'] }}</span>
                                                                    <a href="{{ Storage::url($attachment['path']) }}" 
                                                                       target="_blank"
                                                                       class="ml-2 text-xs text-blue-300 hover:text-blue-100">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    
                                                    <!-- Job/Contract Reference -->
                                                    @if($message->job_id)
                                                        <div class="mt-2 pt-2 border-t border-white/20 dark:border-gray-600">
                                                            <div class="text-xs opacity-75">
                                                                <i class="fas fa-briefcase mr-1"></i>
                                                                Referencing job: 
                                                              <a href="{{ route('jobs.show', $message->job_id) }}" " 
                                                                   class="underline hover:no-underline">
                                                                    View Job
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($message->contract_id)
                                                        <div class="mt-2 pt-2 border-t border-white/20 dark:border-gray-600">
                                                            <div class="text-xs opacity-75">
                                                                <i class="fas fa-file-contract mr-1"></i>
                                                                Referencing contract
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Timestamp -->
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 {{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                                                {{ $message->created_at->format('h:i A') }} • 
                                                {{ $message->created_at->format('M d') }}
                                                @if($message->read_at && $message->sender_id !== auth()->id())
                                                    • <i class="fas fa-check text-green-500 ml-1"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Empty State -->
                                <div class="text-center py-12">
                                    <div class="text-4xl text-gray-300 dark:text-gray-600 mb-4">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">No messages yet</h3>
                                    <p class="text-gray-500 dark:text-gray-400">Start the conversation with {{ $user->name }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Message Input -->
                        <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                            <form id="messageForm" action="{{ route('messages.store', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                
                                <!-- Message Input -->
                                <div class="flex space-x-3">
                                    <div class="flex-1">
                                        <textarea name="message" 
                                                  id="messageInput"
                                                  rows="1"
                                                  placeholder="Type your message..."
                                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-[#1B3C53] focus:border-transparent dark:bg-gray-700 dark:text-white resize-none"
                                                  required></textarea>
                                    </div>
                                    <div class="flex space-x-2">
                                        <!-- Attachment Button -->
                                        <button type="button" 
                                                onclick="document.getElementById('attachments').click()"
                                                class="px-4 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <i class="fas fa-paperclip"></i>
                                        </button>
                                        <input type="file" 
                                               id="attachments" 
                                               name="attachments[]" 
                                               multiple 
                                               class="hidden"
                                               accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                                        
                                        <!-- Send Button -->
                                        <button type="submit" 
                                                class="px-6 py-3 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- File List -->
                                <div id="fileList" class="space-y-2"></div>
                                
                                <!-- Reference Options -->
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center space-x-4">
                                        <!-- Reference Job -->
                                        <select name="job_id" 
                                                id="jobSelect"
                                                class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                                            <option value="">Reference a job</option>
                                            @foreach(auth()->user()->jobsPosted()->where('status', '!=', 'completed')->get() as $job)
                                                <option value="{{ $job->id }}">{{ $job->title }}</option>
                                            @endforeach
                                        </select>
                                        
                                        <!-- Reference Contract -->
                                        <select name="contract_id" 
                                                id="contractSelect"
                                                class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                                            <option value="">Reference a contract</option>
                                            @foreach(auth()->user()->contracts()->where('status', 'active')->get() as $contract)
                                                <option value="{{ $contract->id }}">{{ $contract->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="text-gray-500 dark:text-gray-400 text-xs">
                                        <i class="fas fa-lock mr-1"></i>
                                        Messages are encrypted
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-scroll to bottom of messages
            const messagesContainer = document.getElementById('messagesContainer');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
            
            // Auto-resize textarea
            const messageInput = document.getElementById('messageInput');
            if (messageInput) {
                messageInput.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            }
            
            // File upload handling
            const attachmentsInput = document.getElementById('attachments');
            const fileList = document.getElementById('fileList');
            
            if (attachmentsInput && fileList) {
                attachmentsInput.addEventListener('change', function(e) {
                    fileList.innerHTML = '';
                    Array.from(e.target.files).forEach(file => {
                        const fileItem = document.createElement('div');
                        fileItem.className = 'flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded-lg';
                        fileItem.innerHTML = `
                            <div class="flex items-center">
                                <i class="fas fa-file text-[#456882] mr-2"></i>
                                <span class="text-sm text-gray-700 dark:text-gray-300">${file.name}</span>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        fileList.appendChild(fileItem);
                    });
                });
            }
            
            // Form submission with AJAX
            const messageForm = document.getElementById('messageForm');
            if (messageForm) {
                messageForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    
                    // Disable button and show loading
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Clear form
                            messageInput.value = '';
                            messageInput.style.height = 'auto';
                            fileList.innerHTML = '';
                            attachmentsInput.value = '';
                            
                            // Add new message to UI
                            const messagesContainer = document.getElementById('messagesContainer');
                            if (messagesContainer && data.html) {
                                messagesContainer.innerHTML += data.html;
                                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to send message. Please try again.');
                    })
                    .finally(() => {
                        // Re-enable button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                    });
                });
            }
            
            // Refresh messages every 30 seconds
            setInterval(() => {
                fetch(`{{ route('messages.show', $user) }}?ajax=1`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.messages && data.html) {
                            document.getElementById('messagesContainer').innerHTML = data.html;
                        }
                    });
            }, 30000);
        });
        
        // Enter key to send (Ctrl+Enter for new line)
        document.getElementById('messageInput')?.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey && !e.ctrlKey) {
                e.preventDefault();
                document.getElementById('messageForm').dispatchEvent(new Event('submit'));
            }
        });
    </script>
    @endpush

    @push('styles')
    <style>
        /* Custom scrollbar for messages */
        #messagesContainer::-webkit-scrollbar {
            width: 6px;
        }
        
        #messagesContainer::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .dark #messagesContainer::-webkit-scrollbar-track {
            background: #334155;
        }
        
        #messagesContainer::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #1B3C53, #456882);
            border-radius: 3px;
        }
        
        /* Smooth message animations */
        .message-item {
            animation: fadeInUp 0.3s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Message bubble styling */
        .message-bubble-left {
            border-radius: 0 18px 18px 18px;
        }
        
        .message-bubble-right {
            border-radius: 18px 0 18px 18px;
        }
    </style>
    @endpush
</x-app-layout>