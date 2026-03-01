<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imei extends Model
{
    protected $table = 'imei';
    
    protected $fillable = [
        'bien_the_id', 'so_imei', 'trang_thai', 
        'chitiet_donhang_id', 'ngay_ban', 'ghi_chu'
    ];

    protected $casts = [
        'ngay_ban' => 'datetime',
    ];

    // Trạng thái IMEI
    const TRANG_THAI_AVAILABLE = 'available';
    const TRANG_THAI_SOLD = 'sold';
    const TRANG_THAI_WARRANTY = 'warranty';
    const TRANG_THAI_RETURNED = 'returned';

    public function bienThe(): BelongsTo
    {
        return $this->belongsTo(BienThe::class, 'bien_the_id');
    }

    public function chiTietDonHang(): BelongsTo
    {
        return $this->belongsTo(ChiTietDonHang::class, 'chitiet_donhang_id');
    }

    public function yeuCauBaoHanh()
    {
        return $this->hasMany(YeuCauBaoHanh::class, 'imei_id');
    }

    // Lấy tên trạng thái
    public function getTenTrangThaiAttribute(): string
    {
        return match($this->trang_thai) {
            self::TRANG_THAI_AVAILABLE => 'Có sẵn',
            self::TRANG_THAI_SOLD => 'Đã bán',
            self::TRANG_THAI_WARRANTY => 'Đang bảo hành',
            self::TRANG_THAI_RETURNED => 'Đã trả lại',
            default => 'Không xác định'
        };
    }

    // Kiểm tra IMEI có thể bán không
    public function coTheBan(): bool
    {
        return $this->trang_thai === self::TRANG_THAI_AVAILABLE;
    }

    // Đánh dấu IMEI đã bán
    public function danhDauDaBan($chiTietDonHangId): void
    {
        $this->update([
            'trang_thai' => self::TRANG_THAI_SOLD,
            'chitiet_donhang_id' => $chiTietDonHangId,
            'ngay_ban' => now()
        ]);
    }

    // Đánh dấu IMEI đang bảo hành
    public function danhDauBaoHanh(): void
    {
        $this->update(['trang_thai' => self::TRANG_THAI_WARRANTY]);
    }

    // Hoàn trả IMEI về trạng thái có sẵn
    public function hoanTra(): void
    {
        $this->update([
            'trang_thai' => self::TRANG_THAI_RETURNED,
            'chitiet_donhang_id' => null
        ]);
    }
}
