<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'client_id', 
        'freelancer_id',
        'amount',
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'milestones',
        'attachments',
        'terms',
        'termination_reason'
    ];

    protected $casts = [
        'milestones' => 'array',
        'attachments' => 'array',
        'terms' => 'array',
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /**
     * Get the job associated with the contract
     */
    public function job()
    {
        return $this->belongsTo(MarketplaceJob::class, 'job_id');
    }

    /**
     * Get the client (user who posted the job)
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the freelancer (user who accepted the job)
     */
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    /**
     * Scope for active contracts
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for completed contracts
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for draft contracts
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Check if contract is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if contract is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if contract is draft
     */
    public function isDraft()
    {
        return $this->status === 'draft';
    }

    /**
     * Calculate days remaining
     */
    public function daysRemaining()
    {
        if (!$this->end_date) {
            return null;
        }
        
        $end = \Carbon\Carbon::parse($this->end_date);
        $now = \Carbon\Carbon::now();
        
        return $now->diffInDays($end, false); // Negative if overdue
    }

    /**
     * Get progress percentage based on milestones
     */
    public function getProgressPercentage()
    {
        if (!$this->milestones) {
            return 0;
        }
        
        $milestones = $this->milestones;
        $completed = collect($milestones)->filter(function($milestone) {
            return $milestone['completed'] ?? false;
        })->count();
        
        return count($milestones) > 0 ? round(($completed / count($milestones)) * 100) : 0;
    }
}