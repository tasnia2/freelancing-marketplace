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
use App\Events\MessageSent; // Add this if using broadcasting


class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get recent conversations - FIXED QUERY
        $conversations = Message::selectRaw('
            CASE 
                WHEN sender_id = ? THEN receiver_id
                ELSE sender_id
            END as other_user_id,
            MAX(created_at) as last_message_time,
            COUNT(*) as message_count,
            SUM(CASE WHEN receiver_id = ? AND `read` = 0 THEN 1 ELSE 0 END) as unread_count
        ', [$user->id, $user->id])
        ->where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })
        ->groupBy('other_user_id')
        ->orderBy('last_message_time', 'desc')
        ->get();
        
        // Get user details for each conversation
        $conversations = $conversations->map(function($convo) use ($user) {
            $otherUser = User::find($convo->other_user_id);
            $lastMessage = Message::betweenUsers($user->id, $convo->other_user_id)
                ->latest()
                ->first();
            
            return [
                'user' => $otherUser,
                'last_message' => $lastMessage,
                'unread_count' => $convo->unread_count,
                'message_count' => $convo->message_count,
                'last_message_time' => $convo->last_message_time
            ];
        })->filter(function($convo) {
            return $convo['user'] !== null; // Filter out null users
        });
        
        // Get active jobs for filtering - Role based
        if ($user->isClient()) {
            $activeJobs = $user->jobsPosted()->whereIn('status', ['open', 'in_progress'])->get();
        } else {
            // For freelancers: jobs they've applied to or are working on
            $activeJobs = MarketplaceJob::whereHas('proposals', function($query) use ($user) {
                $query->where('freelancer_id', $user->id)
                      ->whereIn('status', ['accepted', 'pending']);
            })->whereIn('status', ['open', 'in_progress'])->get();
        }
        
        // Get active contracts for filtering
        $activeContracts = $user->contracts()
            ->where('status', 'active')
            ->with(['job', $user->isClient() ? 'freelancer' : 'client'])
            ->get();
        
        // Return appropriate view based on role
        if ($user->isClient()) {
            return view('dashboard.client.messages', compact('conversations', 'activeJobs', 'activeContracts'));
        } else {
            return view('dashboard.freelancer.messages', compact('conversations', 'activeJobs', 'activeContracts'));
        }
    }
    
    public function show(User $user, Request $request)
    {
        $currentUser = Auth::user();
        
        // Check if user is trying to message themselves
        if ($currentUser->id === $user->id) {
            return redirect()->route('messages.index')->with('error', 'You cannot message yourself.');
        }
        
        // Mark all messages as read
        Message::betweenUsers($currentUser->id, $user->id)
            ->where('receiver_id', $currentUser->id)
            ->unread()
            ->update([
                'read' => true,
                'read_at' => now()
            ]);
        
        // Get messages with pagination
        $messages = Message::betweenUsers($currentUser->id, $user->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')  // Change 'desc' to 'asc'
            ->paginate(30); // Reduced from 50 for better performance
        
        // Get shared jobs
        if ($currentUser->isClient()) {
            $sharedJobs = MarketplaceJob::where(function($query) use ($currentUser, $user) {
                $query->where('client_id', $currentUser->id)
                      ->whereHas('proposals', function($q) use ($user) {
                          $q->where('freelancer_id', $user->id);
                      });
            })->get();
        } else {
            $sharedJobs = MarketplaceJob::where(function($query) use ($currentUser, $user) {
                $query->where('client_id', $user->id)
                      ->whereHas('proposals', function($q) use ($currentUser) {
                          $q->where('freelancer_id', $currentUser->id);
                      });
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
            $partialView = $currentUser->isClient() ? 'dashboard.client.partials.messages-list' : 'dashboard.freelancer.partials.messages-list';
            return response()->json([
                'success' => true,
                'messages' => $messages,
                'html' => view($partialView, compact('messages'))->render()
            ]);
        }
        
        // Return appropriate view based on role
        if ($currentUser->isClient()) {
            return view('dashboard.client.messages-show', compact('user', 'messages', 'sharedJobs', 'sharedContracts'));
        } else {
            return view('dashboard.freelancer.messages-show', compact('user', 'messages', 'sharedJobs', 'sharedContracts'));
        }
    }
    
   public function store(Request $request, User $user)
{
    // Log everything for debugging
    \Log::info('=== MESSAGE SEND ATTEMPT ===');
    \Log::info('Auth ID: ' . Auth::id());
    \Log::info('Receiver ID: ' . $user->id);
    \Log::info('Is AJAX: ' . ($request->ajax() ? 'Yes' : 'No'));
    \Log::info('Request data: ' . json_encode($request->all()));

    try {
        // Check if messaging self
        if (Auth::id() === $user->id) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'You cannot message yourself.'
                ], 422);
            }
            return redirect()->back()->with('error', 'You cannot message yourself.');
        }

        // Simple validation - remove attachments for now
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'job_id' => 'nullable|exists:marketplace_jobs,id',
            'contract_id' => 'nullable|exists:contracts,id',
        ]);

        \Log::info('Validation passed');

        // Create message WITHOUT attachments for now
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'job_id' => $validated['job_id'] ?? null,
            'contract_id' => $validated['contract_id'] ?? null,
            'message' => $validated['message'],
            'attachments' => [], // Empty for now
            'read' => false,
        ]);

        \Log::info('Message created with ID: ' . $message->id);

        // Load sender relationship
        $message->load('sender');

        // Prepare data for the partial view
        $messageData = [
            'id' => $message->id,
            'message' => $message->message,
            'created_at' => $message->created_at->toDateTimeString(),
            'formatted_time' => $message->created_at->diffForHumans(),
            'sender' => [
                'id' => $message->sender->id,
                'name' => $message->sender->name,
                'avatar' => $message->sender->profile->avatar ?? null
            ]
        ];

        \Log::info('Message data prepared');

        // Check which partial to use
        $partialView = auth()->$user->id->isClient() 
            ? 'dashboard.client.partials.messages-list'
            : 'dashboard.freelancer.partials.messages-list';

        \Log::info('Using partial: ' . $partialView);

        if ($request->ajax()) {
            \Log::info('Sending JSON response');
            return response()->json([
                'success' => true,
                'message' => $messageData,
                'html' => view($partialView, ['message' => $messageData])->render()
            ]);
        }

        return redirect()->back()->with('success', 'Message sent!');

    } catch (\Exception $e) {
        \Log::error('ERROR in store(): ' . $e->getMessage());
        \Log::error('File: ' . $e->getFile());
        \Log::error('Line: ' . $e->getLine());
        \Log::error('Trace: ' . $e->getTraceAsString());

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to send message: ' . $e->getMessage(),
                'debug' => env('APP_DEBUG') ? [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ] : null
            ], 500);
        }

        return redirect()->back()->with('error', 'Failed to send message.');
    }
}
    public function getUnreadCount()
    {
        try {
            $count = Auth::user()->unreadMessagesCount();
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
    
    public function markAllAsRead(User $user = null)
    {
        try {
            $query = Message::where('receiver_id', Auth::id())
                ->unread();
            
            if ($user) {
                $query->where('sender_id', $user->id);
            }
            
            $updated = $query->update([
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
    
    public function getConversations()
    {
        try {
            $user = Auth::user();
            
            $conversations = Message::selectRaw('
                CASE 
                    WHEN sender_id = ? THEN receiver_id
                    ELSE sender_id
                END as other_user_id,
                MAX(created_at) as last_message_time,
                SUM(CASE WHEN receiver_id = ? AND `read` = 0 THEN 1 ELSE 0 END) as unread_count
            ', [$user->id, $user->id])
            ->where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->groupBy('other_user_id')
            ->orderBy('last_message_time', 'desc')
            ->limit(20)
            ->get()
            ->map(function($convo) use ($user) {
                $otherUser = User::find($convo->other_user_id);
                if (!$otherUser) return null;
                
                $lastMessage = Message::betweenUsers($user->id, $convo->other_user_id)
                    ->latest()
                    ->first();
                
                return [
                    'user' => [
                        'id' => $otherUser->id,
                        'name' => $otherUser->name,
                        'avatar' => $otherUser->getAvatarUrl(),
                        'role' => $otherUser->role
                    ],
                    'last_message' => $lastMessage ? [
                        'message' => Str::limit($lastMessage->message, 50),
                        'time' => $lastMessage->formatted_time,
                        'is_from_me' => $lastMessage->sender_id === $user->id
                    ] : null,
                    'unread_count' => $convo->unread_count
                ];
            })->filter(); // Remove null items
            
            return response()->json([
                'success' => true,
                'conversations' => $conversations->values() // Reset keys
            ]);
        } catch (\Exception $e) {
            \Log::error('Get conversations failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'conversations' => []
            ]);
        }
    }
}