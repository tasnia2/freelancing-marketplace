<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',        // job_posted, new_proposal, proposal_accepted, etc.
        'title',
        'message',
        'data',        // JSON data like job_id, proposal_id, etc.
        'read'         // boolean
    ];

    protected $casts = [
        'data' => 'array',
        'read' => 'boolean'
    ];

    /**
     * Get the user that owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update(['read' => true]);
        return $this;
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    /**
     * Scope for read notifications
     */
    public function scopeRead($query)
    {
        return $query->where('read', true);
    }

    /**
     * Scope by notification type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}