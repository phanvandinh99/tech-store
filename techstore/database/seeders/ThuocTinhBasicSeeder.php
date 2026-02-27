<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ThuocTinh;
use App\Models\GiaTriThuocTinh;
use Illuminate\Support\Facades\DB;

class ThuocTinhBasicSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();
        try {
            // 1. Màu sắc
            $mauSac = ThuocTinh::firstOrCreate(['ten' => 'Màu sắc']);
            $mauSacValues = [
                'Đen', 'Trắng', 'Xanh dương', 'Xanh lá', 'Đỏ', 
                'Vàng', 'Hồng', 'Tím', 'Xám', 'Bạc', 'Vàng đồng'
            ];
            foreach ($mauSacValues as $value) {
                GiaTriThuocTinh::firstOrCreate([
                    'thuoctinh_id' => $mauSac->id,
                    'giatri' => $value
                ]);
            }

            // 2. Dung lượng lưu trữ
            $dungLuong = ThuocTinh::firstOrCreate(['ten' => 'Dung lượng lưu trữ']);
            $dungLuongValues = [
                '32GB', '64GB', '128GB', '256GB', '512GB', '1TB', '2TB'
            ];
            foreach ($dungLuongValues as $value) {
                GiaTriThuocTinh::firstOrCreate([
                    'thuoctinh_id' => $dungLuong->id,
                    'giatri' => $value
                ]);
            }

            // 3. RAM
            $ram = ThuocTinh::firstOrCreate(['ten' => 'RAM']);
            $ramValues = [
                '2GB', '3GB', '4GB', '6GB', '8GB', '12GB', '16GB', '32GB'
            ];
            foreach ($ramValues as $value) {
                GiaTriThuocTinh::firstOrCreate([
                    'thuoctinh_id' => $ram->id,
                    'giatri' => $value
                ]);
            }

            // 4. Kích thước màn hình
            $kichThuoc = ThuocTinh::firstOrCreate(['ten' => 'Kích thước màn hình']);
            $kichThuocValues = [
                '5.5 inch', '6.1 inch', '6.3 inch', '6.5 inch', '6.7 inch', '6.8 inch',
                '13 inch', '14 inch', '15.6 inch', '16 inch', '17 inch'
            ];
            foreach ($kichThuocValues as $value) {
                GiaTriThuocTinh::firstOrCreate([
                    'thuoctinh_id' => $kichThuoc->id,
                    'giatri' => $value
                ]);
            }

            DB::commit();
            $this->command->info('✓ Đã tạo 4 thuộc tính cơ bản: Màu sắc, Dung lượng lưu trữ, RAM, Kích thước màn hình');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Lỗi: ' . $e->getMessage());
        }
    }
}
