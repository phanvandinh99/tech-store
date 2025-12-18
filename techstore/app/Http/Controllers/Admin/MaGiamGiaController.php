<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaGiamGia;
use App\Models\NhatKyHoatDong;
use Illuminate\Http\Request;

class MaGiamGiaController extends Controller
{
    public function index(Request $request)
    {
        $query = MaGiamGia::with('nguoiTao');

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('ma_voucher', 'like', '%' . $request->search . '%')
                  ->orWhere('ten', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('trang_thai') && $request->trang_thai) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $maGiamGias = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.magiamgia.table', compact('maGiamGias'))->render(),
                'pagination' => view('admin.magiamgia.pagination', compact('maGiamGias'))->render(),
            ]);
        }

        return view('admin.magiamgia.index', compact('maGiamGias'));
    }

    public function create()
    {
        return view('admin.magiamgia.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_voucher' => 'required|string|max:50|unique:ma_giam_gia,ma_voucher',
            'ten' => 'required|string|max:150',
            'loai_giam_gia' => 'required|in:percent,fixed',
            'gia_tri_giam' => 'required|numeric|min:0',
            'don_toi_thieu' => 'nullable|numeric|min:0',
            'so_lan_su_dung_toi_da' => 'nullable|integer|min:1',
            'ngay_bat_dau' => 'nullable|date',
            'ngay_ket_thuc' => 'nullable|date|after_or_equal:ngay_bat_dau',
            'mo_ta' => 'nullable|string',
        ]);

        $data = $request->only([
            'ma_voucher', 'ten', 'loai_giam_gia', 'gia_tri_giam',
            'don_toi_thieu', 'so_lan_su_dung_toi_da', 'ngay_bat_dau',
            'ngay_ket_thuc', 'mo_ta'
        ]);
        $data['nguoi_tao_id'] = auth()->id();
        $data['trang_thai'] = 'active';

        $maGiamGia = MaGiamGia::create($data);

        NhatKyHoatDong::ghiLog('create', 'ma_giam_gia', $maGiamGia->id,
            'Thêm mã giảm giá: ' . $maGiamGia->ma_voucher, null, $data);

        return redirect()->route('admin.magiamgia.index')
            ->with('success', 'Thêm mã giảm giá thành công!');
    }

    public function edit($id)
    {
        $maGiamGia = MaGiamGia::findOrFail($id);
        return view('admin.magiamgia.edit', compact('maGiamGia'));
    }

    public function update(Request $request, $id)
    {
        $maGiamGia = MaGiamGia::findOrFail($id);
        $oldData = $maGiamGia->toArray();

        $request->validate([
            'ma_voucher' => 'required|string|max:50|unique:ma_giam_gia,ma_voucher,' . $id,
            'ten' => 'required|string|max:150',
            'loai_giam_gia' => 'required|in:percent,fixed',
            'gia_tri_giam' => 'required|numeric|min:0',
            'don_toi_thieu' => 'nullable|numeric|min:0',
            'so_lan_su_dung_toi_da' => 'nullable|integer|min:1',
            'ngay_bat_dau' => 'nullable|date',
            'ngay_ket_thuc' => 'nullable|date|after_or_equal:ngay_bat_dau',
            'trang_thai' => 'required|in:active,inactive,expired',
            'mo_ta' => 'nullable|string',
        ]);

        $data = $request->only([
            'ma_voucher', 'ten', 'loai_giam_gia', 'gia_tri_giam',
            'don_toi_thieu', 'so_lan_su_dung_toi_da', 'ngay_bat_dau',
            'ngay_ket_thuc', 'trang_thai', 'mo_ta'
        ]);

        $maGiamGia->update($data);

        NhatKyHoatDong::ghiLog('update', 'ma_giam_gia', $maGiamGia->id,
            'Cập nhật mã giảm giá: ' . $maGiamGia->ma_voucher, $oldData, $data);

        return redirect()->route('admin.magiamgia.index')
            ->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy($id)
    {
        $maGiamGia = MaGiamGia::findOrFail($id);

        if ($maGiamGia->donHangs()->count() > 0) {
            return redirect()->route('admin.magiamgia.index')
                ->with('error', 'Không thể xóa mã giảm giá đã được sử dụng!');
        }

        NhatKyHoatDong::ghiLog('delete', 'ma_giam_gia', $maGiamGia->id,
            'Xóa mã giảm giá: ' . $maGiamGia->ma_voucher, $maGiamGia->toArray(), null);

        $maGiamGia->delete();

        return redirect()->route('admin.magiamgia.index')
            ->with('success', 'Xóa mã giảm giá thành công!');
    }

    public function toggleStatus($id)
    {
        $maGiamGia = MaGiamGia::findOrFail($id);
        $oldStatus = $maGiamGia->trang_thai;
        
        $maGiamGia->trang_thai = $maGiamGia->trang_thai === 'active' ? 'inactive' : 'active';
        $maGiamGia->save();

        NhatKyHoatDong::ghiLog('update', 'ma_giam_gia', $maGiamGia->id,
            'Đổi trạng thái mã giảm giá: ' . $maGiamGia->ma_voucher,
            ['trang_thai' => $oldStatus], ['trang_thai' => $maGiamGia->trang_thai]);

        return redirect()->route('admin.magiamgia.index')
            ->with('success', 'Cập nhật trạng thái thành công!');
    }
}

