@extends('admin.layout')

@section('title', 'Thống kê')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-graph-up"></i> Thống kê hệ thống</h4>
            </div>
            <div class="card-body">
                <!-- Bộ lọc thời gian -->
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Khoảng thời gian</label>
                        <select name="period" class="form-select" id="periodSelect" onchange="toggleCustomMonth()">
                            <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Hôm nay</option>
                            <option value="this_week" {{ $period == 'this_week' ? 'selected' : '' }}>Tuần này</option>
                            <option value="last_7_days" {{ $period == 'last_7_days' ? 'selected' : '' }}>7 ngày gần nhất</option>
                            <option value="this_month" {{ $period == 'this_month' ? 'selected' : '' }}>Tháng này</option>
                            <option value="this_quarter" {{ $period == 'this_quarter' ? 'selected' : '' }}>Quý này</option>
                            <option value="this_year" {{ $period == 'this_year' ? 'selected' : '' }}>Năm này</option>
                            <option value="custom_month" {{ $period == 'custom_month' ? 'selected' : '' }}>Tháng tùy chọn</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="customMonthDiv" style="{{ $period == 'custom_month' ? '' : 'display: none;' }}">
                        <label class="form-label">Tháng</label>
                        <select name="custom_month" class="form-select">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $customMonth == $i ? 'selected' : '' }}>
                                    Tháng {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3" id="customYearDiv" style="{{ $period == 'custom_month' ? '' : 'display: none;' }}">
                        <label class="form-label">Năm</label>
                        <select name="custom_year" class="form-select">
                            @for($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ $customYear == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Xem
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Thống kê tổng quan -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Doanh thu
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($stats['total_revenue']) }} đ
                        </div>
                        @if($stats['revenue_growth'] != 0)
                            <small class="text-{{ $stats['revenue_growth'] > 0 ? 'success' : 'danger' }}">
                                <i class="bi bi-arrow-{{ $stats['revenue_growth'] > 0 ? 'up' : 'down' }}"></i>
                                {{ abs($stats['revenue_growth']) }}% so với kỳ trước
                            </small>
                        @endif
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-currency-dollar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Đơn hàng
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($stats['total_orders']) }}
                        </div>
                        @if($stats['order_growth'] != 0)
                            <small class="text-{{ $stats['order_growth'] > 0 ? 'success' : 'danger' }}">
                                <i class="bi bi-arrow-{{ $stats['order_growth'] > 0 ? 'up' : 'down' }}"></i>
                                {{ abs($stats['order_growth']) }}% so với kỳ trước
                            </small>
                        @endif
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Người dùng mới
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($stats['new_users']) }}
                        </div>
                        <small class="text-muted">
                            Tổng: {{ number_format($stats['total_users']) }}
                        </small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Sản phẩm mới
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($stats['new_products']) }}
                        </div>
                        <small class="text-muted">
                            Tổng: {{ number_format($stats['total_products']) }}
                        </small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thống kê chi tiết -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Biểu đồ doanh thu</h6>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Trạng thái đơn hàng</h6>
            </div>
            <div class="card-body">
                <canvas id="orderStatusChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Thống kê bổ sung -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Chi tiết đơn hàng</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <div class="h4 text-success">{{ $stats['completed_orders'] }}</div>
                            <div class="small text-muted">Hoàn thành</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <div class="h4 text-warning">{{ $stats['pending_orders'] }}</div>
                            <div class="small text-muted">Đang xử lý</div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <div class="h4 text-danger">{{ $stats['cancelled_orders'] }}</div>
                            <div class="small text-muted">Đã hủy</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <div class="h4 text-info">{{ $stats['total_imports'] }}</div>
                            <div class="small text-muted">Phiếu nhập</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thống kê khác</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="text-center">
                            <div class="h4 text-primary">{{ number_format($stats['total_import_value']) }} đ</div>
                            <div class="small text-muted">Giá trị nhập hàng</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <div class="h4 text-info">{{ $stats['new_reviews'] }}</div>
                            <div class="small text-muted">Đánh giá mới</div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <div class="h4 text-warning">
                                {{ $stats['avg_rating'] }}/5 
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <div class="small text-muted">Đánh giá trung bình</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top sản phẩm bán chạy -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Top 5 sản phẩm bán chạy</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng bán</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stats['top_products'] as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->ten }}</td>
                                <td>{{ number_format($product->total_sold) }}</td>
                                <td>{{ number_format($product->total_revenue) }} đ</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Không có dữ liệu</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function toggleCustomMonth() {
    const period = document.getElementById('periodSelect').value;
    const customMonthDiv = document.getElementById('customMonthDiv');
    const customYearDiv = document.getElementById('customYearDiv');
    
    if (period === 'custom_month') {
        customMonthDiv.style.display = 'block';
        customYearDiv.style.display = 'block';
    } else {
        customMonthDiv.style.display = 'none';
        customYearDiv.style.display = 'none';
    }
}

// Biểu đồ doanh thu
const revenueData = @json($chartData['revenue_data']);
const revenueLabels = revenueData.map(item => item.period);
const revenueValues = revenueData.map(item => item.revenue);

const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: revenueLabels,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: revenueValues,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' đ';
                    }
                }
            }
        }
    }
});

// Biểu đồ trạng thái đơn hàng
const orderStatusData = @json($chartData['order_status_data']);
const statusLabels = orderStatusData.map(item => {
    switch(item.trang_thai) {
        case 'cho_xac_nhan': return 'Chờ xác nhận';
        case 'da_xac_nhan': return 'Đã xác nhận';
        case 'dang_giao': return 'Đang giao';
        case 'hoan_thanh': return 'Hoàn thành';
        case 'da_huy': return 'Đã hủy';
        default: return item.trang_thai;
    }
});
const statusValues = orderStatusData.map(item => item.count);
const statusColors = [
    '#ffc107', // warning - pending
    '#17a2b8', // info - confirmed  
    '#007bff', // primary - shipping
    '#28a745', // success - completed
    '#dc3545'  // danger - cancelled
];

const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusValues,
            backgroundColor: statusColors.slice(0, statusValues.length),
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.text-xs {
    font-size: 0.7rem;
}
.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
</style>
@endsection