<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\SanPham;
use App\Models\BienThe;
use App\Models\NguoiDung;
use App\Models\DanhGia;
use App\Models\YeuCauBaoHanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê cơ bản
        $stats = [
            'total_orders' => DonHang::count(),
            'pending_orders' => DonHang::where('trang_thai', 'cho_xac_nhan')->count(),
            'total_products' => SanPham::count(),
            'total_customers' => NguoiDung::where('vai_tro', 'customer')->count(),
            'today_revenue' => DonHang::whereDate('created_at', today())
                ->where('trang_thai', 'hoan_thanh')
                ->sum('thanh_tien'),
            'month_revenue' => DonHang::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('trang_thai', 'hoan_thanh')
                ->sum('thanh_tien'),
            'pending_reviews' => DanhGia::where('trang_thai', 'pending')->count(),
            'pending_warranty' => YeuCauBaoHanh::where('trang_thai', 'cho_tiep_nhan')->count(),
        ];

        // Thống kê đơn hàng theo trạng thái
        $orderStats = [
            'cho_xac_nhan' => DonHang::where('trang_thai', 'cho_xac_nhan')->count(),
            'da_xac_nhan' => DonHang::where('trang_thai', 'da_xac_nhan')->count(),
            'dang_giao' => DonHang::where('trang_thai', 'dang_giao')->count(),
            'hoan_thanh' => DonHang::where('trang_thai', 'hoan_thanh')->count(),
            'da_huy' => DonHang::where('trang_thai', 'da_huy')->count(),
        ];

        // Đơn hàng gần đây
        $recentOrders = DonHang::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Sản phẩm bán chạy
        $topProducts = DB::table('chitiet_donhang')
            ->join('sanpham', 'chitiet_donhang.sanpham_id', '=', 'sanpham.id')
            ->join('donhang', 'chitiet_donhang.donhang_id', '=', 'donhang.id')
            ->where('donhang.trang_thai', 'hoan_thanh')
            ->select('sanpham.ten', DB::raw('SUM(chitiet_donhang.so_luong) as total_sold'))
            ->groupBy('sanpham.id', 'sanpham.ten')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Cảnh báo tồn kho (sản phẩm sắp hết hàng)
        $lowStockThreshold = 10; // Ngưỡng cảnh báo
        $lowStockProducts = BienThe::with('sanPham')
            ->where('so_luong_ton', '<=', $lowStockThreshold)
            ->where('so_luong_ton', '>', 0)
            ->orderBy('so_luong_ton', 'asc')
            ->limit(10)
            ->get();

        // Sản phẩm hết hàng
        $outOfStockProducts = BienThe::with('sanPham')
            ->where('so_luong_ton', 0)
            ->limit(10)
            ->get();

        // Doanh thu 7 ngày gần nhất
        $revenueChart = DonHang::where('trang_thai', 'hoan_thanh')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, SUM(thanh_tien) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Tạo mảng 7 ngày
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d/m');
            $chartData[] = $revenueChart->get($date)?->revenue ?? 0;
        }

        return view('admin.dashboard', compact(
            'stats', 'orderStats', 'recentOrders', 'topProducts',
            'lowStockProducts', 'outOfStockProducts', 'chartLabels', 'chartData'
        ));
    }
}
