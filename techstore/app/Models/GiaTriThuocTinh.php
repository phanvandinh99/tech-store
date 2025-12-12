<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GiaTriThuocTinh extends Model
{
    protected $table = 'giatri_thuoctinh';
    
    const UPDATED_AT = null;
    
    protected $fillable = ['thuoctinh_id', 'giatri'];

    public function thuocTinh(): BelongsTo
    {
        return $this->belongsTo(ThuocTinh::class, 'thuoctinh_id');
    }

    public function bienThes(): BelongsToMany
    {
        return $this->belongsToMany(BienThe::class, 'bien_the_giatri', 'giatri_thuoctinh_id', 'bien_the_id');
    }
}

