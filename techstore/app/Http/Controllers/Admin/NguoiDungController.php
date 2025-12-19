<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use Illuminate\Http\Request;

class NguoiDungController extends Controller
{
    public function index(Request $request)
    {
        $query = NguoiDung::query();

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('ten', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('sdt', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['id', 'ten', 'email', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination - 8 items per page
        $users = $query->paginate(8)->withQueryString();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.nguoidung.table', compact('users'))->render(),
                'pagination' => view('admin.nguoidung.pagination', compact('users'))->render(),
            ]);
        }
        
        return view('admin.nguoidung.index', compact('users'));
    }

    public function show(NguoiDung $nguoidung)
    {
        $nguoidung->load('donHangs');
        return view('admin.nguoidung.show', ['user' => $nguoidung]);
    }

    public function toggleStatus(NguoiDung $nguoidung)
    {
        // Có thể thêm cột 'is_active' vào bảng nguoidung nếu cần
        // Hiện tại chỉ xem thông tin
        return redirect()->back();
    }
}

