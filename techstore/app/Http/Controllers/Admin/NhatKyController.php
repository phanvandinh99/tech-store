<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NhatKyHoatDong;
use Illuminate\Http\Request;

class NhatKyController extends Controller
{
    public function index(Request $request)
    {
        $query = NhatKyHoatDong::with('nguoiDung');

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('mo_ta', 'like', '%' . $request->search . '%')
                  ->orWhere('loai_model', 'like', '%' . $request->search . '%')
                  ->orWhereHas('nguoiDung', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->has('hanh_dong') && $request->hanh_dong) {
            $query->where('hanh_dong', $request->hanh_dong);
        }

        if ($request->has('loai_model') && $request->loai_model) {
            $query->where('loai_model', $request->loai_model);
        }

        if ($request->has('ngay_bat_dau') && $request->ngay_bat_dau) {
            $query->whereDate('created_at', '>=', $request->ngay_bat_dau);
        }

        if ($request->has('ngay_ket_thuc') && $request->ngay_ket_thuc) {
            $query->whereDate('created_at', '<=', $request->ngay_ket_thuc);
        }

        $nhatKys = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        // Lấy danh sách loại model để filter
        $loaiModels = NhatKyHoatDong::distinct()->pluck('loai_model');

        // Thống kê
        $thongKe = [
            'tong' => NhatKyHoatDong::count(),
            'hom_nay' => NhatKyHoatDong::whereDate('created_at', today())->count(),
            'tuan_nay' => NhatKyHoatDong::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.nhatky.table', compact('nhatKys'))->render(),
                'pagination' => view('admin.nhatky.pagination', compact('nhatKys'))->render(),
            ]);
        }

        return view('admin.nhatky.index', compact('nhatKys', 'loaiModels', 'thongKe'));
    }

    public function show($id)
    {
        $nhatKy = NhatKyHoatDong::with('nguoiDung')->findOrFail($id);
        return view('admin.nhatky.show', compact('nhatKy'));
    }
}

