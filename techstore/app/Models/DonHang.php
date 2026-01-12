<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DonHang extends Model
{
    protected $table = 'donhang';
    
    protected $fillable = [
        'ma_don_hang', 'nguoi_dung_id', 'ten_khach', 'sdt_khach', 'email_khach', 
        'dia_chi_khach', 'phuong_thuc_thanh_toan', 'ma_giam_gia_id', 'giam_gia',
        'tong_tien', 'thanh_tien', 'trang_thai', 'ghi_chu'
    ];

    protected $casts = [
        'tong_tien' => 'decimal:0',
        'thanh_tien' => 'decimal:0',
        'giam_gia' => 'decimal:0',
    ];

    public function nguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function chiTietDonHangs(): HasMany
    {
        return $this->hasMany(ChiTietDonHang::class, 'donhang_id');
    }
}

