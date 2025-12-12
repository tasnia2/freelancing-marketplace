<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'location',
        'bio',
        'role',
        'avatar',
        'title',
        'hourly_rate',
        'company'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string'
    ];

    // ========== NEW RELATIONSHIPS ==========

    // For clients: Jobs they posted
    public function jobsPosted()
    {
        return $this->hasMany(MarketplaceJob::class, 'client_id');
    }

    // For freelancers: Proposals they submitted
    public function proposals()
    {
        return $this->hasMany(JobProposal::class, 'freelancer_id');
    }

    // For freelancers: Accepted proposals
    public function acceptedProposals()
    {
        return $this->hasMany(JobProposal::class, 'freelancer_id')
                    ->where('status', 'accepted');
    }

    // Messages sent by user
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Messages received by user
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Reviews given by user
    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    // Reviews received by user
    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    // User's wallet
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    // Check if user is freelancer
    public function isFreelancer()
    {
        return $this->role === 'freelancer';
    }

    // Check if user is client
    public function isClient()
    {
        return $this->role === 'client';
    }

    // Get user's average rating
    public function getAverageRatingAttribute()
    {
        return $this->reviewsReceived()->avg('rating') ?? 0;
    }

    // Get user's total earnings (for freelancers)
    public function getTotalEarningsAttribute()
    {
        if (!$this->isFreelancer()) return 0;
        
        return $this->acceptedProposals()->sum('bid_amount');
    }

    // Get user's total spent (for clients)
    public function getTotalSpentAttribute()
    {
        if (!$this->isClient()) return 0;
        
        return $this->jobsPosted()
            ->whereHas('proposals', function($query) {
                $query->where('status', 'accepted');
            })
            ->withSum(['proposals as total_accepted' => function($query) {
                $query->where('status', 'accepted');
            }], 'bid_amount')
            ->get()
            ->sum('total_accepted');
    }
    public function isProfileComplete()
{
    return !empty($this->title) && 
           !empty($this->hourly_rate) && 
           !empty($this->bio) && 
           !empty($this->location);
}

public function getProfileCompletenessPercentage()
{
    $fields = ['title', 'hourly_rate', 'bio', 'location'];
    $completed = 0;
    
    foreach ($fields as $field) {
        if (!empty($this->$field)) {
            $completed++;
        }
    }
    
    return ($completed / count($fields)) * 100;
}
}