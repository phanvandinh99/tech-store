<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BinhLuan extends Model
{
    protected $table = 'binh_luan';
    
    protected $fillable = [
        'danh_gia_id', 'nguoi_dung_id', 'noi_dung',
        'binh_luan_cha_id', 'trang_thai'
    ];

    public function danhGia(): BelongsTo
    {
        return $this->belongsTo(DanhGia::class, 'danh_gia_id');
    }

    public function nguoiDung(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nguoi_dung_id');
    }

    public function binhLuanCha(): BelongsTo
    {
        return $this->belongsTo(BinhLuan::class, 'binh_luan_cha_id');
    }

    public function binhLuanCon(): HasMany
    {
        return $this->hasMany(BinhLuan::class, 'binh_luan_cha_id');
    }
}

