<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\NguoiDung;
use App\Models\SanPham;
use App\Models\PhieuNhap;
use App\Models\DanhGia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'today');
        $customMonth = $request->get('custom_month');
        $customYear = $request->get('custom_year', date('Y'));

        // Xác định khoảng thời gian
        $dateRange = $this->getDateRange($period, $customMonth, $customYear);
        
        // Lấy thống kê
        $stats = $this->getStatistics($dateRange, $period);
        
        // Lấy dữ liệu cho biểu đồ
        $chartData = $this->getChartData($dateRange, $period);
        
        return view('admin.thongke.index', compact('stats', 'chartData', 'period', 'customMonth', 'customYear'));
    }

    private function getDateRange($period, $customMonth = null, $customYear = null)
    {
        $now = Carbon::now();
        
        switch ($period) {
            case 'today':
                return [
                    'start' => $now->copy()->startOfDay(),
                    'end' => $now->copy()->endOfDay()
                ];
                
            case 'this_week':
                return [
                    'start' => $now->copy()->startOfWeek(),
                    'end' => $now->copy()->endOfWeek()
                ];
                
            case 'last_7_days':
                return [
                    'start' => $now->copy()->subDays(6)->startOfDay(),
                    'end' => $now->copy()->endOfDay()
                ];
                
            case 'this_month':
                return [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth()
                ];
                
            case 'this_quarter':
                return [
                    'start' => $now->copy()->startOfQuarter(),
                    'end' => $now->copy()->endOfQuarter()
                ];
                
            case 'this_year':
                return [
                    'start' => $now->copy()->startOfYear(),
                    'end' => $now->copy()->endOfYear()
                ];
                
            case 'custom_month':
                if ($customMonth && $customYear) {
                    $date = Carbon::createFromDate($customYear, $customMonth, 1);
                    return [
                        'start' => $date->copy()->startOfMonth(),
                        'end' => $date->copy()->endOfMonth()
                    ];
                }
                // Fallback to current month
                return [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth()
                ];
                
            default:
                return [
                    'start' => $now->copy()->startOfDay(),
                    'end' => $now->copy()->endOfDay()
                ];
        }
    }

    private function getStatistics($dateRange, $period)
    {
        $start = $dateRange['start'];
        $end = $dateRange['end'];

        // Thống kê đơn hàng
        $totalOrders = DonHang::whereBetween('created_at', [$start, $end])->count();
        $totalRevenue = DonHang::whereBetween('created_at', [$start, $end])->sum('thanh_tien');
        $completedOrders = DonHang::whereBetween('created_at', [$start, $end])->where('trang_thai', 'hoan_thanh')->count();
        $pendingOrders = DonHang::whereBetween('created_at', [$start, $end])->where('trang_thai', 'cho_xac_nhan')->count();
        $cancelledOrders = DonHang::whereBetween('created_at', [$start, $end])->where('trang_thai', 'da_huy')->count();

        // Thống kê người dùng mới
        $newUsers = NguoiDung::whereBetween('created_at', [$start, $end])->count();
        $totalUsers = NguoiDung::count();

        // Thống kê sản phẩm
        $newProducts = SanPham::whereBetween('created_at', [$start, $end])->count();
        $totalProducts = SanPham::count();

        // Thống kê phiếu nhập
        $totalImports = PhieuNhap::whereBetween('created_at', [$start, $end])->count();
        $totalImportValue = PhieuNhap::whereBetween('created_at', [$start, $end])->sum('tong_tien');

        // Thống kê đánh giá
        $newReviews = DanhGia::whereBetween('created_at', [$start, $end])->count();
        $totalReviews = DanhGia::count();
        $avgRating = DanhGia::whereBetween('created_at', [$start, $end])->avg('so_sao');

        // Top sản phẩm bán chạy
        $topProducts = DB::table('chitiet_donhang')
            ->join('bien_the', 'chitiet_donhang.bien_the_id', '=', 'bien_the.id')
            ->join('sanpham', 'bien_the.sanpham_id', '=', 'sanpham.id')
            ->join('donhang', 'chitiet_donhang.donhang_id', '=', 'donhang.id')
            ->whereBetween('donhang.created_at', [$start, $end])
            ->where('donhang.trang_thai', '!=', 'da_huy')
            ->select(
                'sanpham.ten',
                DB::raw('SUM(chitiet_donhang.so_luong) as total_sold'),
                DB::raw('SUM(chitiet_donhang.so_luong * chitiet_donhang.gia_luc_mua) as total_revenue')
            )
            ->groupBy('sanpham.id', 'sanpham.ten')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // So sánh với kỳ trước
        $previousRange = $this->getPreviousPeriodRange($dateRange, $period);
        $previousRevenue = DonHang::whereBetween('created_at', [$previousRange['start'], $previousRange['end']])
            ->sum('thanh_tien');
        $previousOrders = DonHang::whereBetween('created_at', [$previousRange['start'], $previousRange['end']])
            ->count();

        $revenueGrowth = $previousRevenue > 0 ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;
        $orderGrowth = $previousOrders > 0 ? (($totalOrders - $previousOrders) / $previousOrders) * 100 : 0;

        return [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'completed_orders' => $completedOrders,
            'pending_orders' => $pendingOrders,
            'cancelled_orders' => $cancelledOrders,
            'new_users' => $newUsers,
            'total_users' => $totalUsers,
            'new_products' => $newProducts,
            'total_products' => $totalProducts,
            'total_imports' => $totalImports,
            'total_import_value' => $totalImportValue,
            'new_reviews' => $newReviews,
            'total_reviews' => $totalReviews,
            'avg_rating' => round($avgRating, 1),
            'top_products' => $topProducts,
            'revenue_growth' => round($revenueGrowth, 1),
            'order_growth' => round($orderGrowth, 1),
        ];
    }

    private function getPreviousPeriodRange($currentRange, $period)
    {
        $start = $currentRange['start'];
        $end = $currentRange['end'];
        $duration = $start->diffInDays($end) + 1;

        return [
            'start' => $start->copy()->subDays($duration),
            'end' => $start->copy()->subDay()
        ];
    }

    private function getChartData($dateRange, $period)
    {
        $start = $dateRange['start'];
        $end = $dateRange['end'];

        // Xác định format ngày và interval dựa trên period
        switch ($period) {
            case 'today':
                $format = '%H:00';
                $interval = 'hour';
                break;
            case 'this_week':
            case 'last_7_days':
                $format = '%Y-%m-%d';
                $interval = 'day';
                break;
            case 'this_month':
            case 'custom_month':
                $format = '%Y-%m-%d';
                $interval = 'day';
                break;
            case 'this_quarter':
                $format = '%Y-%m';
                $interval = 'month';
                break;
            case 'this_year':
                $format = '%Y-%m';
                $interval = 'month';
                break;
            default:
                $format = '%Y-%m-%d';
                $interval = 'day';
        }

        // Dữ liệu doanh thu theo thời gian
        $revenueData = DonHang::whereBetween('created_at', [$start, $end])
            ->where('trang_thai', '!=', 'da_huy')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '$format') as period"),
                DB::raw('SUM(thanh_tien) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // Dữ liệu trạng thái đơn hàng
        $orderStatusData = DonHang::whereBetween('created_at', [$start, $end])
            ->select('trang_thai', DB::raw('COUNT(*) as count'))
            ->groupBy('trang_thai')
            ->get();

        return [
            'revenue_data' => $revenueData,
            'order_status_data' => $orderStatusData,
            'interval' => $interval
        ];
    }

    public function getChartDataAjax(Request $request)
    {
        $period = $request->get('period', 'today');
        $customMonth = $request->get('custom_month');
        $customYear = $request->get('custom_year', date('Y'));

        $dateRange = $this->getDateRange($period, $customMonth, $customYear);
        $chartData = $this->getChartData($dateRange, $period);

        return response()->json($chartData);
    }
}