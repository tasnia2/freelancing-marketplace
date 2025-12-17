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
                    
                    <!-- Message -->
                    <div class="{{ $message->sender_id === auth()->id() 
                        ? 'bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-l-xl rounded-tr-xl' 
                        : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-r-xl rounded-tl-xl' }} 
                        px-4 py-3">
                        <div class="text-sm">{{ $message->message }}</div>
                        
                        @if($message->attachments && count($message->attachments) > 0)
                            <div class="mt-2 space-y-2">
                                @foreach($message->attachments as $attachment)
                                    <div class="flex items-center p-2 bg-white/20 dark:bg-gray-800/20 rounded-lg">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <span class="text-xs truncate">{{ $attachment['name'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 {{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                    {{ $message->created_at->format('h:i A') }}
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="text-center py-8">
        <div class="text-3xl text-gray-300 dark:text-gray-600 mb-3">
            <i class="fas fa-comments"></i>
        </div>
        <p class="text-gray-500 dark:text-gray-400">No messages yet</p>
    </div>
@endif