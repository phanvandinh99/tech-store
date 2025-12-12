<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DanhMuc extends Model
{
    protected $table = 'danhmuc';
    
    protected $fillable = ['ten'];

    public function sanPhams(): HasMany
    {
        return $this->hasMany(SanPham::class, 'danhmuc_id');
    }
}

