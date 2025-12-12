<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{
    public function index(Request $request)
    {
        $query = DanhMuc::query();

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('ten', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['id', 'ten', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination - 8 items per page
        $danhMucs = $query->paginate(8)->withQueryString();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.danhmuc.table', compact('danhMucs'))->render(),
                'pagination' => view('admin.danhmuc.pagination', compact('danhMucs'))->render(),
            ]);
        }

        return view('admin.danhmuc.index', compact('danhMucs'));
    }

    public function create()
    {
        return view('admin.danhmuc.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:danhmuc,ten',
        ]);

        DanhMuc::create($request->only('ten'));

        return redirect()->route('admin.danhmuc.index')
            ->with('success', 'Thêm danh mục thành công!');
    }

    public function edit(DanhMuc $danhMuc)
    {
        return view('admin.danhmuc.edit', compact('danhMuc'));
    }

    public function update(Request $request, DanhMuc $danhMuc)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:danhmuc,ten,' . $danhMuc->id,
        ]);

        $danhMuc->update($request->only('ten'));

        return redirect()->route('admin.danhmuc.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(DanhMuc $danhMuc)
    {
        $danhMuc->delete();
        return redirect()->route('admin.danhmuc.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}

