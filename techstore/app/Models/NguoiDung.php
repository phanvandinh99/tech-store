<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class NguoiDung extends Authenticatable
{
    use Notifiable;

    protected $table = 'nguoi_dung';
    
    protected $fillable = ['ten', 'email', 'mat_khau', 'sdt', 'vai_tro', 'trang_thai'];

    protected $hidden = ['mat_khau', 'remember_token'];

    // Accessor để dùng name như alias của ten (tương thích với code cũ)
    public function getNameAttribute()
    {
        return $this->ten;
    }

    // Đổi tên cột password
    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    // Kiểm tra có phải admin không
    public function isAdmin(): bool
    {
        return $this->vai_tro === 'admin';
    }

    // Kiểm tra có phải customer không
    public function isCustomer(): bool
    {
        return $this->vai_tro === 'customer';
    }

    // Kiểm tra tài khoản có bị khóa không
    public function isActive(): bool
    {
        return $this->trang_thai === 'active';
    }

    public function donHangs(): HasMany
    {
        return $this->hasMany(DonHang::class, 'nguoi_dung_id');
    }

    public function danhSachYeuThichs(): HasMany
    {
        return $this->hasMany(DanhSachYeuThich::class, 'nguoi_dung_id');
    }
}
