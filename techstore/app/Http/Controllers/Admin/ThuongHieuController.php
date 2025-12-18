<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThuongHieu;
use App\Models\NhatKyHoatDong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThuongHieuController extends Controller
{
    public function index(Request $request)
    {
        $query = ThuongHieu::withCount('sanPhams');

        if ($request->has('search') && $request->search) {
            $query->where('ten', 'like', '%' . $request->search . '%');
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['id', 'ten', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $thuongHieus = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.thuonghieu.table', compact('thuongHieus'))->render(),
                'pagination' => view('admin.thuonghieu.pagination', compact('thuongHieus'))->render(),
            ]);
        }

        return view('admin.thuonghieu.index', compact('thuongHieus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:thuong_hieu,ten',
            'mo_ta' => 'nullable|string',
            'hinh_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['ten', 'mo_ta']);

        if ($request->hasFile('hinh_logo')) {
            $data['hinh_logo'] = $request->file('hinh_logo')->store('thuonghieu', 'public');
        }

        $thuongHieu = ThuongHieu::create($data);

        NhatKyHoatDong::ghiLog('create', 'thuong_hieu', $thuongHieu->id, 
            'Thêm thương hiệu: ' . $thuongHieu->ten, null, $data);

        return redirect()->route('admin.thuonghieu.index')
            ->with('success', 'Thêm thương hiệu thành công!');
    }

    public function update(Request $request, $id)
    {
        $thuongHieu = ThuongHieu::findOrFail($id);
        $oldData = $thuongHieu->toArray();
        
        $request->validate([
            'ten' => 'required|string|max:100|unique:thuong_hieu,ten,' . $id,
            'mo_ta' => 'nullable|string',
            'hinh_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['ten', 'mo_ta']);

        if ($request->hasFile('hinh_logo')) {
            if ($thuongHieu->hinh_logo) {
                Storage::disk('public')->delete($thuongHieu->hinh_logo);
            }
            $data['hinh_logo'] = $request->file('hinh_logo')->store('thuonghieu', 'public');
        }

        $thuongHieu->update($data);

        NhatKyHoatDong::ghiLog('update', 'thuong_hieu', $thuongHieu->id,
            'Cập nhật thương hiệu: ' . $thuongHieu->ten, $oldData, $data);

        return redirect()->route('admin.thuonghieu.index')
            ->with('success', 'Cập nhật thương hiệu thành công!');
    }

    public function destroy($id)
    {
        $thuongHieu = ThuongHieu::findOrFail($id);
        
        if ($thuongHieu->sanPhams()->count() > 0) {
            return redirect()->route('admin.thuonghieu.index')
                ->with('error', 'Không thể xóa thương hiệu đang có sản phẩm!');
        }

        if ($thuongHieu->hinh_logo) {
            Storage::disk('public')->delete($thuongHieu->hinh_logo);
        }

        NhatKyHoatDong::ghiLog('delete', 'thuong_hieu', $thuongHieu->id,
            'Xóa thương hiệu: ' . $thuongHieu->ten, $thuongHieu->toArray(), null);

        $thuongHieu->delete();

        return redirect()->route('admin.thuonghieu.index')
            ->with('success', 'Xóa thương hiệu thành công!');
    }
}

