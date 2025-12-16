<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'details',
        'is_default',
        'last_four',
        'brand'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getDecryptedDetailsAttribute()
    {
        try {
            return json_decode(Crypt::decrypt($this->details), true);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getMaskedNumberAttribute()
    {
        if ($this->type === 'card' && $this->last_four) {
            return '**** **** **** ' . $this->last_four;
        }
        
        return null;
    }

    public function getDisplayNameAttribute()
    {
        if ($this->type === 'card') {
            $details = $this->decrypted_details;
            return ($details['card_holder'] ?? 'Card') . ' • ' . $this->masked_number;
        } elseif ($this->type === 'paypal') {
            $details = $this->decrypted_details;
            return 'PayPal • ' . ($details['paypal_email'] ?? '');
        } elseif ($this->type === 'bank') {
            return 'Bank Transfer';
        }
        
        return ucfirst($this->type);
    }
}