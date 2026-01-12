<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;

class NhaCungCapController extends Controller
{
    public function index(Request $request)
    {
        $query = NhaCungCap::query();

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('ten', 'like', '%' . $request->search . '%')
                  ->orWhere('sdt', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['id', 'ten', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $nhaCungCaps = $query->paginate(15)->withQueryString();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.nhacungcap.table', compact('nhaCungCaps'))->render(),
                'pagination' => view('admin.nhacungcap.pagination', compact('nhaCungCaps'))->render(),
            ]);
        }

        return view('admin.nhacungcap.index', compact('nhaCungCaps'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'ten' => 'required|string|max:150',
                'sdt' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:150',
                'dia_chi' => 'nullable|string',
            ]);

            NhaCungCap::create($validated);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Thêm nhà cung cấp thành công!']);
            }

            return redirect()->back()->with('success', 'Thêm nhà cung cấp thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi thêm nhà cung cấp!',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $nhaCungCap = NhaCungCap::findOrFail($id);
            
            $validated = $request->validate([
                'ten' => 'required|string|max:150',
                'sdt' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:150',
                'dia_chi' => 'nullable|string',
            ]);

            $nhaCungCap->update($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Cập nhật nhà cung cấp thành công!']);
            }

            return redirect()->back()->with('success', 'Cập nhật nhà cung cấp thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi cập nhật nhà cung cấp!',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi cập nhật nhà cung cấp: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật nhà cung cấp!');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $nhaCungCap = NhaCungCap::findOrFail($id);
            $nhaCungCap->delete();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Xóa nhà cung cấp thành công!']);
            }

            return redirect()->route('admin.nhacungcap.index')
                ->with('success', 'Xóa nhà cung cấp thành công!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi xóa nhà cung cấp!'
                ], 500);
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa nhà cung cấp!');
        }
    }
}

