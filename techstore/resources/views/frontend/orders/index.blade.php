@extends('frontend.layout')

@section('title', 'Đơn hàng của tôi - Tech Store')

@push('styles')
<style>
    .orders-container {
        padding: 2rem 0;
        min-height: 60vh;
    }
    .orders-header {
        margin-bottom: 2rem;
    }
    .status-filter {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }
    .status-btn {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        background: white;
        border-radius: 0.25rem;
        text-decoration: none;
        color: #333;
        transition: all 0.3s;
        font-size: 0.9rem;
    }
    .status-btn:hover,
    .status-btn.active {
        background: #c40316;
        color: white;
        border-color: #c40316;
    }
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .status-cho_xac_nhan {
        background: #fff3cd;
        color: #856404;
    }
    .status-da_xac_nhan {
        background: #d1ecf1;
        color: #0c5460;
    }
    .status-dang_giao {
        background: #d4edda;
        color: #155724;
    }
    .status-hoan_thanh {
        background: #d1ecf1;
        color: #0c5460;
    }
    .status-da_huy {
        background: #f8d7da;
        color: #721c24;
    }
    .order-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: box-shadow 0.3s;
    }
    .order-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .order-info {
        flex: 1;
    }
    .order-info h4 {
        margin: 0 0 0.5rem 0;
        font-size: 1.1rem;
        color: #333;
    }
    .order-meta {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        font-size: 0.9rem;
        color: #666;
    }
    .order-meta span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .order-actions {
        display: flex;
        gap: 0.5rem;
    }
    .order-items {
        margin-top: 1rem;
    }
    .order-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .order-item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.25rem;
        border: 1px solid #e0e0e0;
    }
    .order-item-info {
        flex: 1;
    }
    .order-item-info h5 {
        margin: 0 0 0.5rem 0;
        font-size: 1rem;
        color: #333;
    }
    .order-item-meta {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.5rem;
    }
    .order-item-price {
        font-weight: 600;
        color: #c40316;
    }
    .order-summary {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-total {
        font-size: 1.2rem;
        font-weight: 600;
        color: #c40316;
    }
    .empty-orders {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 0.5rem;
        border: 1px solid #e0e0e0;
    }
    .empty-orders i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
    .empty-orders h3 {
        margin-bottom: 0.5rem;
        color: #333;
    }
    .empty-orders p {
        color: #666;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li>Đơn hàng của tôi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--orders area start-->
<div class="orders-container">
    <div class="container">
        <div class="orders-header">
            <h2><i class="fa fa-shopping-bag"></i> Đơn hàng của tôi</h2>
        </div>

        <!-- Status Filter -->
        <div class="status-filter">
            <a href="{{ route('orders.index') }}" class="status-btn {{ !request('status') ? 'active' : '' }}">
                Tất cả ({{ $statusCounts['all'] }})
            </a>
            <a href="{{ route('orders.index', ['status' => 'cho_xac_nhan']) }}" class="status-btn {{ request('status') == 'cho_xac_nhan' ? 'active' : '' }}">
                Chờ xác nhận ({{ $statusCounts['cho_xac_nhan'] }})
            </a>
            <a href="{{ route('orders.index', ['status' => 'da_xac_nhan']) }}" class="status-btn {{ request('status') == 'da_xac_nhan' ? 'active' : '' }}">
                Đã xác nhận ({{ $statusCounts['da_xac_nhan'] }})
            </a>
            <a href="{{ route('orders.index', ['status' => 'dang_giao']) }}" class="status-btn {{ request('status') == 'dang_giao' ? 'active' : '' }}">
                Đang giao ({{ $statusCounts['dang_giao'] }})
            </a>
            <a href="{{ route('orders.index', ['status' => 'hoan_thanh']) }}" class="status-btn {{ request('status') == 'hoan_thanh' ? 'active' : '' }}">
                Hoàn thành ({{ $statusCounts['hoan_thanh'] }})
            </a>
            <a href="{{ route('orders.index', ['status' => 'da_huy']) }}" class="status-btn {{ request('status') == 'da_huy' ? 'active' : '' }}">
                Đã hủy ({{ $statusCounts['da_huy'] }})
            </a>
        </div>

        @if($orders->count() > 0)
            @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div class="order-info">
                        <h4>
                            <a href="{{ route('orders.show', $order->id) }}" style="color: #333; text-decoration: none;">
                                Đơn hàng #{{ $order->ma_don_hang }}
                            </a>
                        </h4>
                        <div class="order-meta">
                            <span>
                                <i class="fa fa-calendar"></i>
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </span>
                            <span>
                                <i class="fa fa-money"></i>
                                {{ number_format($order->thanh_tien) }} đ
                            </span>
                            <span>
                                <i class="fa fa-box"></i>
                                {{ $order->chiTietDonHangs->sum('so_luong') }} sản phẩm
                            </span>
                        </div>
                    </div>
                    <div class="order-actions">
                        <span class="status-badge status-{{ $order->trang_thai }}">
                            @if($order->trang_thai == 'cho_xac_nhan')
                                Chờ xác nhận
                            @elseif($order->trang_thai == 'da_xac_nhan')
                                Đã xác nhận
                            @elseif($order->trang_thai == 'dang_giao')
                                Đang giao hàng
                            @elseif($order->trang_thai == 'hoan_thanh')
                                Hoàn thành
                            @elseif($order->trang_thai == 'da_huy')
                                Đã hủy
                            @endif
                        </span>
                    </div>
                </div>

                <div class="order-items">
                    @foreach($order->chiTietDonHangs->take(3) as $item)
                    <div class="order-item">
                        @php
                            $primaryImage = $item->bienThe->sanPham->anhSanPhams->where('la_anh_chinh', 1)->first() 
                                ?? $item->bienThe->sanPham->anhSanPhams->first();
                            $imagePath = $primaryImage 
                                ? asset('storage/' . $primaryImage->url) 
                                : asset('assets/img/s-product/product.jpg');
                        @endphp
                        <img src="{{ $imagePath }}" alt="{{ $item->bienThe->sanPham->ten }}" class="order-item-image">
                        <div class="order-item-info">
                            <h5>{{ $item->bienThe->sanPham->ten }}</h5>
                            <div class="order-item-meta">
                                SKU: {{ $item->bienThe->sku }} | 
                                Số lượng: {{ $item->so_luong }}
                            </div>
                            <div class="order-item-price">
                                {{ number_format($item->thanh_tien) }} đ
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if($order->chiTietDonHangs->count() > 3)
                    <div class="text-center mt-2">
                        <small class="text-muted">
                            Và {{ $order->chiTietDonHangs->count() - 3 }} sản phẩm khác...
                        </small>
                    </div>
                    @endif
                </div>

                <div class="order-summary">
                    <div>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-eye"></i> Xem chi tiết
                        </a>
                    </div>
                    <div class="order-total">
                        Tổng tiền: {{ number_format($order->thanh_tien) }} đ
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="pagination-wrapper mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <div class="empty-orders">
                <i class="fa fa-shopping-bag"></i>
                <h3>Chưa có đơn hàng nào</h3>
                <p>Bạn chưa có đơn hàng nào. Hãy bắt đầu mua sắm ngay!</p>
            </div>
        @endif
    </div>
</div>
<!--orders area end-->
@endsection
