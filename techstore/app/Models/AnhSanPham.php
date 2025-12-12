<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnhSanPham extends Model
{
    protected $table = 'anh_sanpham';
    
    const UPDATED_AT = null;
    
    protected $fillable = ['sanpham_id', 'bien_the_id', 'duong_dan', 'la_anh_chinh'];

    protected $casts = [
        'la_anh_chinh' => 'boolean',
    ];

    // Accessor để tương thích với code frontend
    public function getUrlAttribute()
    {
        return $this->duong_dan;
    }

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'sanpham_id');
    }

    public function bienThe(): BelongsTo
    {
        return $this->belongsTo(BienThe::class, 'bien_the_id');
    }
}

