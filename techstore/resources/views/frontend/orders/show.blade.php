@extends('frontend.layout')

@section('title', 'Chi tiết đơn hàng #' . $order->ma_don_hang . ' - Tech Store')

@push('styles')
<style>
    .order-detail-container {
        padding: 2rem 0;
        min-height: 60vh;
    }
    .order-header-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .order-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .order-title {
        margin: 0 0 0.5rem 0;
        font-size: 1.5rem;
        color: #333;
    }
    .order-meta-info {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        font-size: 0.9rem;
        color: #666;
        margin-top: 1rem;
    }
    .order-meta-info span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-size: 0.9rem;
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
    .order-info-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .order-info-card h4 {
        margin: 0 0 1rem 0;
        font-size: 1.1rem;
        color: #333;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e0e0e0;
    }
    .info-row {
        display: flex;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: #666;
        width: 150px;
        flex-shrink: 0;
    }
    .info-value {
        color: #333;
        flex: 1;
    }
    .order-items-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .order-items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .order-items-table thead {
        background: #f8f9fa;
    }
    .order-items-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e0e0e0;
    }
    .order-items-table td {
        padding: 1rem;
        border-bottom: 1px solid #f5f5f5;
        vertical-align: middle;
    }
    .order-items-table tbody tr:last-child td {
        border-bottom: none;
    }
    .item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.25rem;
        border: 1px solid #e0e0e0;
    }
    .item-name {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.25rem;
    }
    .item-sku {
        font-size: 0.85rem;
        color: #666;
    }
    .item-price {
        font-weight: 600;
        color: #c40316;
    }
    .order-summary-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 1.5rem;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .summary-row:last-child {
        border-bottom: none;
        border-top: 2px solid #e0e0e0;
        margin-top: 0.5rem;
        padding-top: 1rem;
    }
    .summary-label {
        color: #666;
    }
    .summary-value {
        font-weight: 600;
        color: #333;
    }
    .summary-total {
        font-size: 1.25rem;
        color: #c40316;
    }
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    @media (max-width: 768px) {
        .order-items-table {
            font-size: 0.875rem;
        }
        .item-image {
            width: 60px;
            height: 60px;
        }
        .info-row {
            flex-direction: column;
            gap: 0.25rem;
        }
        .info-label {
            width: 100%;
        }
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
                        <li><a href="{{ route('orders.index') }}">Đơn hàng của tôi</a></li>
                        <li>Chi tiết đơn hàng</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--order detail area start-->
<div class="order-detail-container">
    <div class="container">
        <!-- Order Header -->
        <div class="order-header-card">
            <div class="order-header-row">
                <div>
                    <h2 class="order-title">Đơn hàng #{{ $order->ma_don_hang }}</h2>
                    <div class="order-meta-info">
                        <span>
                            <i class="fa fa-calendar"></i>
                            Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}
                        </span>
                        <span>
                            <i class="fa fa-box"></i>
                            {{ $order->chiTietDonHangs->sum('so_luong') }} sản phẩm
                        </span>
                        <span>
                            <i class="fa fa-money"></i>
                            {{ number_format($order->thanh_tien) }} đ
                        </span>
                    </div>
                </div>
                <div>
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
        </div>

        <div class="row">
            <!-- Left Column: Order Items -->
            <div class="col-lg-8">
                <!-- Order Items -->
                <div class="order-items-card">
                    <h4><i class="fa fa-shopping-bag"></i> Sản phẩm đã đặt</h4>
                    <div class="table-responsive">
                        <table class="order-items-table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>SKU</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->chiTietDonHangs as $item)
                                <tr>
                                    <td>
                                        <div style="display: flex; gap: 1rem; align-items: center;">
                                            @php
                                                $primaryImage = $item->bienThe->sanPham->anhSanPhams->where('la_anh_chinh', 1)->first() 
                                                    ?? $item->bienThe->sanPham->anhSanPhams->first();
                                                $imagePath = $primaryImage 
                                                    ? asset('storage/' . $primaryImage->url) 
                                                    : asset('assets/img/s-product/product.jpg');
                                            @endphp
                                            <img src="{{ $imagePath }}" alt="{{ $item->bienThe->sanPham->ten }}" class="item-image">
                                            <div>
                                                <div class="item-name">
                                                    <a href="{{ route('products.show', $item->sanPham->id) }}" style="color: #333; text-decoration: none;">
                                                        {{ $item->bienThe->sanPham->ten }}
                                                    </a>
                                                </div>
                                                <div class="item-sku">SKU: {{ $item->bienThe->sku }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->bienThe->sku }}</td>
                                    <td class="item-price">{{ number_format($item->gia_luc_mua) }} đ</td>
                                    <td>{{ $item->so_luong }}</td>
                                    <td class="item-price">{{ number_format($item->thanh_tien) }} đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Info & Summary -->
            <div class="col-lg-4">
                <!-- Customer Info -->
                <div class="order-info-card">
                    <h4><i class="fa fa-user"></i> Thông tin khách hàng</h4>
                    <div class="info-row">
                        <div class="info-label">Họ tên:</div>
                        <div class="info-value">{{ $order->ten_khach }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Số điện thoại:</div>
                        <div class="info-value">{{ $order->sdt_khach }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email:</div>
                        <div class="info-value">{{ $order->email_khach }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Địa chỉ:</div>
                        <div class="info-value">{{ $order->dia_chi_khach }}</div>
                    </div>
                </div>

                <!-- Delivery Info -->
                <div class="order-info-card">
                    <h4><i class="fa fa-truck"></i> Thông tin giao hàng</h4>
                    <div class="info-row">
                        <div class="info-label">Phương thức:</div>
                        <div class="info-value">
                            {{ $order->phuong_thuc_thanh_toan == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Thanh toán online' }}
                        </div>
                    </div>
                    @if($order->ghi_chu)
                    <div class="info-row">
                        <div class="info-label">Ghi chú:</div>
                        <div class="info-value">{{ $order->ghi_chu }}</div>
                    </div>
                    @endif
                </div>

                <!-- Order Summary -->
                <div class="order-summary-card">
                    <h4><i class="fa fa-calculator"></i> Tóm tắt đơn hàng</h4>
                    <div class="summary-row">
                        <span class="summary-label">Tạm tính:</span>
                        <span class="summary-value">{{ number_format($order->tong_tien) }} đ</span>
                    </div>
                    @if($order->giam_gia > 0)
                    <div class="summary-row">
                        <span class="summary-label">Giảm giá:</span>
                        <span class="summary-value" style="color: #28a745;">-{{ number_format($order->giam_gia) }} đ</span>
                    </div>
                    @endif
                    <div class="summary-row">
                        <span class="summary-label">Phí vận chuyển:</span>
                        <span class="summary-value">Miễn phí</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label summary-total">Tổng cộng:</span>
                        <span class="summary-value summary-total">{{ number_format($order->thanh_tien) }} đ</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fa fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--order detail area end-->
@endsection
