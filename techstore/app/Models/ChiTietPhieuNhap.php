<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChiTietPhieuNhap extends Model
{
    protected $table = 'chitiet_phieu_nhap';
    
    const UPDATED_AT = null;
    
    protected $fillable = ['phieu_nhap_id', 'bien_the_id', 'so_luong_nhap', 'gia_von_nhap'];

    protected $casts = [
        'gia_von_nhap' => 'decimal:0',
    ];

    public function phieuNhap(): BelongsTo
    {
        return $this->belongsTo(PhieuNhap::class, 'phieu_nhap_id');
    }

    public function bienThe(): BelongsTo
    {
        return $this->belongsTo(BienThe::class, 'bien_the_id');
    }
}

