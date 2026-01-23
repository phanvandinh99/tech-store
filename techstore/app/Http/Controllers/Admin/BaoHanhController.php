<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\YeuCauBaoHanh;
use App\Models\NhatKyHoatDong;
use Illuminate\Http\Request;

class BaoHanhController extends Controller
{
    public function index(Request $request)
    {
        $query = YeuCauBaoHanh::with(['nguoiDung', 'bienThe.sanPham', 'donHang']);

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('ma_yeu_cau', 'like', '%' . $request->search . '%')
                  ->orWhereHas('nguoiDung', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->has('trang_thai') && $request->trang_thai) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->has('hinh_thuc') && $request->hinh_thuc) {
            $query->where('hinh_thuc_bao_hanh', $request->hinh_thuc);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $yeuCaus = $query->paginate(10)->withQueryString();

        // Thống kê
        $thongKe = [
            'tong' => YeuCauBaoHanh::count(),
            'cho_tiep_nhan' => YeuCauBaoHanh::where('trang_thai', 'cho_tiep_nhan')->count(),
            'dang_xu_ly' => YeuCauBaoHanh::where('trang_thai', 'dang_xu_ly')->count(),
            'hoan_tat' => YeuCauBaoHanh::where('trang_thai', 'hoan_tat')->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.baohanh.table', compact('yeuCaus'))->render(),
                'pagination' => view('admin.baohanh.pagination', compact('yeuCaus'))->render(),
            ]);
        }

        return view('admin.baohanh.index', compact('yeuCaus', 'thongKe'));
    }

    public function show($id)
    {
        $yeuCau = YeuCauBaoHanh::with([
            'nguoiDung', 'bienThe.sanPham', 'donHang.chiTietDonHangs', 'anhBaoHanh'
        ])->findOrFail($id);
        
        return view('admin.baohanh.show', compact('yeuCau'));
    }

    public function updateStatus(Request $request, $id)
    {
        $yeuCau = YeuCauBaoHanh::findOrFail($id);
        $oldData = $yeuCau->toArray();

        $request->validate([
            'trang_thai' => 'required|in:cho_tiep_nhan,dang_xu_ly,hoan_tat,tu_choi',
            'ghi_chu_noi_bo' => 'nullable|string',
            'phieu_bao_hanh_chinh_hang' => 'nullable|string|max:100',
        ]);

        $data = [
            'trang_thai' => $request->trang_thai,
            'ghi_chu_noi_bo' => $request->ghi_chu_noi_bo,
            'phieu_bao_hanh_chinh_hang' => $request->phieu_bao_hanh_chinh_hang,
        ];

        // Cập nhật ngày tiếp nhận khi chuyển sang dang_xu_ly
        if ($request->trang_thai === 'dang_xu_ly' && !$yeuCau->ngay_tiep_nhan) {
            $data['ngay_tiep_nhan'] = now();
        }

        // Cập nhật ngày hoàn thành khi chuyển sang hoan_tat hoặc tu_choi
        if (in_array($request->trang_thai, ['hoan_tat', 'tu_choi']) && !$yeuCau->ngay_hoan_thanh) {
            $data['ngay_hoan_thanh'] = now();
        }

        $yeuCau->update($data);

        $statusLabels = [
            'cho_tiep_nhan' => 'Chờ tiếp nhận',
            'dang_xu_ly' => 'Đang xử lý',
            'hoan_tat' => 'Hoàn tất',
            'tu_choi' => 'Từ chối'
        ];

        NhatKyHoatDong::ghiLog('update', 'yeu_cau_bao_hanh', $yeuCau->id,
            'Cập nhật yêu cầu bảo hành: ' . $yeuCau->ma_yeu_cau . ' - ' . $statusLabels[$request->trang_thai],
            $oldData, $data);

        return redirect()->back()
            ->with('success', 'Cập nhật trạng thái bảo hành thành công!');
    }

    public function destroy($id)
    {
        $yeuCau = YeuCauBaoHanh::findOrFail($id);

        NhatKyHoatDong::ghiLog('delete', 'yeu_cau_bao_hanh', $yeuCau->id,
            'Xóa yêu cầu bảo hành: ' . $yeuCau->ma_yeu_cau,
            $yeuCau->toArray(), null);

        $yeuCau->delete();

        return redirect()->route('admin.baohanh.index')
            ->with('success', 'Xóa yêu cầu bảo hành thành công!');
    }
}

