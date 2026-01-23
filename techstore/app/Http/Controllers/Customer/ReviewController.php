<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DanhGia;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\AnhDanhGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    // Middleware sẽ được áp dụng thông qua routes

    // Hiển thị form đánh giá sản phẩm
    public function create(Request $request)
    {
        $donhangId = $request->donhang_id;
        $sanphamId = $request->sanpham_id;

        // Kiểm tra đơn hàng thuộc về user hiện tại và đã hoàn thành
        $donHang = DonHang::where('id', $donhangId)
                          ->where('nguoi_dung_id', Auth::id())
                          ->where('trang_thai', 'hoan_thanh')
                          ->first();

        if (!$donHang) {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng hoặc đơn hàng chưa hoàn thành.');
        }

        // Kiểm tra sản phẩm có trong đơn hàng không
        $chiTietDonHang = ChiTietDonHang::where('donhang_id', $donhangId)
                                       ->where('sanpham_id', $sanphamId)
                                       ->with('sanPham', 'bienThe')
                                       ->first();

        if (!$chiTietDonHang) {
            return redirect()->back()->with('error', 'Sản phẩm không có trong đơn hàng này.');
        }

        // Kiểm tra đã đánh giá chưa
        $existingReview = DanhGia::where('nguoi_dung_id', Auth::id())
                                ->where('sanpham_id', $sanphamId)
                                ->where('donhang_id', $donhangId)
                                ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        return view('frontend.reviews.create', compact('donHang', 'chiTietDonHang'));
    }

    // Lưu đánh giá
    public function store(Request $request)
    {
        $request->validate([
            'donhang_id' => 'required|exists:donhang,id',
            'sanpham_id' => 'required|exists:sanpham,id',
            'so_sao' => 'required|integer|min:1|max:5',
            'noi_dung' => 'required|string|min:10|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Kiểm tra quyền đánh giá
        $donHang = DonHang::where('id', $request->donhang_id)
                          ->where('nguoi_dung_id', Auth::id())
                          ->where('trang_thai', 'hoan_thanh')
                          ->first();

        if (!$donHang) {
            return redirect()->back()->with('error', 'Không có quyền đánh giá đơn hàng này.');
        }

        // Kiểm tra sản phẩm có trong đơn hàng
        $chiTietExists = ChiTietDonHang::where('donhang_id', $request->donhang_id)
                                      ->where('sanpham_id', $request->sanpham_id)
                                      ->exists();

        if (!$chiTietExists) {
            return redirect()->back()->with('error', 'Sản phẩm không có trong đơn hàng này.');
        }

        // Kiểm tra đã đánh giá chưa
        $existingReview = DanhGia::where('nguoi_dung_id', Auth::id())
                                ->where('sanpham_id', $request->sanpham_id)
                                ->where('donhang_id', $request->donhang_id)
                                ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        // Tạo đánh giá
        $danhGia = DanhGia::create([
            'nguoi_dung_id' => Auth::id(),
            'sanpham_id' => $request->sanpham_id,
            'donhang_id' => $request->donhang_id,
            'so_sao' => $request->so_sao,
            'noi_dung' => $request->noi_dung,
            'trang_thai' => 'pending'
        ]);

        // Upload ảnh nếu có
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');
                
                AnhDanhGia::create([
                    'danh_gia_id' => $danhGia->id,
                    'duong_dan' => $path
                ]);
            }
        }

        return redirect()->route('orders.show', $request->donhang_id)
                        ->with('success', 'Đánh giá của bạn đã được gửi và đang chờ duyệt.');
    }

    // Hiển thị đánh giá của user
    public function index()
    {
        $danhGias = DanhGia::where('nguoi_dung_id', Auth::id())
                          ->with(['sanPham', 'donHang', 'anhDanhGia'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);

        return view('frontend.reviews.index', compact('danhGias'));
    }

    // Xem chi tiết đánh giá
    public function show($id)
    {
        $danhGia = DanhGia::where('id', $id)
                         ->where('nguoi_dung_id', Auth::id())
                         ->with(['sanPham', 'donHang', 'anhDanhGia', 'binhLuans.nguoiDung'])
                         ->firstOrFail();

        return view('frontend.reviews.show', compact('danhGia'));
    }

    // Sửa đánh giá (chỉ khi chưa duyệt)
    public function edit($id)
    {
        $danhGia = DanhGia::where('id', $id)
                         ->where('nguoi_dung_id', Auth::id())
                         ->where('trang_thai', 'pending')
                         ->with(['sanPham', 'donHang', 'anhDanhGia'])
                         ->firstOrFail();

        return view('frontend.reviews.edit', compact('danhGia'));
    }

    // Cập nhật đánh giá
    public function update(Request $request, $id)
    {
        $danhGia = DanhGia::where('id', $id)
                         ->where('nguoi_dung_id', Auth::id())
                         ->where('trang_thai', 'pending')
                         ->firstOrFail();

        $request->validate([
            'so_sao' => 'required|integer|min:1|max:5',
            'noi_dung' => 'required|string|min:10|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Cập nhật đánh giá
        $danhGia->update([
            'so_sao' => $request->so_sao,
            'noi_dung' => $request->noi_dung
        ]);

        // Xử lý ảnh mới
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');
                
                AnhDanhGia::create([
                    'danh_gia_id' => $danhGia->id,
                    'duong_dan' => $path
                ]);
            }
        }

        return redirect()->route('reviews.show', $id)
                        ->with('success', 'Đánh giá đã được cập nhật.');
    }

    // Xóa ảnh đánh giá
    public function deleteImage($id)
    {
        $anhDanhGia = AnhDanhGia::whereHas('danhGia', function($query) {
            $query->where('nguoi_dung_id', Auth::id())
                  ->where('trang_thai', 'pending');
        })->findOrFail($id);

        // Xóa file
        if (Storage::disk('public')->exists($anhDanhGia->duong_dan)) {
            Storage::disk('public')->delete($anhDanhGia->duong_dan);
        }

        // Xóa record
        $anhDanhGia->delete();

        return response()->json(['success' => true]);
    }
}