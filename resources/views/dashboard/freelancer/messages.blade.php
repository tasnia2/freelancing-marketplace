@extends('layouts.client') {{-- Or create freelancer layout --}}

@section('title', 'Messages - WorkNest')

@section('header')
<div class="flex justify-between items-center">
    <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
        Messages
    </h2>
    <button class="px-4 py-2 bg-gradient-to-r from-[#456882] to-[#234C6A] text-white rounded-xl hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
        <i class="fas fa-plus mr-2"></i> New Message
    </button>
</div>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Messages interface similar to client messages -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Conversations List -->
            <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Conversations</h3>
                <div class="space-y-3">
                    @forelse($conversations as $conversation)
                    <a href="{{ route('messages.show', $conversation['user']) }}" 
                       class="flex items-center p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300 {{ request()->route('user') && request()->route('user')->id == $conversation['user']->id ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white mr-3">
                            {{ substr($conversation['user']->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h4 class="font-medium text-gray-800 dark:text-white truncate">
                                    {{ $conversation['user']->name }}
                                    @if($conversation['user']->isClient())
                                        <span class="text-xs text-green-600 dark:text-green-400">(Client)</span>
                                    @endif
                                </h4>
                                <span class="text-xs text-gray-500">{{ $conversation['last_message_time']->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 truncate mt-1">
                                {{ $conversation['last_message']->message ?? 'No messages yet' }}
                            </p>
                        </div>
                        @if($conversation['unread_count'] > 0)
                            <span class="ml-2 w-6 h-6 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                {{ $conversation['unread_count'] }}
                            </span>
                        @endif
                    </a>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-comments text-3xl mb-2"></i>
                        <p>No conversations yet</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Message Area -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <div class="h-full flex flex-col">
                    <div class="text-center py-12">
                        <i class="fas fa-comment-dots text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                        <h3 class="text-lg font-medium text-gray-600 dark:text-gray-400">Select a conversation</h3>
                        <p class="text-gray-500 dark:text-gray-500 mt-1">Choose a conversation from the list to start messaging</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection