<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\BienThe;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        // Validate cart items and stock
        foreach ($cart as $key => $item) {
            $variant = BienThe::find($item['variant_id']);
            if (!$variant || $variant->so_luong_ton < $item['quantity']) {
                return redirect()->route('cart.index')
                    ->with('error', 'Một số sản phẩm trong giỏ hàng không còn đủ số lượng. Vui lòng kiểm tra lại!');
            }
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('frontend.checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'dien_thoai' => 'required|string|max:20',
            'dia_chi' => 'required|string|max:500',
            'ghi_chu' => 'nullable|string|max:1000',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        // Validate stock again
        foreach ($cart as $item) {
            $variant = BienThe::find($item['variant_id']);
            if (!$variant || $variant->so_luong_ton < $item['quantity']) {
                return redirect()->route('cart.index')
                    ->with('error', 'Một số sản phẩm không còn đủ số lượng. Vui lòng kiểm tra lại!');
            }
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $donHang = DB::transaction(function () use ($request, $cart, $total) {
            // Get nguoi_dung_id if user is logged in
            $nguoiDungId = null;
            if (Auth::guard('customer')->check()) {
                $user = Auth::guard('customer')->user();
                // Auth::guard('customer')->user() already returns NguoiDung model, so we can use its id directly
                $nguoiDungId = $user->id;
                
                // Optionally update user's phone from checkout form
                if ($request->dien_thoai && $request->dien_thoai != $user->sdt) {
                    $user->sdt = $request->dien_thoai;
                    $user->save();
                }
            }

            // Generate unique order code
            do {
                $maDonHang = 'DH' . date('Ymd') . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
            } while (DonHang::where('ma_don_hang', $maDonHang)->exists());
            
            // Create order
            $donHang = DonHang::create([
                'ma_don_hang' => $maDonHang,
                'nguoi_dung_id' => $nguoiDungId,
                'ten_khach' => $request->ho_ten,
                'sdt_khach' => $request->dien_thoai,
                'email_khach' => $request->email,
                'dia_chi_khach' => $request->dia_chi,
                'phuong_thuc_thanh_toan' => $request->phuong_thuc_thanh_toan ?? 'cod',
                'tong_tien' => $total,
                'thanh_tien' => $total, // Tạm thời bằng tong_tien (chưa có mã giảm giá)
                'giam_gia' => 0,
                'trang_thai' => 'cho_xac_nhan',
                'ghi_chu' => $request->ghi_chu ?? null,
            ]);

            // Create order details and update stock
            foreach ($cart as $item) {
                $variant = BienThe::findOrFail($item['variant_id']);
                $thanhTien = $item['price'] * $item['quantity'];
                
                ChiTietDonHang::create([
                    'donhang_id' => $donHang->id,
                    'sanpham_id' => $item['product_id'],
                    'bien_the_id' => $item['variant_id'],
                    'so_luong' => $item['quantity'],
                    'gia_luc_mua' => $item['price'],
                    'thanh_tien' => $thanhTien,
                ]);

                // Update stock
                $variant->so_luong_ton -= $item['quantity'];
                $variant->save();
            }

            return $donHang;
        });

        // Clear cart
        session(['cart' => []]);

        $message = 'Đặt hàng thành công! Mã đơn hàng: ' . $donHang->ma_don_hang . '. Chúng tôi sẽ liên hệ với bạn sớm nhất.';
        
        if (!Auth::guard('customer')->check()) {
            $message .= ' Vui lòng lưu lại mã đơn hàng để tra cứu khi cần.';
        }

        return redirect()->route('home')
            ->with('success', $message);
    }
}

