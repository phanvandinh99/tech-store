<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BienThe extends Model
{
    protected $table = 'bien_the';
    
    protected $fillable = ['sanpham_id', 'sku', 'gia', 'gia_von', 'so_luong_ton'];

    protected $casts = [
        'gia' => 'decimal:0',
        'gia_von' => 'decimal:0',
    ];

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'sanpham_id');
    }

    public function giaTriThuocTinhs(): BelongsToMany
    {
        return $this->belongsToMany(GiaTriThuocTinh::class, 'bien_the_giatri', 'bien_the_id', 'giatri_thuoctinh_id');
    }

    public function anhSanPhams(): HasMany
    {
        return $this->hasMany(AnhSanPham::class, 'bien_the_id');
    }

    public function chiTietDonHangs(): HasMany
    {
        return $this->hasMany(ChiTietDonHang::class, 'bien_the_id');
    }

    public function chiTietPhieuNhaps(): HasMany
    {
        return $this->hasMany(ChiTietPhieuNhap::class, 'bien_the_id');
    }

    // Accessor để lấy chuỗi giá trị thuộc tính
    public function getGiaTriThuocTinhAttribute()
    {
        return $this->giaTriThuocTinhs->pluck('giatri')->implode(', ');
    }
}

