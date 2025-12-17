<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reviewee_id',
        'reviewer_id', 
        'job_id',
        'contract_id',
        'rating',
        'comment',
        'type',
        'is_public',
        'is_recommended',
        'strengths',
        'weaknesses',
        'reviewed_at'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_public' => 'boolean',
        'is_recommended' => 'boolean',
        'strengths' => 'array',
        'weaknesses' => 'array',
        'reviewed_at' => 'datetime'
    ];

    // Relationships
    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function job()
    {
        return $this->belongsTo(MarketplaceJob::class, 'job_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    // Accessors
    public function getAverageRatingAttribute()
    {
        return $this->rating;
    }

    public function getReviewTypeTextAttribute()
    {
        return $this->type === 'client_to_freelancer' ? 'Client Review' : 'Freelancer Review';
    }
}