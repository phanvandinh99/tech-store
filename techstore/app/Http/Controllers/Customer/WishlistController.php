<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DanhSachYeuThich;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{

    public function index()
    {
        $wishlists = DanhSachYeuThich::with(['sanPham.anhSanPhams', 'sanPham.bienThes'])
            ->where('nguoi_dung_id', Auth::guard('customer')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('frontend.wishlist.index', compact('wishlists'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:sanpham,id'
        ]);

        $userId = Auth::guard('customer')->id();
        $productId = $request->product_id;

        // Kiểm tra xem sản phẩm đã có trong wishlist chưa
        $exists = DanhSachYeuThich::where('nguoi_dung_id', $userId)
            ->where('sanpham_id', $productId)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm đã có trong danh sách yêu thích'
            ]);
        }

        // Thêm vào wishlist
        DanhSachYeuThich::create([
            'nguoi_dung_id' => $userId,
            'sanpham_id' => $productId,
            'created_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào danh sách yêu thích'
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:sanpham,id'
        ]);

        $userId = Auth::guard('customer')->id();
        $productId = $request->product_id;

        $deleted = DanhSachYeuThich::where('nguoi_dung_id', $userId)
            ->where('sanpham_id', $productId)
            ->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm trong danh sách yêu thích'
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:sanpham,id'
        ]);

        $userId = Auth::guard('customer')->id();
        $productId = $request->product_id;

        $wishlist = DanhSachYeuThich::where('nguoi_dung_id', $userId)
            ->where('sanpham_id', $productId)
            ->first();

        if ($wishlist) {
            // Xóa khỏi wishlist
            $wishlist->delete();
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích'
            ]);
        } else {
            // Thêm vào wishlist
            DanhSachYeuThich::create([
                'nguoi_dung_id' => $userId,
                'sanpham_id' => $productId,
                'created_at' => now()
            ]);
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Đã thêm sản phẩm vào danh sách yêu thích'
            ]);
        }
    }

    public function check(Request $request)
    {
        if (!Auth::guard('customer')->check()) {
            return response()->json(['inWishlist' => false]);
        }

        $request->validate([
            'product_id' => 'required|exists:sanpham,id'
        ]);

        $userId = Auth::guard('customer')->id();
        $productId = $request->product_id;

        $inWishlist = DanhSachYeuThich::where('nguoi_dung_id', $userId)
            ->where('sanpham_id', $productId)
            ->exists();

        return response()->json(['inWishlist' => $inWishlist]);
    }
}