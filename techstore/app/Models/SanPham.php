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
}

