<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'pending_balance',
        'currency',
        'transactions'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
        'transactions' => 'array'
    ];

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Add funds to wallet
    public function addFunds($amount, $description = 'Added funds')
    {
        $this->balance += $amount;
        
        $transactions = $this->transactions ?? [];
        $transactions[] = [
            'type' => 'credit',
            'amount' => $amount,
            'description' => $description,
            'balance_before' => $this->balance - $amount,
            'balance_after' => $this->balance,
            'date' => now()->toDateTimeString()
        ];
        
        $this->transactions = $transactions;
        $this->save();
        
        return $this;
    }

    // Deduct funds from wallet
    public function deductFunds($amount, $description = 'Payment')
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient funds');
        }
        
        $this->balance -= $amount;
        
        $transactions = $this->transactions ?? [];
        $transactions[] = [
            'type' => 'debit',
            'amount' => $amount,
            'description' => $description,
            'balance_before' => $this->balance + $amount,
            'balance_after' => $this->balance,
            'date' => now()->toDateTimeString()
        ];
        
        $this->transactions = $transactions;
        $this->save();
        
        return $this;
    }

    // Add pending funds (for escrow)
    public function addPending($amount)
    {
        $this->pending_balance += $amount;
        $this->save();
        
        return $this;
    }

    // Release pending funds to balance
    public function releasePending($amount)
    {
        if ($this->pending_balance < $amount) {
            throw new \Exception('Insufficient pending funds');
        }
        
        $this->pending_balance -= $amount;
        $this->balance += $amount;
        $this->save();
        
        return $this;
    }

    // Check if user has sufficient balance
    public function hasSufficientBalance($amount)
    {
        return $this->balance >= $amount;
    }

    // Get formatted balance
    public function getFormattedBalanceAttribute()
    {
        return number_format($this->balance, 2);
    }

    // Get formatted pending balance
    public function getFormattedPendingBalanceAttribute()
    {
        return number_format($this->pending_balance, 2);
    }

    // Get total balance (balance + pending)
    public function getTotalBalanceAttribute()
    {
        return $this->balance + $this->pending_balance;
    }

    // Get recent transactions
    public function getRecentTransactions($limit = 5)
    {
        $transactions = $this->transactions ?? [];
        return array_slice(array_reverse($transactions), 0, $limit);
    }
}
