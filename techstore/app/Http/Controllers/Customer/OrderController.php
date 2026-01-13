<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('customer')->user();
        
        $query = DonHang::with(['chiTietDonHangs.bienThe.sanPham.danhMuc'])
            ->where('nguoi_dung_id', $user->id);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('trang_thai', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->orderBy('thanh_tien', 'asc');
                break;
            case 'price_high':
                $query->orderBy('thanh_tien', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $orders = $query->paginate(10)->withQueryString();

        // Tính tổng số đơn hàng theo từng trạng thái
        $statusCounts = [
            'all' => DonHang::where('nguoi_dung_id', $user->id)->count(),
            'cho_xac_nhan' => DonHang::where('nguoi_dung_id', $user->id)->where('trang_thai', 'cho_xac_nhan')->count(),
            'da_xac_nhan' => DonHang::where('nguoi_dung_id', $user->id)->where('trang_thai', 'da_xac_nhan')->count(),
            'dang_giao' => DonHang::where('nguoi_dung_id', $user->id)->where('trang_thai', 'dang_giao')->count(),
            'hoan_thanh' => DonHang::where('nguoi_dung_id', $user->id)->where('trang_thai', 'hoan_thanh')->count(),
            'da_huy' => DonHang::where('nguoi_dung_id', $user->id)->where('trang_thai', 'da_huy')->count(),
        ];

        return view('frontend.orders.index', compact('orders', 'statusCounts'));
    }

    public function show($id)
    {
        $user = Auth::guard('customer')->user();
        
        $order = DonHang::with([
            'chiTietDonHangs.bienThe.sanPham.danhMuc',
            'chiTietDonHangs.bienThe.sanPham.anhSanPhams',
            'nguoiDung'
        ])->where('nguoi_dung_id', $user->id)
          ->findOrFail($id);

        return view('frontend.orders.show', compact('order'));
    }

    public function cancel(Request $request, $id)
    {
        $user = Auth::guard('customer')->user();
        
        $order = DonHang::where('nguoi_dung_id', $user->id)
            ->findOrFail($id);

        // Chỉ cho phép hủy nếu đơn hàng chưa được xác nhận
        if ($order->trang_thai !== 'cho_xac_nhan') {
            return redirect()->back()
                ->with('error', 'Chỉ có thể hủy đơn hàng khi đơn hàng đang ở trạng thái "Chờ xác nhận"!');
        }

        // Hoàn lại số lượng tồn kho
        foreach ($order->chiTietDonHangs as $item) {
            $variant = $item->bienThe;
            if ($variant) {
                $variant->so_luong_ton += $item->so_luong;
                $variant->save();
            }
        }

        // Cập nhật trạng thái đơn hàng
        $order->update(['trang_thai' => 'da_huy']);

        return redirect()->back()
            ->with('success', 'Đơn hàng đã được hủy thành công!');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::guard('customer')->user();
        
        $order = DonHang::where('nguoi_dung_id', $user->id)
            ->findOrFail($id);

        // Chỉ cho phép cập nhật nếu đơn hàng chưa được xác nhận
        if ($order->trang_thai !== 'cho_xac_nhan') {
            return redirect()->back()
                ->with('error', 'Chỉ có thể cập nhật đơn hàng khi đơn hàng đang ở trạng thái "Chờ xác nhận"!');
        }

        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'dien_thoai' => 'required|string|max:20',
            'dia_chi' => 'required|string|max:500',
            'ghi_chu' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'ten_khach' => $request->ho_ten,
            'email_khach' => $request->email,
            'sdt_khach' => $request->dien_thoai,
            'dia_chi_khach' => $request->dia_chi,
            'ghi_chu' => $request->ghi_chu ?? null,
        ]);

        return redirect()->back()
            ->with('success', 'Cập nhật thông tin đơn hàng thành công!');
    }
}
