<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhieuNhap extends Model
{
    protected $table = 'phieu_nhap';
    
    protected $fillable = ['nha_cung_cap_id', 'ma_phieu', 'ghi_chu', 'tong_tien', 'nguoi_tao_id'];

    protected $casts = [
        'tong_tien' => 'decimal:0',
    ];

    public function nhaCungCap(): BelongsTo
    {
        return $this->belongsTo(NhaCungCap::class, 'nha_cung_cap_id');
    }

    public function nguoiTao(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_tao_id');
    }

    public function chiTietPhieuNhaps(): HasMany
    {
        return $this->hasMany(ChiTietPhieuNhap::class, 'phieu_nhap_id');
    }
}

