@extends('admin.layout')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .stat-card.primary::before { background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%); }
    .stat-card.warning::before { background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); }
    .stat-card.success::before { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); }
    .stat-card.info::before { background: linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%); }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-bottom: 1rem;
    }

    .stat-icon.primary { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #2563eb; }
    .stat-icon.warning { background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); color: #f59e0b; }
    .stat-icon.success { background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); color: #10b981; }
    .stat-icon.info { background: linear-gradient(135deg, #ecfeff 0%, #cffafe 100%); color: #06b6d4; }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0.5rem 0;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .revenue-card {
        background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
        color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        border: none;
    }

    .revenue-card h6 {
        color: rgba(255,255,255,0.9);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .revenue-card h2 {
        color: white;
        font-weight: 700;
    }

    /* Tablet responsive (768px - 1024px) */
    @media (max-width: 1024px) {
        .stat-card {
            padding: 1.25rem;
        }
        .stat-value {
            font-size: 1.75rem;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }
    }

    /* Mobile responsive (max 768px) */
    @media (max-width: 768px) {
        .stat-card {
            padding: 1rem;
        }
        .stat-value {
            font-size: 1.5rem;
        }
        .stat-icon {
            width: 45px;
            height: 45px;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }
        .stat-label {
            font-size: 0.8rem;
        }
        .revenue-card {
            padding: 1.25rem;
        }
        .revenue-card h2 {
            font-size: 1.5rem;
        }
        .revenue-card h6 {
            font-size: 0.8rem;
        }
    }

    /* Small mobile (max 576px) */
    @media (max-width: 576px) {
        .stat-card {
            padding: 0.875rem;
        }
        .stat-value {
            font-size: 1.25rem;
        }
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            font-size: 0.75rem;
        }
        .revenue-card {
            padding: 1rem;
        }
        .revenue-card h2 {
            font-size: 1.25rem;
        }
        .revenue-card h6 {
            font-size: 0.75rem;
        }
        .table th,
        .table td {
            font-size: 0.8rem;
            padding: 0.5rem 0.25rem;
        }
        .table th:first-child,
        .table td:first-child {
            padding-left: 0.5rem;
        }
        .table th:last-child,
        .table td:last-child {
            padding-right: 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon primary">
                <i class="bi bi-cart-check"></i>
            </div>
            <div class="stat-label">Tổng đơn hàng</div>
            <div class="stat-value">{{ number_format($stats['total_orders']) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon warning">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-label">Đơn chờ xác nhận</div>
            <div class="stat-value">{{ number_format($stats['pending_orders']) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon success">
                <i class="bi bi-box"></i>
            </div>
            <div class="stat-label">Tổng sản phẩm</div>
            <div class="stat-value">{{ number_format($stats['total_products']) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card info">
            <div class="stat-icon info">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-label">Khách hàng</div>
            <div class="stat-value">{{ number_format($stats['total_customers']) }}</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="revenue-card">
            <h6><i class="bi bi-calendar-day"></i> Doanh thu hôm nay</h6>
            <h2>{{ number_format($stats['today_revenue']) }} đ</h2>
        </div>
    </div>
    <div class="col-md-6">
        <div class="revenue-card" style="background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);">
            <h6><i class="bi bi-calendar-month"></i> Doanh thu tháng này</h6>
            <h2>{{ number_format($stats['month_revenue']) }} đ</h2>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list-ul"></i> Đơn hàng gần đây</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
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
                                <td><strong>#{{ $donHang->id }}</strong></td>
                                <td>{{ $donHang->ten_khach }}</td>
                                <td><strong>{{ number_format($donHang->tong_tien) }} đ</strong></td>
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
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                    <p class="mt-2 mb-0">Chưa có đơn hàng nào</p>
                                </td>
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
                    @forelse($topProducts as $index => $product)
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary rounded-circle me-2" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                {{ $index + 1 }}
                            </span>
                            <span>{{ $product->ten }}</span>
                        </div>
                        <span class="badge bg-success rounded-pill">{{ $product->total_sold }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted border-0">
                        <i class="bi bi-inbox" style="font-size: 1.5rem;"></i>
                        <p class="mt-2 mb-0">Chưa có dữ liệu</p>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
