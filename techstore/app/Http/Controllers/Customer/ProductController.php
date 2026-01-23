<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\DanhMuc;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = SanPham::with(['danhMuc', 'bienThes', 'anhSanPhams', 'danhGias']);

        // Mặc định chỉ hiển thị sản phẩm còn hàng (trừ khi có tham số show_all)
        if (!$request->has('show_all')) {
            $query->whereHas('bienThes', function($q) {
                $q->where('so_luong_ton', '>', 0);
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('danhmuc_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('ten', 'like', '%' . $request->search . '%');
        }

        // Price range filter
        if ($request->has('min_price') && $request->min_price) {
            $query->whereHas('bienThes', function($q) use ($request) {
                $q->where('gia', '>=', $request->min_price);
            });
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->whereHas('bienThes', function($q) use ($request) {
                $q->where('gia', '<=', $request->max_price);
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'price_low':
                $query->leftJoin('bien_the', 'sanpham.id', '=', 'bien_the.sanpham_id')
                      ->orderBy('bien_the.gia', 'asc')
                      ->select('sanpham.*')
                      ->distinct();
                break;
            case 'price_high':
                $query->leftJoin('bien_the', 'sanpham.id', '=', 'bien_the.sanpham_id')
                      ->orderBy('bien_the.gia', 'desc')
                      ->select('sanpham.*')
                      ->distinct();
                break;
            case 'name_asc':
                $query->orderBy('ten', 'asc');
                break;
            case 'popular':
                $query->orderBy('luot_xem', 'desc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->get('per_page', 12);
        if (!in_array($perPage, [12, 24, 36])) {
            $perPage = 12;
        }

        $products = $query->paginate($perPage)->appends($request->all());
        $categories = DanhMuc::all();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = SanPham::with([
            'danhMuc', 
            'bienThes.giaTriThuocTinhs', 
            'anhSanPhams', 
            'thuocTinhs.giaTriThuocTinhs',
            'danhGias' => function($query) {
                $query->where('trang_thai', 'approved')
                      ->with(['nguoiDung', 'anhDanhGia'])
                      ->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        // Related products (same category)
        $relatedProducts = SanPham::where('danhmuc_id', $product->danhmuc_id)
            ->where('id', '!=', $product->id)
            ->with(['bienThes', 'anhSanPhams'])
            ->limit(4)
            ->get();

        // Prepare variants data for JavaScript
        $variants = $product->bienThes->map(function($bt) {
            return [
                'id' => $bt->id,
                'sku' => $bt->sku,
                'gia' => $bt->gia,
                'so_luong_ton' => $bt->so_luong_ton,
                'giatri_ids' => $bt->giaTriThuocTinhs->pluck('id')->toArray()
            ];
        })->values();

        return view('frontend.products.show', compact('product', 'relatedProducts', 'variants'));
    }
}

