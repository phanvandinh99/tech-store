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

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                  ->orWhere('ten_khach', 'like', '%' . $request->search . '%')
                  ->orWhere('sdt_khach', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status
        if ($request->has('trang_thai') && $request->trang_thai) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['id', 'tong_tien', 'trang_thai', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination - 8 items per page
        $donHangs = $query->paginate(8)->withQueryString();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.donhang.table', compact('donHangs'))->render(),
                'pagination' => view('admin.donhang.pagination', compact('donHangs'))->render(),
            ]);
        }
        
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

