<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NguoiDung extends Model
{
    protected $table = 'nguoidung';
    
    protected $fillable = ['ten', 'email', 'mat_khau', 'sdt', 'dia_chi'];

    protected $hidden = ['mat_khau'];

    public function donHangs(): HasMany
    {
        return $this->hasMany(DonHang::class, 'nguoidung_id');
    }
}

