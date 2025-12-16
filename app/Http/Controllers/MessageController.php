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


class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get recent conversations
        $conversations = Message::selectRaw('
            CASE 
                WHEN sender_id = ? THEN receiver_id
                ELSE sender_id
            END as other_user_id,
            MAX(created_at) as last_message_time,
            COUNT(*) as message_count,
            SUM(CASE WHEN receiver_id = ? AND read = 0 THEN 1 ELSE 0 END) as unread_count
        ', [$user->id, $user->id])
        ->where('sender_id', $user->id)
        ->orWhere('receiver_id', $user->id)
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
        });
        
        // Get active jobs for filtering
        $activeJobs = $user->isClient() 
            ? $user->jobsPosted()->whereIn('status', ['open', 'in_progress'])->get()
            : $user->acceptedProposals()->with('job')->get()->pluck('job');
        
        // Get active contracts for filtering
        $activeContracts = $user->contracts()
            ->where('status', 'active')
            ->with(['job', $user->isClient() ? 'freelancer' : 'client'])
            ->get();
        
        return view('dashboard.client.messages', compact('conversations', 'activeJobs', 'activeContracts'));
    }
    
    public function show(User $user, Request $request)
    {
        $currentUser = Auth::user();
        
        // Mark all messages as read
        Message::betweenUsers($currentUser->id, $user->id)
            ->where('receiver_id', $currentUser->id)
            ->unread()
            ->update([
                'read' => true,
                'read_at' => now()
            ]);
        
        // Get messages
        $messages = Message::betweenUsers($currentUser->id, $user->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        // Get shared jobs
        $sharedJobs = MarketplaceJob::where(function($query) use ($currentUser, $user) {
                $query->where('client_id', $currentUser->id)
                      ->whereHas('proposals', function($q) use ($user) {
                          $q->where('freelancer_id', $user->id);
                      });
            })
            ->orWhere(function($query) use ($currentUser, $user) {
                $query->where('client_id', $user->id)
                      ->whereHas('proposals', function($q) use ($currentUser) {
                          $q->where('freelancer_id', $currentUser->id);
                      });
            })
            ->get();
        
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
                'messages' => $messages,
                'html' => view('dashboard.client.partials.messages-list', compact('messages'))->render()
            ]);
        }
        
        return view('dashboard.client.messages-show', compact('user', 'messages', 'sharedJobs', 'sharedContracts'));
    }
    
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:5000',
            'job_id' => 'nullable|exists:marketplace_jobs,id',
            'contract_id' => 'nullable|exists:contracts,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
        ]);
        
        // Handle attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('message_attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                    'url' => Storage::url($path)
                ];
            }
        }
        
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'job_id' => $validated['job_id'] ?? null,
            'contract_id' => $validated['contract_id'] ?? null,
            'message' => $validated['message'],
            'attachments' => $attachments,
            'read' => false,
        ]);
        
        // Create notification for receiver
        $user->notifications()->create([
            'type' => 'message_received',
            'title' => 'New Message',
            'message' => Auth::user()->name . ' sent you a message',
            'data' => json_encode([
                'message_id' => $message->id,
                'sender_id' => Auth::id(),
                'sender_name' => Auth::user()->name
            ]),
            'read' => false,
        ]);
        
        // Broadcast event for real-time
        broadcast(new \App\Events\MessageSent($message))->toOthers();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender')
            ]);
        }
        
        return redirect()->back()->with('success', 'Message sent!');
    }
    
    public function getUnreadCount()
    {
        $count = Auth::user()->unreadMessagesCount();
        return response()->json(['count' => $count]);
    }
    
    public function markAllAsRead(User $user = null)
    {
        $query = Message::where('receiver_id', Auth::id())
            ->unread();
        
        if ($user) {
            $query->where('sender_id', $user->id);
        }
        
        $query->update([
            'read' => true,
            'read_at' => now()
        ]);
        
        return response()->json(['success' => true]);
    }
    
    public function getConversations()
    {
        $user = Auth::user();
        
        $conversations = Message::selectRaw('
            CASE 
                WHEN sender_id = ? THEN receiver_id
                ELSE sender_id
            END as other_user_id,
            MAX(created_at) as last_message_time,
            SUM(CASE WHEN receiver_id = ? AND read = 0 THEN 1 ELSE 0 END) as unread_count
        ', [$user->id, $user->id])
        ->where('sender_id', $user->id)
        ->orWhere('receiver_id', $user->id)
        ->groupBy('other_user_id')
        ->orderBy('last_message_time', 'desc')
        ->limit(20)
        ->get()
        ->map(function($convo) use ($user) {
            $otherUser = User::find($convo->other_user_id);
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
        });
        
        return response()->json(['conversations' => $conversations]);
    }
}