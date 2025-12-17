<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MarketplaceJob extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'marketplace_jobs';
    
    protected $fillable = [
        'client_id', 'title', 'slug', 'description', 'job_type', 'budget',
        'hourly_rate', 'hours_per_week', 'experience_level', 'project_length',
        'skills_required', 'attachments', 'status', 'deadline', 'is_urgent',
        'is_featured', 'is_remote', 'featured_until'
    ];

    protected $casts = [
        'skills_required' => 'array',
        'attachments' => 'array',
        'budget' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
        'deadline' => 'datetime',
        'featured_until' => 'datetime',
        'is_urgent' => 'boolean',
        'is_featured' => 'boolean',
        'is_remote' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($job) {
            $job->slug = Str::slug($job->title) . '-' . Str::random(6);
        });
    }

    // Relationships
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function proposals()
    {
        return $this->hasMany(JobProposal::class, 'job_id');
    }

    public function acceptedProposal()
    {
        return $this->hasOne(JobProposal::class, 'job_id')->where('status', 'accepted');
    }

    public function contract()
    {
        return $this->hasOne(Contract::class, 'job_id');
    }

    public function savedByUsers()
    {
      
    return $this->belongsToMany(User::class, 'saved_jobs', 'marketplace_job_id', 'user_id')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                    ->where(function($q) {
                        $q->whereNull('featured_until')
                          ->orWhere('featured_until', '>', now());
                    });
    }

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeRemote($query)
    {
        return $query->where('is_remote', true);
    }

    public function scopeBySkills($query, array $skills)
    {
        return $query->where(function($q) use ($skills) {
            foreach ($skills as $skill) {
                $q->orWhereJsonContains('skills_required', $skill);
            }
        });
    }

    // Accessors
    public function getFormattedBudgetAttribute()
    {
        if ($this->job_type === 'hourly') {
            return '$' . number_format($this->hourly_rate, 2) . '/hr';
        }
        return '$' . number_format($this->budget, 0);
    }

    public function getBudgetRangeAttribute()
    {
        if ($this->job_type === 'hourly') {
            $weekly = $this->hourly_rate * ($this->hours_per_week ?? 40);
            $monthly = $weekly * 4;
            return '$' . number_format($this->hourly_rate, 2) . '/hr • $' . number_format($monthly, 0) . '/mo est.';
        }
        return '$' . number_format($this->budget, 0) . ' fixed';
    }

    public function getIsExpiredAttribute()
    {
        return $this->deadline && $this->deadline->isPast();
    }

    public function getTimeLeftAttribute()
    {
        if (!$this->deadline) return null;
        
        $diff = $this->deadline->diff(now());
        
        if ($diff->days > 30) {
            return floor($diff->days / 30) . ' months';
        } elseif ($diff->days > 0) {
            return $diff->days . ' days';
        } elseif ($diff->h > 0) {
            return $diff->h . ' hours';
        } else {
            return 'Less than an hour';
        }
    }

    public function getExperienceBadgeClassAttribute()
    {
        return [
            'entry' => 'bg-green-100 text-green-800',
            'intermediate' => 'bg-yellow-100 text-yellow-800',
            'expert' => 'bg-red-100 text-red-800',
        ][$this->experience_level] ?? 'bg-gray-100 text-gray-800';
    }

    public function getProjectLengthTextAttribute()
    {
        return [
            'less_than_1_month' => '< 1 Month',
            '1_to_3_months' => '1-3 Months',
            '3_to_6_months' => '3-6 Months',
            'more_than_6_months' => '> 6 Months',
        ][$this->project_length] ?? 'Not specified';
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function markAsFeatured($days = 7)
    {
        $this->update([
            'is_featured' => true,
            'featured_until' => now()->addDays($days)
        ]);
    }
}