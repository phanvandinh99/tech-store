<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DanhSachYeuThich;
use App\Models\NguoiDung;
use App\Models\SanPham;

class WishlistSeeder extends Seeder
{
    public function run()
    {
        // Get some customers and products
        $customers = NguoiDung::where('vai_tro', 'customer')->take(3)->get();
        $products = SanPham::take(10)->get();

        if ($customers->count() > 0 && $products->count() > 0) {
            foreach ($customers as $customer) {
                // Add 3-5 random products to each customer's wishlist
                $randomProducts = $products->random(rand(3, 5));
                
                foreach ($randomProducts as $product) {
                    // Check if already exists to avoid duplicates
                    $exists = DanhSachYeuThich::where('nguoi_dung_id', $customer->id)
                        ->where('sanpham_id', $product->id)
                        ->exists();
                    
                    if (!$exists) {
                        DanhSachYeuThich::create([
                            'nguoi_dung_id' => $customer->id,
                            'sanpham_id' => $product->id,
                            'created_at' => now()->subDays(rand(1, 30))
                        ]);
                    }
                }
            }
        }
    }
}