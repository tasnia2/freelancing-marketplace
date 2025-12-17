<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use App\Models\Notification;
use App\Models\MarketplaceJob;


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
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    
    public function jobsPosted()
    {
        return $this->hasMany(MarketplaceJob::class, 'client_id');
    }
    
    public function savedJobs()
    {
       return $this->belongsToMany(MarketplaceJob::class, 'saved_jobs', 'user_id', 'marketplace_job_id')
                ->withTimestamps();
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
    
    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
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
    
    public function notifications()
    {
        return $this->hasMany(Notification::class);
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
    
    // ========== ADD THESE NEW METHODS ==========
    
    /**
     * Get avatar URL - displays uploaded avatar or generates default
     */
    public function getAvatarUrl()
    {
        if ($this->avatar && Storage::exists('public/' . $this->avatar)) {
            return asset('storage/' . $this->avatar);
        }
        
        // Default avatar with purple color
        $colors = ['#8B5CF6', '#7C3AED', '#6D28D9', '#5B21B6'];
        $color = $colors[crc32($this->name) % count($colors)];
        
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . 
               "&color=FFFFFF&background=" . substr($color, 1);
    }
    
    /**
     * Get display name - either company name for clients or personal name
     */
    public function getDisplayName()
    {
        if ($this->isClient() && $this->company) {
            return $this->company;
        }
        return $this->name;
    }
    
    
    /**
     * Check if profile is complete based on role
     */
    public function isProfileCompleteRoleBased()
    {
        if ($this->isFreelancer()) {
            return !empty($this->title) && 
                   !empty($this->hourly_rate) && 
                   !empty($this->bio) && 
                   !empty($this->location);
        } else {
            return !empty($this->company) && 
                   !empty($this->location);
        }
    }
    
    /**
     * Get profile completeness percentage based on role
     */
    public function getProfileCompletenessPercentageRoleBased()
    {
        if ($this->isFreelancer()) {
            $fields = ['title', 'hourly_rate', 'bio', 'location', 'avatar'];
        } else {
            $fields = ['company', 'location', 'avatar'];
        }
        
        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }
        
        return round(($completed / count($fields)) * 100);
    }
    
    /**
     * Get unread notifications count
     */
    public function unreadNotificationsCount()
    {
        return $this->notifications()->where('read', false)->count();
    }
    
    /**
     * Get unread messages count
     */
    public function unreadMessagesCount()
    {
      try {
        // Check if messages table exists
        if (!Schema::hasTable('messages')) {
            return 0;
        }
        
        // Check if receiver_id column exists
        $columns = Schema::getColumnListing('messages');
        if (!in_array('receiver_id', $columns)) {
            return 0;
        }
        
        return $this->receivedMessages()->where('read', false)->count();
      } catch (\Exception $e) {
        return 0;
      }
    }
    
    /**
     * Get user's headline/title
     */
    public function getHeadlineAttribute()
    {
        if ($this->isFreelancer()) {
            return $this->title ?? 'Freelancer';
        } else {
            return $this->company ? $this->company . ' (Client)' : 'Client';
        }
    }
    
    /**
     * Get user's primary skill/tag
     */
    public function getPrimarySkillAttribute()
    {
        if ($this->profile && $this->profile->skills) {
            $skills = json_decode($this->profile->skills, true);
            return $skills[0] ?? ($this->isFreelancer() ? 'Web Development' : 'Business');
        }
        return $this->isFreelancer() ? 'Web Development' : 'Business';
    }

    // Contracts where user is client
    public function clientContracts()
    {
        return $this->hasMany(Contract::class, 'client_id');
    }

    // Contracts where user is freelancer  
    public function freelancerContracts()
    {
        return $this->hasMany(Contract::class, 'freelancer_id');
    }

    // All contracts for the user (both as client and freelancer)
    public function contracts()
    {
        // If you want to merge both relationships
        return Contract::where('client_id', $this->id)
            ->orWhere('freelancer_id', $this->id);
    }

    // Get contracts count based on status
    public function contractsCount($status = null)
    {
        $query = Contract::where(function($q) {
            $q->where('client_id', $this->id)
              ->orWhere('freelancer_id', $this->id);
        });
        
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query->count();
    }
     public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    public function sentTransactions()
    {
        return $this->hasMany(Transaction::class, 'payer_id');
    }
    
    public function portfolioItems()
    {
        return $this->hasMany(Portfolio::class);
    }
    
    public function education()
    {
        return $this->hasMany(Education::class);
    }
    
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
    
    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }
    
    // public function wallet()
    // {
    //     return $this->hasOne(Wallet::class);
    // }
    
    
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
    
    public function disputes()
    {
        return $this->hasMany(Dispute::class, 'client_id')
            ->orWhere('freelancer_id', $this->id);
    }
    // Reviews received (as reviewee)
    
    
}