@php
    // Handle both object and array formats
    $messageId = is_object($message) ? $message->id : ($message['id'] ?? $message['message']['id'] ?? null);
    $senderId = is_object($message) ? $message->sender_id : ($message['sender']['id'] ?? $message['sender_id'] ?? null);
    $messageText = is_object($message) ? $message->message : ($message['message'] ?? $message['content'] ?? '');
    $createdAt = is_object($message) ? $message->created_at : ($message['created_at'] ?? now());
    $attachments = is_object($message) ? ($message->attachments ?? []) : ($message['attachments'] ?? []);
    
    // Get sender info
    $senderName = 'Unknown';
    $senderAvatar = null;
    
    if (is_object($message)) {
        $senderName = $message->sender->name ?? 'Unknown';
        $senderAvatar = $message->sender->profile->avatar ?? null;
    } else {
        $senderName = $message['sender']['name'] ?? 'Unknown';
        $senderAvatar = $message['sender']['avatar'] ?? null;
    }
    
    $isCurrentUser = $senderId == auth()->id();
@endphp

<div class="message-item mb-4" data-message-id="{{ $messageId }}">
    <div class="flex {{ $isCurrentUser ? 'justify-end' : 'justify-start' }}">
        <div class="max-w-[70%]">
            <div class="flex items-end space-x-2 {{ $isCurrentUser ? 'flex-row-reverse space-x-reverse' : '' }}">
                <!-- Avatar -->
                @if(!$isCurrentUser)
                <div class="flex-shrink-0">
                    @if($senderAvatar)
                    <img src="{{ asset('storage/' . $senderAvatar) }}" 
                         alt="{{ $senderName }}"
                         class="w-8 h-8 rounded-full">
                    @else
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 
                              flex items-center justify-center text-white text-xs font-bold">
                        {{ substr($senderName, 0, 1) }}
                    </div>
                    @endif
                </div>
                @endif
                
                <!-- Message Bubble -->
                <div class="{{ $isCurrentUser 
                            ? 'bg-gradient-to-r from-[#456882] to-[#234C6A] text-white rounded-l-2xl rounded-tr-2xl' 
                            : 'bg-gray-100 text-gray-800 rounded-r-2xl rounded-tl-2xl' }} 
                          px-4 py-3 shadow-sm">
                    <p class="text-sm leading-relaxed">{{ $messageText }}</p>
                    
                    <!-- Attachments -->
                    @if(is_array($attachments) && count($attachments) > 0)
                    <div class="mt-2 space-y-2">
                        @foreach($attachments as $attachment)
                        <a href="{{ $attachment['url'] ?? '#' }}" 
                           target="_blank"
                           class="flex items-center p-2 bg-white bg-opacity-20 rounded-lg 
                                  hover:bg-opacity-30 transition-all duration-200">
                            <i class="fas fa-paperclip mr-2"></i>
                            <span class="text-xs truncate">{{ $attachment['name'] ?? 'Attachment' }}</span>
                        </a>
                        @endforeach
                    </div>
                    @endif
                    
                    <!-- Time -->
                    <div class="mt-1 text-xs opacity-75 {{ $isCurrentUser 
                                ? 'text-blue-100' : 'text-gray-500' }}">
                        @php
                            if ($createdAt instanceof \Illuminate\Support\Carbon || $createdAt instanceof \Carbon\Carbon) {
                                $time = $createdAt->diffForHumans();
                            } elseif (is_string($createdAt)) {
                                $time = \Carbon\Carbon::parse($createdAt)->diffForHumans();
                            } else {
                                $time = 'Just now';
                            }
                        @endphp
                        {{ $time }}
                    </div>
                </div>
                
                <!-- Avatar for own messages -->
                @if($isCurrentUser)
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