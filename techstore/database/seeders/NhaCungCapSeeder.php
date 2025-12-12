<?php

namespace Database\Seeders;

use App\Models\ChiTietPhieuNhap;
use App\Models\NhaCungCap;
use App\Models\PhieuNhap;
use Illuminate\Database\Seeder;

class NhaCungCapSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo nhà cung cấp
        $nhaCungCap = NhaCungCap::updateOrCreate(
            ['ten' => 'Cong ty ABC'],
            [
                'sdt' => '0909123456',
                'dia_chi' => 'Ha Noi'
            ]
        );

        // Tạo phiếu nhập (chỉ tạo mới nếu chưa có)
        $phieuNhap = PhieuNhap::firstOrCreate(
            ['nha_cung_cap_id' => $nhaCungCap->id, 'ghi_chu' => 'Nhap lan dau'],
            ['nha_cung_cap_id' => $nhaCungCap->id, 'ghi_chu' => 'Nhap lan dau']
        );

        // Lấy biến thể từ seeder sản phẩm
        $bienThe1 = \App\Models\BienThe::where('sku', 'IP15PM-XANH-128')->first();
        $bienThe4 = \App\Models\BienThe::where('sku', 'OP15PM-001')->first();

        // Chi tiết phiếu nhập
        if ($bienThe1) {
            ChiTietPhieuNhap::updateOrCreate(
                [
                    'phieu_nhap_id' => $phieuNhap->id,
                    'bien_the_id' => $bienThe1->id
                ],
                [
                    'so_luong_nhap' => 10,
                    'gia_von_nhap' => 25000000
                ]
            );
        }

        if ($bienThe4) {
            ChiTietPhieuNhap::updateOrCreate(
                [
                    'phieu_nhap_id' => $phieuNhap->id,
                    'bien_the_id' => $bienThe4->id
                ],
                [
                    'so_luong_nhap' => 50,
                    'gia_von_nhap' => 120000
                ]
            );
        }
    }
}

