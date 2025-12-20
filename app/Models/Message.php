<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'job_id',
        'contract_id',
        'message',
        'attachments',
        'read',
        'read_at'
    ];

    protected $casts = [
        'attachments' => 'array',
        'read' => 'boolean',
        'read_at' => 'datetime'
    ];

    protected $appends = [
        'is_from_current_user',
        'formatted_time',
        'is_unread',
        'sender_name',
        'receiver_name',
    ];

    // Relationships
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function job()
    {
        return $this->belongsTo(MarketplaceJob::class, 'job_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    // public function scopeBetweenUsers($query, $user1Id, $user2Id)
    // {
    //     return $query->where(function($q) use ($user1Id, $user2Id) {
    //         $q->where('sender_id', $user1Id)
    //           ->where('receiver_id', $user2Id);
    //     })->orWhere(function($q) use ($user1Id, $user2Id) {
    //         $q->where('sender_id', $user2Id)
    //           ->where('receiver_id', $user1Id);
    //     });
    // }

    public function scopeForJob($query, $jobId)
    {
        return $query->where('job_id', $jobId);
    }

    public function scopeForContract($query, $contractId)
    {
        return $query->where('contract_id', $contractId);
    }

    // Get messages for current user (both sent and received)
    public function scopeForCurrentUser($query)
    {
        if (Auth::check()) {
            return $query->where('sender_id', Auth::id())
                        ->orWhere('receiver_id', Auth::id());
        }
        return $query;
    }

    // Get conversations for current user
    public function scopeConversations($query)
    {
        if (Auth::check()) {
            return $query->select('*')
                ->addSelect(\DB::raw('GREATEST(sender_id, receiver_id) as user1'))
                ->addSelect(\DB::raw('LEAST(sender_id, receiver_id) as user2'))
                ->where('sender_id', Auth::id())
                ->orWhere('receiver_id', Auth::id())
                ->groupBy('user1', 'user2')
                ->orderBy('created_at', 'desc');
        }
        return $query;
    }

    // Get messages with a specific user
    public function scopeWithUser($query, $userId)
    {
        if (Auth::check()) {
            return $query->where(function($q) use ($userId) {
                $q->where('sender_id', Auth::id())
                  ->where('receiver_id', $userId);
            })->orWhere(function($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc');
        }
        return $query;
    }

    // Accessors
    public function getFormattedTimeAttribute()
    {
        if ($this->created_at->isToday()) {
            return $this->created_at->format('g:i A');
        } elseif ($this->created_at->isYesterday()) {
            return 'Yesterday ' . $this->created_at->format('g:i A');
        } else {
            return $this->created_at->format('M j, g:i A');
        }
    }
    

    public function getIsFromCurrentUserAttribute()
    {
        return Auth::check() && $this->sender_id === Auth::id();
    }

    public function getIsUnreadAttribute()
    {
        return Auth::check() && 
               $this->receiver_id === Auth::id() && 
               !$this->read;
    }

    public function getSenderNameAttribute()
    {
        return $this->sender ? $this->sender->name : 'Unknown User';
    }

    public function getReceiverNameAttribute()
    {
        return $this->receiver ? $this->receiver->name : 'Unknown User';
    }

    // Get the other user in conversation
    public function getOtherUserAttribute()
    {
        if (!Auth::check()) {
            return null;
        }
        
        if ($this->sender_id === Auth::id()) {
            return $this->receiver;
        } else {
            return $this->sender;
        }
    }

    // Get the other user's ID
    public function getOtherUserIdAttribute()
    {
        if (!Auth::check()) {
            return null;
        }
        
        return $this->sender_id === Auth::id() ? $this->receiver_id : $this->sender_id;
    }

    // Check if current user is part of this message
    public function getIsParticipantAttribute()
    {
        return Auth::check() && 
               ($this->sender_id === Auth::id() || $this->receiver_id === Auth::id());
    }

    // Get message status for current user
    public function getStatusAttribute()
    {
        if (!Auth::check()) {
            return 'unknown';
        }
        
        if ($this->sender_id === Auth::id()) {
            return $this->read ? 'read' : 'sent';
        } else {
            return $this->read ? 'received_read' : 'received_unread';
        }
    }

    // Get attachment count
    public function getAttachmentCountAttribute()
    {
        return $this->attachments ? count($this->attachments) : 0;
    }

    // Get first attachment (if any)
    public function getFirstAttachmentAttribute()
    {
        return $this->attachments ? ($this->attachments[0] ?? null) : null;
    }

    // Check if message has attachments
    public function getHasAttachmentsAttribute()
    {
        return !empty($this->attachments);
    }

    // Mark as read
    public function markAsRead()
    {
        if (!$this->read && Auth::check() && $this->receiver_id === Auth::id()) {
            $this->update([
                'read' => true,
                'read_at' => now()
            ]);
            return true;
        }
        return false;
    }

    // Mark all messages from a user as read
    public static function markAllAsReadFromUser($userId)
    {
        if (Auth::check()) {
            return self::where('sender_id', $userId)
                ->where('receiver_id', Auth::id())
                ->where('read', false)
                ->update([
                    'read' => true,
                    'read_at' => now()
                ]);
        }
        return 0;
    }

    // Get unread count for current user
    public static function getUnreadCount()
    {
        if (Auth::check()) {
            return self::where('receiver_id', Auth::id())
                ->where('read', false)
                ->count();
        }
        return 0;
    }

    // Get unread count from specific user
    public static function getUnreadCountFromUser($userId)
    {
        if (Auth::check()) {
            return self::where('sender_id', $userId)
                ->where('receiver_id', Auth::id())
                ->where('read', false)
                ->count();
        }
        return 0;
    }

    // Get last message in conversation
    public static function getLastMessageWithUser($userId)
    {
        if (Auth::check()) {
            return self::withUser($userId)
                ->latest()
                ->first();
        }
        return null;
    }

    // Create a new message
    public static function createMessage($receiverId, $content, $jobId = null, $contractId = null, $attachments = [])
    {
        if (!Auth::check()) {
            return null;
        }

        return self::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'job_id' => $jobId,
            'contract_id' => $contractId,
            'message' => $content,
            'attachments' => $attachments,
            'read' => false,
        ]);
    }
}