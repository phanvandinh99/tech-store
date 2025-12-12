<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NhaCungCap extends Model
{
    protected $table = 'nha_cung_cap';
    
    const UPDATED_AT = null;
    
    protected $fillable = ['ten', 'sdt', 'email', 'dia_chi'];

    public function phieuNhaps(): HasMany
    {
        return $this->hasMany(PhieuNhap::class, 'nha_cung_cap_id');
    }
}

