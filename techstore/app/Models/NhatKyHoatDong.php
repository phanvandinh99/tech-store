<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NhatKyHoatDong extends Model
{
    protected $table = 'nhat_ky_hoat_dong';
    
    // Bật timestamps để Laravel tự động xử lý created_at và updated_at
    public $timestamps = true;
    
    // Chỉ sử dụng created_at, không cần updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'nguoi_dung_id', 'hanh_dong', 'loai_model', 'id_model',
        'mo_ta', 'gia_tri_cu', 'gia_tri_moi', 'dia_chi_ip', 'trinh_duyet'
    ];

    protected $casts = [
        'gia_tri_cu' => 'array',
        'gia_tri_moi' => 'array',
        'created_at' => 'datetime',
    ];

    public function nguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    // Ghi log hoạt động
    public static function ghiLog(
        string $hanhDong,
        string $loaiModel,
        ?int $idModel = null,
        ?string $moTa = null,
        ?array $giaTriCu = null,
        ?array $giaTriMoi = null
    ): self {
        return self::create([
            'nguoi_dung_id' => auth()->id(),
            'hanh_dong' => $hanhDong,
            'loai_model' => $loaiModel,
            'id_model' => $idModel,
            'mo_ta' => $moTa,
            'gia_tri_cu' => $giaTriCu,
            'gia_tri_moi' => $giaTriMoi,
            'dia_chi_ip' => request()->ip(),
            'trinh_duyet' => request()->userAgent(),
            'created_at' => now(), // Đảm bảo có created_at
        ]);
    }
}

