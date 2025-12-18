<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnhBaoHanh extends Model
{
    protected $table = 'anh_bao_hanh';
    
    protected $fillable = ['yeu_cau_id', 'duong_dan'];

    public $timestamps = false;
    
    const CREATED_AT = 'created_at';

    public function yeuCauBaoHanh(): BelongsTo
    {
        return $this->belongsTo(YeuCauBaoHanh::class, 'yeu_cau_id');
    }
}

