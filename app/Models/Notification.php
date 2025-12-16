<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read'
    ];

    protected $casts = [
        'data' => 'array',
        'read' => 'boolean'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->latest()->limit($limit);
    }

    // Accessors
    public function getIconAttribute()
    {
        return [
            'job_posted' => 'fas fa-briefcase',
            'new_proposal' => 'fas fa-file-alt',
            'proposal_accepted' => 'fas fa-check-circle',
            'proposal_rejected' => 'fas fa-times-circle',
            'contract_created' => 'fas fa-file-contract',
            'contract_completed' => 'fas fa-check-double',
            'message_received' => 'fas fa-comment',
            'payment_received' => 'fas fa-dollar-sign',
            'system' => 'fas fa-cog'
        ][$this->type] ?? 'fas fa-bell';
    }

    public function getColorAttribute()
    {
        return [
            'job_posted' => 'text-blue-600',
            'new_proposal' => 'text-green-600',
            'proposal_accepted' => 'text-green-600',
            'proposal_rejected' => 'text-red-600',
            'contract_created' => 'text-purple-600',
            'contract_completed' => 'text-green-600',
            'message_received' => 'text-indigo-600',
            'payment_received' => 'text-green-600',
            'system' => 'text-gray-600'
        ][$this->type] ?? 'text-gray-600';
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // Mark as read
    public function markAsRead()
    {
        $this->update(['read' => true]);
    }
    
}