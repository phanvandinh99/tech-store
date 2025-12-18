<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThuongHieu extends Model
{
    protected $table = 'thuong_hieu';
    
    protected $fillable = ['ten', 'mo_ta', 'hinh_logo'];

    public function sanPhams(): HasMany
    {
        return $this->hasMany(SanPham::class, 'thuong_hieu_id');
    }
}

