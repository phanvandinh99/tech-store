<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Mail\OrderStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $oldStatus = $donHang->trang_thai;
        $newStatus = $request->trang_thai;

        // Nếu chuyển sang trạng thái "da_huy" và trước đó chưa phải "da_huy", cần hoàn lại số lượng tồn kho
        if ($newStatus === 'da_huy' && $oldStatus !== 'da_huy') {
            foreach ($donHang->chiTietDonHangs as $item) {
                $variant = $item->bienThe;
                if ($variant) {
                    $variant->so_luong_ton += $item->so_luong;
                    $variant->save();
                }
            }
        }

        $donHang->update(['trang_thai' => $newStatus]);

        // Gửi email thông báo cập nhật trạng thái cho khách hàng (chỉ khi trạng thái thay đổi)
        if ($oldStatus !== $newStatus && $donHang->email_khach) {
            try {
                Mail::to($donHang->email_khach)->send(new OrderStatusUpdated($donHang, $oldStatus, $newStatus));
            } catch (\Exception $e) {
                // Log lỗi nhưng không dừng quá trình
                \Log::error('Không thể gửi email cập nhật trạng thái đơn hàng: ' . $e->getMessage());
            }
        }

        return redirect()->back()
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    public function update(Request $request, DonHang $donHang)
    {
        $request->validate([
            'ten_khach' => 'required|string|max:255',
            'email_khach' => 'required|email|max:255',
            'sdt_khach' => 'required|string|max:20',
            'dia_chi_khach' => 'required|string|max:500',
            'phuong_thuc_thanh_toan' => 'nullable|string|max:50',
            'ghi_chu' => 'nullable|string|max:1000',
        ]);

        $donHang->update([
            'ten_khach' => $request->ten_khach,
            'email_khach' => $request->email_khach,
            'sdt_khach' => $request->sdt_khach,
            'dia_chi_khach' => $request->dia_chi_khach,
            'phuong_thuc_thanh_toan' => $request->phuong_thuc_thanh_toan ?? $donHang->phuong_thuc_thanh_toan,
            'ghi_chu' => $request->ghi_chu ?? null,
        ]);

        return redirect()->back()
            ->with('success', 'Cập nhật thông tin đơn hàng thành công!');
    }
}

