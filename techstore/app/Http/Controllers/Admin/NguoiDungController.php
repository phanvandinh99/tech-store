<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NguoiDung;
use Illuminate\Http\Request;

class NguoiDungController extends Controller
{
    public function index(Request $request)
    {
        $query = NguoiDung::query();

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('ten', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
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

