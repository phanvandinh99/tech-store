@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-speedometer2"></i> Dashboard</h2>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Tổng đơn hàng</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_orders']) }}</h2>
                    </div>
                    <i class="bi bi-cart-check" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Đơn chờ xác nhận</h6>
                        <h2 class="mb-0">{{ number_format($stats['pending_orders']) }}</h2>
                    </div>
                    <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Tổng sản phẩm</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_products']) }}</h2>
                    </div>
                    <i class="bi bi-box" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Khách hàng</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_customers']) }}</h2>
                    </div>
                    <i class="bi bi-people" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card text-white bg-dark">
            <div class="card-body">
                <h5 class="card-title">Doanh thu hôm nay</h5>
                <h2 class="mb-0">{{ number_format($stats['today_revenue']) }} đ</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <h5 class="card-title">Doanh thu tháng này</h5>
                <h2 class="mb-0">{{ number_format($stats['month_revenue']) }} đ</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list-ul"></i> Đơn hàng gần đây</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $donHang)
                            <tr>
                                <td>#{{ $donHang->id }}</td>
                                <td>{{ $donHang->ten_khach }}</td>
                                <td>{{ number_format($donHang->tong_tien) }} đ</td>
                                <td>
                                    <span class="badge bg-{{ $donHang->trang_thai === 'hoan_thanh' ? 'success' : ($donHang->trang_thai === 'da_huy' ? 'danger' : 'warning') }}">
                                        {{ ucfirst(str_replace('_', ' ', $donHang->trang_thai)) }}
                                    </span>
                                </td>
                                <td>{{ $donHang->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.donhang.show', $donHang) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Chưa có đơn hàng nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-trophy"></i> Sản phẩm bán chạy</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($topProducts as $product)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $product->ten }}
                        <span class="badge bg-primary rounded-pill">{{ $product->total_sold }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-center">Chưa có dữ liệu</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

