<?php

namespace Database\Seeders;

use App\Models\AnhSanPham;
use App\Models\BienThe;
use App\Models\GiaTriThuocTinh;
use App\Models\SanPham;
use App\Models\ThuocTinh;
use Illuminate\Database\Seeder;

class SanPhamSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy danh mục
        $dienThoai = \App\Models\DanhMuc::where('ten', 'Dien thoai')->first();
        $phuKien = \App\Models\DanhMuc::where('ten', 'Phu kien')->first();

        // Lấy thuộc tính
        $mauSac = ThuocTinh::where('ten', 'Mau sac')->first();
        $dungLuong = ThuocTinh::where('ten', 'Dung luong luu tru')->first();

        // Lấy giá trị thuộc tính
        $xanhThienThach = GiaTriThuocTinh::where('giatri', 'Xanh Thien Thach')->first();
        $den = GiaTriThuocTinh::where('giatri', 'Den')->first();
        $gb128 = GiaTriThuocTinh::where('giatri', '128GB')->first();
        $gb256 = GiaTriThuocTinh::where('giatri', '256GB')->first();

        // Sản phẩm 1: iPhone 15 Pro Max
        $iphone = SanPham::updateOrCreate(
            ['ten' => 'iPhone 15 Pro Max'],
            [
                'danhmuc_id' => $dienThoai->id,
                'mota' => 'iPhone cao cap 2023'
            ]
        );

        // Gắn thuộc tính cho iPhone (sync để tránh duplicate)
        $iphone->thuocTinhs()->syncWithoutDetaching([$mauSac->id, $dungLuong->id]);

        // Tạo biến thể iPhone
        $bienThe1 = BienThe::updateOrCreate(
            ['sku' => 'IP15PM-XANH-128'],
            [
                'sanpham_id' => $iphone->id,
                'gia' => 29990000,
                'gia_von' => 25000000,
                'so_luong_ton' => 10
            ]
        );
        $bienThe1->giaTriThuocTinhs()->syncWithoutDetaching([$xanhThienThach->id, $gb128->id]);

        $bienThe2 = BienThe::updateOrCreate(
            ['sku' => 'IP15PM-XANH-256'],
            [
                'sanpham_id' => $iphone->id,
                'gia' => 32990000,
                'gia_von' => 27000000,
                'so_luong_ton' => 8
            ]
        );
        $bienThe2->giaTriThuocTinhs()->syncWithoutDetaching([$xanhThienThach->id, $gb256->id]);

        $bienThe3 = BienThe::updateOrCreate(
            ['sku' => 'IP15PM-DEN-128'],
            [
                'sanpham_id' => $iphone->id,
                'gia' => 29990000,
                'gia_von' => 25000000,
                'so_luong_ton' => 5
            ]
        );
        $bienThe3->giaTriThuocTinhs()->syncWithoutDetaching([$den->id, $gb128->id]);

        // Hình ảnh iPhone
        AnhSanPham::updateOrCreate(
            ['sanpham_id' => $iphone->id, 'bien_the_id' => null, 'duong_dan' => 'images/iphone15pm/main.jpg'],
            ['la_anh_chinh' => true]
        );
        AnhSanPham::updateOrCreate(
            ['sanpham_id' => $iphone->id, 'bien_the_id' => $bienThe1->id, 'duong_dan' => 'images/iphone15pm/xanh-128.jpg'],
            ['la_anh_chinh' => true]
        );

        // Sản phẩm 2: Ốp lưng
        $opLung = SanPham::updateOrCreate(
            ['ten' => 'Op lung iPhone 15 Pro Max'],
            [
                'danhmuc_id' => $phuKien->id,
                'mota' => 'Op silicone cao cap'
            ]
        );

        // Biến thể cho phụ kiện (1 biến thể duy nhất)
        $bienThe4 = BienThe::updateOrCreate(
            ['sku' => 'OP15PM-001'],
            [
                'sanpham_id' => $opLung->id,
                'gia' => 250000,
                'gia_von' => 120000,
                'so_luong_ton' => 50
            ]
        );

        // Hình ảnh ốp lưng
        AnhSanPham::updateOrCreate(
            ['sanpham_id' => $opLung->id, 'bien_the_id' => $bienThe4->id, 'duong_dan' => 'images/phukien/op15pm.jpg'],
            ['la_anh_chinh' => true]
        );
    }
}

