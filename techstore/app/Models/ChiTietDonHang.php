<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChiTietDonHang extends Model
{
    protected $table = 'chitiet_donhang';
    
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    protected $fillable = ['donhang_id', 'sanpham_id', 'bien_the_id', 'so_luong', 'gia_luc_mua', 'thanh_tien'];

    protected $casts = [
        'gia_luc_mua' => 'decimal:0',
        'thanh_tien' => 'decimal:0',
    ];

    public function donHang(): BelongsTo
    {
        return $this->belongsTo(DonHang::class, 'donhang_id');
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

