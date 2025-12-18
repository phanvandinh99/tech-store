<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhGia;
use App\Models\BinhLuan;
use App\Models\NhatKyHoatDong;
use Illuminate\Http\Request;

class DanhGiaController extends Controller
{
    public function index(Request $request)
    {
        $query = DanhGia::with(['nguoiDung', 'sanPham', 'anhDanhGia'])
            ->withCount('binhLuans');

        if ($request->has('search') && $request->search) {
            $query->whereHas('sanPham', function($q) use ($request) {
                $q->where('ten', 'like', '%' . $request->search . '%');
            })->orWhereHas('nguoiDung', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('trang_thai') && $request->trang_thai) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->has('so_sao') && $request->so_sao) {
            $query->where('so_sao', $request->so_sao);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $danhGias = $query->paginate(10)->withQueryString();

        // Thống kê
        $thongKe = [
            'tong' => DanhGia::count(),
            'cho_duyet' => DanhGia::where('trang_thai', 'pending')->count(),
            'da_duyet' => DanhGia::where('trang_thai', 'approved')->count(),
            'da_an' => DanhGia::where('trang_thai', 'hidden')->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.danhgia.table', compact('danhGias'))->render(),
                'pagination' => view('admin.danhgia.pagination', compact('danhGias'))->render(),
            ]);
        }

        return view('admin.danhgia.index', compact('danhGias', 'thongKe'));
    }

    public function show($id)
    {
        $danhGia = DanhGia::with(['nguoiDung', 'sanPham', 'donHang', 'anhDanhGia', 'binhLuans.nguoiDung'])
            ->findOrFail($id);
        
        return view('admin.danhgia.show', compact('danhGia'));
    }

    public function updateStatus(Request $request, $id)
    {
        $danhGia = DanhGia::findOrFail($id);
        $oldStatus = $danhGia->trang_thai;

        $request->validate([
            'trang_thai' => 'required|in:pending,approved,hidden,rejected'
        ]);

        $danhGia->trang_thai = $request->trang_thai;
        $danhGia->save();

        $statusLabels = [
            'pending' => 'Chờ duyệt',
            'approved' => 'Đã duyệt',
            'hidden' => 'Đã ẩn',
            'rejected' => 'Từ chối'
        ];

        NhatKyHoatDong::ghiLog('update', 'danh_gia', $danhGia->id,
            'Cập nhật trạng thái đánh giá: ' . $statusLabels[$request->trang_thai],
            ['trang_thai' => $oldStatus], ['trang_thai' => $request->trang_thai]);

        return redirect()->back()
            ->with('success', 'Cập nhật trạng thái đánh giá thành công!');
    }

    public function destroy($id)
    {
        $danhGia = DanhGia::findOrFail($id);

        NhatKyHoatDong::ghiLog('delete', 'danh_gia', $danhGia->id,
            'Xóa đánh giá của: ' . ($danhGia->nguoiDung->name ?? 'N/A'),
            $danhGia->toArray(), null);

        $danhGia->delete();

        return redirect()->route('admin.danhgia.index')
            ->with('success', 'Xóa đánh giá thành công!');
    }

    // Quản lý bình luận
    public function binhLuanIndex(Request $request)
    {
        $query = BinhLuan::with(['nguoiDung', 'danhGia.sanPham']);

        if ($request->has('trang_thai') && $request->trang_thai) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $binhLuans = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $thongKe = [
            'tong' => BinhLuan::count(),
            'cho_duyet' => BinhLuan::where('trang_thai', 'pending')->count(),
        ];

        return view('admin.danhgia.binhluan', compact('binhLuans', 'thongKe'));
    }

    public function binhLuanUpdateStatus(Request $request, $id)
    {
        $binhLuan = BinhLuan::findOrFail($id);
        $oldStatus = $binhLuan->trang_thai;

        $request->validate([
            'trang_thai' => 'required|in:pending,approved,hidden,rejected'
        ]);

        $binhLuan->trang_thai = $request->trang_thai;
        $binhLuan->save();

        NhatKyHoatDong::ghiLog('update', 'binh_luan', $binhLuan->id,
            'Cập nhật trạng thái bình luận',
            ['trang_thai' => $oldStatus], ['trang_thai' => $request->trang_thai]);

        return redirect()->back()
            ->with('success', 'Cập nhật trạng thái bình luận thành công!');
    }

    public function binhLuanDestroy($id)
    {
        $binhLuan = BinhLuan::findOrFail($id);

        NhatKyHoatDong::ghiLog('delete', 'binh_luan', $binhLuan->id,
            'Xóa bình luận', $binhLuan->toArray(), null);

        $binhLuan->delete();

        return redirect()->back()
            ->with('success', 'Xóa bình luận thành công!');
    }
}

