<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\DanhMuc;
use App\Models\BienThe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy sản phẩm nổi bật (mới nhất)
        $featuredProducts = SanPham::with(['danhMuc', 'bienThes', 'anhSanPhams'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Lấy sản phẩm mới nhất
        $newProducts = SanPham::with(['danhMuc', 'bienThes', 'anhSanPhams'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Lấy sản phẩm bán chạy (dựa trên số lượng đã bán)
        $bestSellingProducts = DB::table('chitiet_donhang')
            ->join('sanpham', 'chitiet_donhang.sanpham_id', '=', 'sanpham.id')
            ->join('donhang', 'chitiet_donhang.donhang_id', '=', 'donhang.id')
            ->where('donhang.trang_thai', 'hoan_thanh')
            ->select('sanpham.id', DB::raw('SUM(chitiet_donhang.so_luong) as total_sold'))
            ->groupBy('sanpham.id')
            ->orderBy('total_sold', 'desc')
            ->limit(8)
            ->pluck('id')
            ->toArray();

        $bestSellingProductsData = SanPham::with(['danhMuc', 'bienThes', 'anhSanPhams'])
            ->whereIn('id', $bestSellingProducts)
            ->get()
            ->sortBy(function($product) use ($bestSellingProducts) {
                return array_search($product->id, $bestSellingProducts);
            })
            ->values();

        // Lấy sản phẩm có giá tốt (giá thấp nhất)
        $cheapProducts = SanPham::with(['danhMuc', 'bienThes', 'anhSanPhams'])
            ->whereHas('bienThes', function($query) {
                $query->where('so_luong_ton', '>', 0);
            })
            ->get()
            ->map(function($product) {
                $minPrice = $product->bienThes->where('so_luong_ton', '>', 0)->min('gia');
                $product->min_price = $minPrice ?? 999999999;
                return $product;
            })
            ->sortBy('min_price')
            ->take(8)
            ->values();

        // Lấy danh mục có nhiều sản phẩm nhất
        $categories = DanhMuc::withCount(['sanPhams as sanphams_count'])
            ->having('sanphams_count', '>', 0)
            ->orderBy('sanphams_count', 'desc')
            ->limit(6)
            ->get();

        // Lấy tất cả danh mục cho menu
        $allCategories = DanhMuc::withCount(['sanPhams as sanphams_count'])->get();

        return view('frontend.home', compact(
            'featuredProducts',
            'newProducts',
            'bestSellingProductsData',
            'cheapProducts',
            'categories',
            'allCategories'
        ));
    }
}

