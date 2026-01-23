<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DanhSachYeuThich extends Model
{
    protected $table = 'danh_sach_yeu_thich';
    
    protected $fillable = ['nguoi_dung_id', 'sanpham_id'];

    public $timestamps = false;

    protected $dates = ['created_at'];

    public function nguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'sanpham_id');
    }
}