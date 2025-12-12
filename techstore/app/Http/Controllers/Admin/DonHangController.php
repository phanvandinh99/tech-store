<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use Illuminate\Http\Request;

class DonHangController extends Controller
{
    public function index(Request $request)
    {
        $query = DonHang::with('nguoiDung', 'chiTietDonHangs.sanPham', 'chiTietDonHangs.bienThe');

        if ($request->has('trang_thai') && $request->trang_thai) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $donHangs = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.donhang.index', compact('donHangs'));
    }

    public function show(DonHang $donHang)
    {
        $donHang->load('nguoiDung', 'chiTietDonHangs.sanPham', 'chiTietDonHangs.bienThe');
        return view('admin.donhang.show', compact('donHang'));
    }

    public function updateStatus(Request $request, DonHang $donHang)
    {
        $request->validate([
            'trang_thai' => 'required|in:cho_xac_nhan,da_xac_nhan,dang_giao,hoan_thanh,da_huy',
        ]);

        $donHang->update(['trang_thai' => $request->trang_thai]);

        return redirect()->back()
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}

