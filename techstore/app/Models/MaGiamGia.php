<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaGiamGia extends Model
{
    protected $table = 'ma_giam_gia';
    
    protected $fillable = [
        'ma_voucher', 'ten', 'loai_giam_gia', 'gia_tri_giam',
        'don_toi_thieu', 'so_lan_su_dung_toi_da', 'so_lan_da_su_dung',
        'ngay_bat_dau', 'ngay_ket_thuc', 'trang_thai', 'mo_ta', 'nguoi_tao_id'
    ];

    protected $casts = [
        'ngay_bat_dau' => 'datetime',
        'ngay_ket_thuc' => 'datetime',
        'gia_tri_giam' => 'decimal:0',
        'don_toi_thieu' => 'decimal:0',
    ];

    public function nguoiTao(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nguoi_tao_id');
    }

    public function donHangs(): HasMany
    {
        return $this->hasMany(DonHang::class, 'ma_giam_gia_id');
    }

    // Kiểm tra voucher còn hiệu lực
    public function conHieuLuc(): bool
    {
        if ($this->trang_thai !== 'active') {
            return false;
        }
        
        $now = now();
        if ($this->ngay_bat_dau && $now < $this->ngay_bat_dau) {
            return false;
        }
        if ($this->ngay_ket_thuc && $now > $this->ngay_ket_thuc) {
            return false;
        }
        if ($this->so_lan_su_dung_toi_da && $this->so_lan_da_su_dung >= $this->so_lan_su_dung_toi_da) {
            return false;
        }
        return true;
    }

    // Tính số tiền giảm
    public function tinhGiamGia($tongTien): float
    {
        if ($tongTien < $this->don_toi_thieu) {
            return 0;
        }
        
        if ($this->loai_giam_gia === 'percent') {
            return $tongTien * $this->gia_tri_giam / 100;
        }
        
        return min($this->gia_tri_giam, $tongTien);
    }
}

