<?php

namespace Database\Seeders;

use App\Models\GiaTriThuocTinh;
use App\Models\ThuocTinh;
use Illuminate\Database\Seeder;

class ThuocTinhSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo thuộc tính
        $mauSac = ThuocTinh::updateOrCreate(
            ['ten' => 'Mau sac'],
            ['ten' => 'Mau sac']
        );
        $dungLuong = ThuocTinh::updateOrCreate(
            ['ten' => 'Dung luong luu tru'],
            ['ten' => 'Dung luong luu tru']
        );

        // Tạo giá trị thuộc tính cho màu sắc
        GiaTriThuocTinh::updateOrCreate(
            ['thuoctinh_id' => $mauSac->id, 'giatri' => 'Xanh Thien Thach'],
            ['thuoctinh_id' => $mauSac->id, 'giatri' => 'Xanh Thien Thach']
        );
        GiaTriThuocTinh::updateOrCreate(
            ['thuoctinh_id' => $mauSac->id, 'giatri' => 'Den'],
            ['thuoctinh_id' => $mauSac->id, 'giatri' => 'Den']
        );

        // Tạo giá trị thuộc tính cho dung lượng
        GiaTriThuocTinh::updateOrCreate(
            ['thuoctinh_id' => $dungLuong->id, 'giatri' => '128GB'],
            ['thuoctinh_id' => $dungLuong->id, 'giatri' => '128GB']
        );
        GiaTriThuocTinh::updateOrCreate(
            ['thuoctinh_id' => $dungLuong->id, 'giatri' => '256GB'],
            ['thuoctinh_id' => $dungLuong->id, 'giatri' => '256GB']
        );
    }
}

