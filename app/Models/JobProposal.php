<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobProposal extends Model
{
    use HasFactory;

    protected $table = 'job_proposals';
    
    protected $fillable = [
        'job_id',
        'freelancer_id',
        'cover_letter',
        'bid_amount',
        'estimated_days',
        'status'
    ];

    protected $casts = [
        'bid_amount' => 'decimal:2'
    ];

    // Relationship with job
    public function job()
    {
        return $this->belongsTo(MarketplaceJob::class, 'job_id');
    }

    // Relationship with freelancer
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    // Get status badge color
    public function getStatusBadgeAttribute()
    {
        return [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'accepted' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800'
        ][$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}