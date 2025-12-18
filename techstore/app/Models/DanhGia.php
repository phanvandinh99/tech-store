<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DanhGia extends Model
{
    protected $table = 'danh_gia';
    
    protected $fillable = [
        'nguoi_dung_id', 'sanpham_id', 'donhang_id',
        'so_sao', 'noi_dung', 'trang_thai'
    ];

    public function nguoiDung(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nguoi_dung_id');
    }

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'sanpham_id');
    }

    public function donHang(): BelongsTo
    {
        return $this->belongsTo(DonHang::class, 'donhang_id');
    }

    public function anhDanhGia(): HasMany
    {
        return $this->hasMany(AnhDanhGia::class, 'danh_gia_id');
    }

    public function binhLuans(): HasMany
    {
        return $this->hasMany(BinhLuan::class, 'danh_gia_id');
    }
}

