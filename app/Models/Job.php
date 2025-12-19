<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    
    // If your table is called something else, specify it:
    // protected $table = 'marketplace_jobs';
    
    protected $fillable = [
        'title',
        'description',
        'budget',
        'status',
        'client_id',
    ];
    
    // Cast status to string
    protected $casts = [
        'budget' => 'decimal:2',
    ];
    
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}