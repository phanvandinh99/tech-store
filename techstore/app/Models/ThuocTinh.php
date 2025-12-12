<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThuocTinh extends Model
{
    protected $table = 'thuoctinh';
    
    const UPDATED_AT = null;
    
    protected $fillable = ['ten'];

    public function sanPhams(): BelongsToMany
    {
        return $this->belongsToMany(SanPham::class, 'sanpham_thuoctinh', 'thuoctinh_id', 'sanpham_id');
    }

    public function giaTriThuocTinhs(): HasMany
    {
        return $this->hasMany(GiaTriThuocTinh::class, 'thuoctinh_id');
    }
}

