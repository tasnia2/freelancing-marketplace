<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketplaceJob extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'marketplace_jobs';
    
    protected $fillable = [
        'client_id',
        'title',
        'description',
        'job_type',
        'budget',
        'experience_level',
        'status',
        'skills',
        'views',
        'deadline'
    ];

    protected $casts = [
        'skills' => 'array',
        'budget' => 'decimal:2',
        'deadline' => 'datetime'
    ];

    // Relationship with client
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relationship with proposals
    public function proposals()
    {
        return $this->hasMany(JobProposal::class, 'job_id');
    }

    // Get job type badge color
    public function getJobTypeBadgeAttribute()
    {
        return [
            'fixed' => 'bg-blue-100 text-blue-800',
            'hourly' => 'bg-green-100 text-green-800'
        ][$this->job_type] ?? 'bg-gray-100 text-gray-800';
    }

    // Get experience level badge
    public function getExperienceBadgeAttribute()
    {
        return [
            'entry' => 'bg-green-100 text-green-800',
            'intermediate' => 'bg-yellow-100 text-yellow-800',
            'expert' => 'bg-red-100 text-red-800'
        ][$this->experience_level] ?? 'bg-gray-100 text-gray-800';
    }

    // Check if job is urgent (less than 3 days)
    public function getIsUrgentAttribute()
    {
        return $this->deadline && $this->deadline->diffInDays(now()) < 3;
    }

    // Format budget display
    public function getFormattedBudgetAttribute()
    {
        if ($this->job_type === 'hourly') {
            return '$' . number_format($this->budget, 2) . '/hr';
        }
        return '$' . number_format($this->budget, 2);
    }
}