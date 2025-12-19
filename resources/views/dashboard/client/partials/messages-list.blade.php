@php
    // Handle both cases: single message or collection
    if (isset($message) && !isset($messages)) {
        // If $message is passed as a single item
        $messages = collect([$message]);
    } elseif (isset($messages) && is_array($messages)) {
        // If $messages is passed as array
        $messages = collect($messages);
    } elseif (isset($messages) && $messages instanceof \Illuminate\Support\Collection) {
        // Already a collection, keep as is
        $messages = $messages;
    } else {
        $messages = collect();
    }
@endphp

@if($messages->count() > 0)
    @foreach($messages as $msg)
        @php
            // Handle both object and array formats
            $messageId = is_array($msg) ? ($msg['id'] ?? $msg['message']['id'] ?? null) : $msg->id;
            $senderId = is_array($msg) ? ($msg['sender']['id'] ?? $msg['sender_id'] ?? null) : $msg->sender_id;
            $messageText = is_array($msg) ? ($msg['message'] ?? $msg['content'] ?? '') : $msg->message;
            $senderName = is_array($msg) ? ($msg['sender']['name'] ?? 'Unknown') : ($msg->sender->name ?? 'Unknown');
            $createdAt = is_array($msg) ? ($msg['created_at'] ?? now()) : $msg->created_at;
            $attachments = is_array($msg) ? ($msg['attachments'] ?? []) : ($msg->attachments ?? []);
            
            // Check if sender is current user
            $isCurrentUser = $senderId == auth()->id();
        @endphp
        
        <div class="message-item mb-4 animate-fade-in" data-message-id="{{ $messageId }}">
            <div class="flex {{ $isCurrentUser ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%]">
                    <div class="flex items-end space-x-2 {{ $isCurrentUser ? 'flex-row-reverse space-x-reverse' : '' }}">
                        <!-- Avatar -->
                        @if(!$isCurrentUser)
                        <div class="flex-shrink-0">
                            @php
                                $avatar = null;
                                if (is_array($msg)) {
                                    $avatar = $msg['sender']['avatar'] ?? null;
                                } elseif (isset($msg->sender) && isset($msg->sender->profile)) {
                                    $avatar = $msg->sender->profile->avatar ?? null;
                                }
                            @endphp
                            
                            @if($avatar)
                            <img src="{{ asset('storage/' . $avatar) }}" 
                                 alt="{{ $senderName }}"
                                 class="w-8 h-8 rounded-full">
                            @else
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 
                                      flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($senderName, 0, 1)) }}
                            </div>
                            @endif
                        </div>
                        @endif
                        
                        <!-- Message Bubble -->
                        <div class="{{ $isCurrentUser 
                                    ? 'bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-l-2xl rounded-tr-2xl' 
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
                                        $time = $createdAt->format('h:i A');
                                    } elseif (is_string($createdAt)) {
                                        $time = \Carbon\Carbon::parse($createdAt)->format('h:i A');
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
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="text-center py-8">
        <div class="text-3xl text-gray-300 mb-3">
            <i class="fas fa-comments"></i>
        </div>
        <p class="text-gray-500">No messages yet</p>
    </div>
@endif