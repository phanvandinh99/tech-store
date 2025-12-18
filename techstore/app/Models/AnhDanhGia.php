<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnhDanhGia extends Model
{
    protected $table = 'anh_danh_gia';
    
    protected $fillable = ['danh_gia_id', 'duong_dan'];

    public $timestamps = false;
    
    const CREATED_AT = 'created_at';

    public function danhGia(): BelongsTo
    {
        return $this->belongsTo(DanhGia::class, 'danh_gia_id');
    }
}

