<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class YeuCauBaoHanh extends Model
{
    protected $table = 'yeu_cau_bao_hanh';
    
    protected $fillable = [
        'nguoi_dung_id', 'donhang_id', 'bien_the_id', 'imei_id', 'ma_yeu_cau',
        'mo_ta_loi', 'hinh_thuc_bao_hanh', 'trang_thai',
        'ghi_chu_noi_bo', 'phieu_bao_hanh_chinh_hang',
        'ngay_tiep_nhan', 'ngay_hoan_thanh'
    ];

    protected $casts = [
        'ngay_tiep_nhan' => 'datetime',
        'ngay_hoan_thanh' => 'datetime',
    ];

    public function nguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function donHang(): BelongsTo
    {
        return $this->belongsTo(DonHang::class, 'donhang_id');
    }

    public function bienThe(): BelongsTo
    {
        return $this->belongsTo(BienThe::class, 'bien_the_id');
    }

    public function anhBaoHanh(): HasMany
    {
        return $this->hasMany(AnhBaoHanh::class, 'yeu_cau_id');
    }

    public function imei(): BelongsTo
    {
        return $this->belongsTo(Imei::class, 'imei_id');
    }

    // Tạo mã yêu cầu tự động
    public static function taoMaYeuCau(): string
    {
        do {
            $prefix = 'BH' . date('Ymd');
            $lastId = self::whereDate('created_at', today())->count() + 1;
            $maYeuCau = $prefix . str_pad($lastId, 4, '0', STR_PAD_LEFT);
        } while (self::where('ma_yeu_cau', $maYeuCau)->exists());
        
        return $maYeuCau;
    }
}

