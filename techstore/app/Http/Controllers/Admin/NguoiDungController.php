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

        // Filter by role
        if ($request->has('vai_tro') && $request->vai_tro) {
            $query->where('vai_tro', $request->vai_tro);
        }

        // Filter by status
        if ($request->has('trang_thai') && $request->trang_thai) {
            $query->where('trang_thai', $request->trang_thai);
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
        $nguoiDungs = $query->paginate(8)->withQueryString();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.nguoidung.table', compact('nguoiDungs'))->render(),
                'pagination' => view('admin.nguoidung.pagination', compact('nguoiDungs'))->render(),
            ]);
        }
        
        return view('admin.nguoidung.index', compact('nguoiDungs'));
    }

    public function show(NguoiDung $nguoidung)
    {
        $nguoidung->load('donHangs');
        return view('admin.nguoidung.show', compact('nguoidung'));
    }

    public function toggleStatus(NguoiDung $nguoidung)
    {
        // Không cho phép khóa chính mình
        if ($nguoidung->id == auth()->id()) {
            return redirect()->back()->with('error', 'Không thể thay đổi trạng thái tài khoản của chính mình.');
        }

        // Chuyển đổi trạng thái
        $newStatus = $nguoidung->trang_thai == 'active' ? 'inactive' : 'active';
        $nguoidung->update(['trang_thai' => $newStatus]);

        $message = $newStatus == 'active' ? 'Đã kích hoạt tài khoản.' : 'Đã khóa tài khoản.';
        
        return redirect()->back()->with('success', $message);
    }
}

