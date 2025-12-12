<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DonHang extends Model
{
    protected $table = 'donhang';
    
    protected $fillable = [
        'nguoidung_id', 'ten_khach', 'sdt_khach', 'email_khach', 
        'dia_chi_khach', 'tong_tien', 'trang_thai'
    ];

    protected $casts = [
        'tong_tien' => 'decimal:0',
    ];

    public function nguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoidung_id');
    }

    public function chiTietDonHangs(): HasMany
    {
        return $this->hasMany(ChiTietDonHang::class, 'donhang_id');
    }
}

