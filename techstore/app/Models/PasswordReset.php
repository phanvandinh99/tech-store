<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PasswordReset extends Model
{
    protected $table = 'password_resets';
    
    protected $primaryKey = 'id';
    
    protected $fillable = ['email', 'code', 'user_type', 'created_at'];
    
    public $timestamps = false;
    
    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    // Override create method để đảm bảo created_at được set
    public static function create(array $attributes = [])
    {
        if (!isset($attributes['created_at'])) {
            $attributes['created_at'] = now();
        }
        
        return static::query()->create($attributes);
    }
    
    // Kiểm tra mã có hết hạn không (15 phút)
    public function isExpired()
    {
        if (!$this->created_at) {
            return true; // Nếu không có created_at thì coi như đã hết hạn
        }
        
        // Tạo một instance mới để tránh thay đổi giá trị gốc
        $expiryTime = $this->created_at->copy()->addMinutes(15);
        return $expiryTime->isPast();
    }
}