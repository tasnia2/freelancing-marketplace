<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\MarketplaceJob;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Events\MessageSent;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get recent conversations using the scope from model
        $conversations = Message::where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->unique(function($message) use ($user) {
            return $message->other_user_id;
        })
        ->map(function($message) use ($user) {
            $otherUser = $message->other_user;
            
            if (!$otherUser) return null;
            
            return [
                'user' => $otherUser,
                'last_message' => $message,
                'unread_count' => Message::where('sender_id', $otherUser->id)
                    ->where('receiver_id', $user->id)
                    ->where('read', false)
                    ->count(),
                'last_message_time' => $message->created_at
            ];
        })->filter();
        
        // Get active jobs for filtering
        if ($user->isClient()) {
            $activeJobs = $user->jobsPosted()->whereIn('status', ['open', 'in_progress'])->get();
        } else {
            $activeJobs = MarketplaceJob::whereHas('proposals', function($query) use ($user) {
                $query->where('freelancer_id', $user->id)
                      ->whereIn('status', ['accepted', 'pending']);
            })->whereIn('status', ['open', 'in_progress'])->get();
        }
        
        // Get active contracts
        $activeContracts = $user->contracts()
            ->where('status', 'active')
            ->with(['job', $user->isClient() ? 'freelancer' : 'client'])
            ->get();
        
        // Return view based on role
        $view = $user->isClient() ? 'dashboard.client.messages' : 'dashboard.freelancer.messages';
        return view($view, compact('conversations', 'activeJobs', 'activeContracts'));
    }
    
    public function show(User $user, Request $request)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->id === $user->id) {
            return redirect()->route('messages.index')->with('error', 'You cannot message yourself.');
        }
        
        // Mark messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUser->id)
            ->where('read', false)
            ->update([
                'read' => true,
                'read_at' => now()
            ]);
        
        // Get messages using the model scope
        $messages = Message::withUser($user->id)->paginate(30);
        
        // Get shared jobs
        if ($currentUser->isClient()) {
            $sharedJobs = MarketplaceJob::where('client_id', $currentUser->id)
                ->whereHas('proposals', function($q) use ($user) {
                    $q->where('freelancer_id', $user->id);
                })->get();
        } else {
            $sharedJobs = MarketplaceJob::where('client_id', $user->id)
                ->whereHas('proposals', function($q) use ($currentUser) {
                    $q->where('freelancer_id', $currentUser->id);
                })->get();
        }
        
        // Get shared contracts
        $sharedContracts = Contract::where(function($query) use ($currentUser, $user) {
                $query->where('client_id', $currentUser->id)
                      ->where('freelancer_id', $user->id);
            })
            ->orWhere(function($query) use ($currentUser, $user) {
                $query->where('client_id', $user->id)
                      ->where('freelancer_id', $currentUser->id);
            })
            ->get();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'messages' => $messages->items(),
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                    'company' => $user->company,
                    'title' => $user->title
                ]
            ]);
        }
        
        // Return view based on role
        $view = $currentUser->isClient() ? 'dashboard.client.messages-show' : 'dashboard.freelancer.messages-show';
        return view($view, compact('user', 'messages', 'sharedJobs', 'sharedContracts'));
    }
    
    // NEW: API endpoint to get messages (for polling/refreshing)
    public function getMessagesApi(User $user)
    {
        try {
            $currentUser = Auth::user();
            
            $messages = Message::withUser($user->id)
                ->with(['sender', 'receiver'])
                ->orderBy('created_at', 'asc')
                ->get();
            
            return response()->json([
                'success' => true,
                'messages' => $messages,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request, User $user)
    {
        \Log::info('=== MESSAGE SEND ATTEMPT ===');
        \Log::info('Auth ID: ' . Auth::id());
        \Log::info('Receiver ID: ' . $user->id);
        \Log::info('Request data: ' . json_encode($request->all()));

        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Authentication required.'
                ], 401);
            }

            if (Auth::id() === $user->id) {
                return response()->json([
                    'success' => false,
                    'error' => 'You cannot message yourself.'
                ], 422);
            }

            $validated = $request->validate([
                'message' => 'required|string|max:1000',
                'job_id' => 'nullable|exists:marketplace_jobs,id',
                'contract_id' => 'nullable|exists:contracts,id',
            ]);

            \Log::info('Validation passed');

            // Create message
            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $user->id,
                'job_id' => $validated['job_id'] ?? null,
                'contract_id' => $validated['contract_id'] ?? null,
                'message' => $validated['message'],
                'attachments' => json_encode([]),
                'read' => false,
                'read_at' => null,
            ]);

            \Log::info('Message created with ID: ' . $message->id);

            // Load relationships
            $message->load(['sender', 'receiver']);
            
            // BROADCAST THE EVENT - THIS IS CRITICAL
            // IMPORTANT: Don't call toOthers() twice, it should be once
            broadcast(new MessageSent($message));
            
            // If you want to exclude the sender from the broadcast, use:
            // broadcast(new MessageSent($message))->toOthers();

            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'created_at' => $message->created_at->toISOString(),
                    'formatted_time' => $message->formatted_time,
                    'sender' => [
                        'id' => $message->sender->id,
                        'name' => $message->sender->name,
                        'avatar' => $message->sender->profile->avatar ?? null
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('ERROR in store(): ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'error' => 'Failed to send message: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function getUnreadCount()
    {
        try {
            $count = Message::where('receiver_id', Auth::id())
                ->where('read', false)
                ->count();
                
            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            \Log::error('Get unread count failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'count' => 0
            ]);
        }
    }
    
    public function markAllAsRead(User $user)
    {
        try {
            $updated = Message::where('sender_id', $user->id)
                ->where('receiver_id', Auth::id())
                ->where('read', false)
                ->update([
                    'read' => true,
                    'read_at' => now()
                ]);
            
            return response()->json([
                'success' => true,
                'updated' => $updated
            ]);
        } catch (\Exception $e) {
            \Log::error('Mark all as read failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to mark messages as read'
            ], 500);
        }
    }
    
    public function getConversationsApi()
    {
        try {
            $user = Auth::user();
            
            // Get unique conversations
            $messages = Message::where(function($query) use ($user) {
                    $query->where('sender_id', $user->id)
                          ->orWhere('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->get();
            
            $conversations = [];
            $processedUsers = [];
            
            foreach ($messages as $message) {
                $otherUserId = $message->other_user_id;
                
                if (in_array($otherUserId, $processedUsers)) {
                    continue;
                }
                
                $otherUser = $message->other_user;
                
                if (!$otherUser) continue;
                
                $unreadCount = Message::where('sender_id', $otherUserId)
                    ->where('receiver_id', $user->id)
                    ->where('read', false)
                    ->count();
                
                $lastMessage = Message::withUser($otherUserId)
                    ->latest()
                    ->first();
                
                $conversations[] = [
                    'user' => [
                        'id' => $otherUser->id,
                        'name' => $otherUser->name,
                        'role' => $otherUser->role,
                        'company' => $otherUser->company,
                        'title' => $otherUser->title,
                        'avatar' => $otherUser->avatar,
                    ],
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                    'last_message_time' => $lastMessage ? $lastMessage->created_at : null
                ];
                
                $processedUsers[] = $otherUserId;
            }
            
            return response()->json([
                'success' => true,
                'conversations' => $conversations
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Get conversations API error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load conversations'
            ], 500);
        }
    }
}