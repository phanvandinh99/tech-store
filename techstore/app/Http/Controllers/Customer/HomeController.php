<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\DanhMuc;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy sản phẩm nổi bật (mới nhất)
        $featuredProducts = SanPham::with(['danhMuc', 'bienThes', 'anhSanPhams'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Lấy tất cả danh mục
        $categories = DanhMuc::withCount('sanPhams')->get();

        return view('frontend.home', compact('featuredProducts', 'categories'));
    }
}

