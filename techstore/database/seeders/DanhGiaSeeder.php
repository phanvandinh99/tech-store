<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DanhGia;
use App\Models\AnhDanhGia;
use App\Models\NguoiDung;
use App\Models\SanPham;
use App\Models\DonHang;

class DanhGiaSeeder extends Seeder
{
    public function run()
    {
        // Lấy một số người dùng và sản phẩm để tạo đánh giá mẫu
        $nguoiDungs = NguoiDung::limit(5)->get();
        $sanPhams = SanPham::limit(10)->get();
        $donHangs = DonHang::where('trang_thai', 'hoan_thanh')->limit(5)->get();

        if ($nguoiDungs->isEmpty() || $sanPhams->isEmpty()) {
            $this->command->info('Không có đủ dữ liệu người dùng hoặc sản phẩm để tạo đánh giá mẫu.');
            return;
        }

        $reviewTexts = [
            'Sản phẩm rất tốt, chất lượng như mô tả. Giao hàng nhanh, đóng gói cẩn thận.',
            'Mình rất hài lòng với sản phẩm này. Thiết kế đẹp, chức năng hoạt động tốt.',
            'Chất lượng ổn, giá cả hợp lý. Sẽ ủng hộ shop lần sau.',
            'Sản phẩm đúng như hình ảnh, chất lượng tốt. Nhân viên tư vấn nhiệt tình.',
            'Rất hài lòng với lần mua hàng này. Sản phẩm chất lượng, giao hàng đúng hẹn.',
            'Sản phẩm tuyệt vời! Đáng đồng tiền bát gạo. Sẽ giới thiệu cho bạn bè.',
            'Chất lượng sản phẩm tốt, đóng gói cẩn thận. Giao hàng hơi chậm một chút.',
            'Sản phẩm như mong đợi, chất lượng ổn. Giá cả phải chăng.',
            'Rất ưng ý với sản phẩm này. Chất lượng tốt, thiết kế đẹp mắt.',
            'Sản phẩm chất lượng cao, đáng tiền. Dịch vụ khách hàng tốt.',
        ];

        foreach ($sanPhams as $sanPham) {
            // Tạo 2-5 đánh giá cho mỗi sản phẩm
            $reviewCount = rand(2, 5);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $nguoiDung = $nguoiDungs->random();
                $donHang = $donHangs->isNotEmpty() ? $donHangs->random() : null;
                
                // Kiểm tra xem đã có đánh giá từ user này cho sản phẩm này chưa
                $existingReview = DanhGia::where('nguoi_dung_id', $nguoiDung->id)
                                        ->where('sanpham_id', $sanPham->id)
                                        ->first();
                
                if ($existingReview) {
                    continue; // Bỏ qua nếu đã có đánh giá
                }
                
                $danhGia = DanhGia::create([
                    'nguoi_dung_id' => $nguoiDung->id,
                    'sanpham_id' => $sanPham->id,
                    'donhang_id' => $donHang ? $donHang->id : null,
                    'so_sao' => rand(3, 5), // Đánh giá từ 3-5 sao
                    'noi_dung' => $reviewTexts[array_rand($reviewTexts)],
                    'trang_thai' => 'approved', // Đã duyệt
                    'created_at' => now()->subDays(rand(1, 30)), // Tạo trong 30 ngày qua
                ]);

                $this->command->info("Tạo đánh giá cho sản phẩm {$sanPham->ten} từ {$nguoiDung->ho_ten}");
            }
        }

        $this->command->info('Đã tạo xong dữ liệu đánh giá mẫu!');
    }
}