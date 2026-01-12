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
        $user = Auth::user();
        
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
        $user = Auth::user();
        
        $order = DonHang::with([
            'chiTietDonHangs.bienThe.sanPham.danhMuc',
            'chiTietDonHangs.bienThe.sanPham.anhSanPhams',
            'nguoiDung'
        ])->where('nguoi_dung_id', $user->id)
          ->findOrFail($id);

        return view('frontend.orders.show', compact('order'));
    }
}
