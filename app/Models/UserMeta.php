<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $table = 'user_meta';
    
    protected $fillable = ['user_id', 'key', 'value'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Helper method to get/set meta
    public static function getMeta($userId, $key, $default = null)
    {
        $meta = self::where('user_id', $userId)->where('key', $key)->first();
        return $meta ? json_decode($meta->value, true) : $default;
    }
    
    public static function setMeta($userId, $key, $value)
    {
        return self::updateOrCreate(
            ['user_id' => $userId, 'key' => $key],
            ['value' => json_encode($value)]
        );
    }
}