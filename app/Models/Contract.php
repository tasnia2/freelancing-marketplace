<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'client_id', 'freelancer_id', 'title', 'description', 
        'amount', 'status', 'start_date', 'end_date', 'terms', 'attachments'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'terms' => 'array',
        'attachments' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function job()
    {
        return $this->belongsTo(MarketplaceJob::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    // Check if user can view contract
    public function canView($userId)
    {
        return $this->client_id == $userId || $this->freelancer_id == $userId;
    }
    public function getProgressPercentage()
{
    if ($this->status === 'completed') {
        return 100;
    }
    
    if ($this->status === 'draft') {
        return 0;
    }
    
    // Calculate progress based on time elapsed
    $totalDays = $this->start_date->diffInDays($this->end_date);
    $daysPassed = $this->start_date->diffInDays(now());
    
    if ($totalDays > 0) {
        $progress = ($daysPassed / $totalDays) * 100;
        return min(max(0, $progress), 100); // Ensure between 0-100
    }
    
    return 50; // Default
}
public function daysRemaining()
{
    if ($this->status === 'completed') {
        return 0;
    }
    
    if ($this->end_date->isPast()) {
        return 0; // Overdue
    }
    
    return now()->diffInDays($this->end_date);
}
}