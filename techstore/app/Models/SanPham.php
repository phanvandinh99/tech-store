<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SanPham extends Model
{
    protected $table = 'sanpham';
    
    protected $fillable = ['ten', 'slug', 'danhmuc_id', 'thuong_hieu_id', 'mo_ta_ngan', 'mo_ta_chi_tiet', 'trang_thai', 'luot_xem', 'luot_ban'];

    public function danhMuc(): BelongsTo
    {
        return $this->belongsTo(DanhMuc::class, 'danhmuc_id');
    }

    public function thuocTinhs(): BelongsToMany
    {
        return $this->belongsToMany(ThuocTinh::class, 'sanpham_thuoctinh', 'sanpham_id', 'thuoctinh_id');
    }

    public function bienThes(): HasMany
    {
        return $this->hasMany(BienThe::class, 'sanpham_id');
    }

    public function anhSanPhams(): HasMany
    {
        return $this->hasMany(AnhSanPham::class, 'sanpham_id');
    }

    public function chiTietDonHangs(): HasMany
    {
        return $this->hasMany(ChiTietDonHang::class, 'sanpham_id');
    }

    public function danhGias(): HasMany
    {
        return $this->hasMany(DanhGia::class, 'sanpham_id');
    }

    public function danhSachYeuThichs(): HasMany
    {
        return $this->hasMany(DanhSachYeuThich::class, 'sanpham_id');
    }

    // Helper method to check if product is in user's wishlist
    public function isInWishlist($userId = null): bool
    {
        if (!$userId) {
            return false;
        }
        
        return $this->danhSachYeuThichs()->where('nguoi_dung_id', $userId)->exists();
    }
}

