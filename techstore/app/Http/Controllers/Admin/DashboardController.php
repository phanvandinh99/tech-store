<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\SanPham;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => DonHang::count(),
            'pending_orders' => DonHang::where('trang_thai', 'cho_xac_nhan')->count(),
            'total_products' => SanPham::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'today_revenue' => DonHang::whereDate('created_at', today())
                ->where('trang_thai', 'hoan_thanh')
                ->sum('tong_tien'),
            'month_revenue' => DonHang::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('trang_thai', 'hoan_thanh')
                ->sum('tong_tien'),
        ];

        $recentOrders = DonHang::with('nguoiDung')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $topProducts = DB::table('chitiet_donhang')
            ->join('sanpham', 'chitiet_donhang.sanpham_id', '=', 'sanpham.id')
            ->select('sanpham.ten', DB::raw('SUM(chitiet_donhang.so_luong) as total_sold'))
            ->groupBy('sanpham.id', 'sanpham.ten')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}

