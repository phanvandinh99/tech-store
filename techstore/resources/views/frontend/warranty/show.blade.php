@extends('frontend.layout')

@section('title', 'Chi tiết yêu cầu bảo hành #' . $warranty->ma_yeu_cau . ' - Tech Store')

@push('styles')
<style>
    .warranty-detail-container {
        padding: 2rem 0;
        min-height: 60vh;
    }
    .warranty-header-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .warranty-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .warranty-title {
        margin: 0 0 0.5rem 0;
        font-size: 1.5rem;
        color: #333;
    }
    .warranty-meta-info {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        font-size: 0.9rem;
        color: #666;
        margin-top: 1rem;
    }
    .warranty-meta-info span {
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
    .status-cho_tiep_nhan {
        background: #fff3cd;
        color: #856404;
    }
    .status-dang_xu_ly {
        background: #d1ecf1;
        color: #0c5460;
    }
    .status-hoan_tat {
        background: #d4edda;
        color: #155724;
    }
    .status-tu_choi {
        background: #f8d7da;
        color: #721c24;
    }
    .info-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .info-card h4 {
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
    .product-info {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    .product-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 0.25rem;
        border: 1px solid #e0e0e0;
    }
    .warranty-images {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    .warranty-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 0.25rem;
        border: 1px solid #e0e0e0;
        cursor: pointer;
        transition: transform 0.3s;
    }
    .warranty-image:hover {
        transform: scale(1.05);
    }
    @media (max-width: 768px) {
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
                        <li><a href="{{ route('warranty.index') }}">Yêu cầu bảo hành</a></li>
                        <li>Chi tiết yêu cầu</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--warranty detail area start-->
<div class="warranty-detail-container">
    <div class="container">
        <!-- Warranty Header -->
        <div class="warranty-header-card">
            <div class="warranty-header-row">
                <div>
                    <h2 class="warranty-title">Yêu cầu bảo hành #{{ $warranty->ma_yeu_cau }}</h2>
                    <div class="warranty-meta-info">
                        <span>
                            <i class="fa fa-calendar"></i>
                            Ngày tạo: {{ $warranty->created_at->format('d/m/Y H:i') }}
                        </span>
                        @if($warranty->ngay_tiep_nhan)
                        <span>
                            <i class="fa fa-check-circle"></i>
                            Ngày tiếp nhận: {{ $warranty->ngay_tiep_nhan->format('d/m/Y H:i') }}
                        </span>
                        @endif
                        @if($warranty->ngay_hoan_thanh)
                        <span>
                            <i class="fa fa-check-double"></i>
                            Ngày hoàn thành: {{ $warranty->ngay_hoan_thanh->format('d/m/Y H:i') }}
                        </span>
                        @endif
                        @if($warranty->donHang)
                        <span>
                            <i class="fa fa-shopping-cart"></i>
                            Đơn hàng: #{{ $warranty->donHang->ma_don_hang }}
                        </span>
                        @endif
                    </div>
                </div>
                <div>
                    <span class="status-badge status-{{ $warranty->trang_thai }}">
                        @if($warranty->trang_thai == 'cho_tiep_nhan')
                            Chờ tiếp nhận
                        @elseif($warranty->trang_thai == 'dang_xu_ly')
                            Đang xử lý
                        @elseif($warranty->trang_thai == 'hoan_tat')
                            Hoàn tất
                        @else
                            Từ chối
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Product Info & Description -->
            <div class="col-lg-8">
                <!-- Product Info -->
                <div class="info-card">
                    <h4><i class="fa fa-box"></i> Sản phẩm cần bảo hành</h4>
                    <div class="product-info">
                        @php
                            $primaryImage = $warranty->bienThe->sanPham->anhSanPhams->where('la_anh_chinh', 1)->first() 
                                ?? $warranty->bienThe->sanPham->anhSanPhams->first();
                            $imagePath = $primaryImage 
                                ? asset('storage/' . $primaryImage->url) 
                                : asset('assets/img/s-product/product.jpg');
                        @endphp
                        <img src="{{ $imagePath }}" alt="{{ $warranty->bienThe->sanPham->ten }}" class="product-image">
                        <div>
                            <h5>{{ $warranty->bienThe->sanPham->ten }}</h5>
                            <p class="text-muted mb-1">SKU: {{ $warranty->bienThe->sku }}</p>
                            <p class="text-muted mb-0">Danh mục: {{ $warranty->bienThe->sanPham->danhMuc->ten }}</p>
                        </div>
                    </div>
                </div>

                <!-- Error Description -->
                <div class="info-card">
                    <h4><i class="fa fa-exclamation-triangle"></i> Mô tả lỗi</h4>
                    <p style="white-space: pre-wrap;">{{ $warranty->mo_ta_loi }}</p>
                </div>

                <!-- Warranty Images -->
                @if($warranty->anhBaoHanh->count() > 0)
                <div class="info-card">
                    <h4><i class="fa fa-images"></i> Hình ảnh minh chứng</h4>
                    <div class="warranty-images">
                        @foreach($warranty->anhBaoHanh as $anh)
                            <img src="{{ asset('storage/' . $anh->duong_dan) }}" 
                                 alt="Hình ảnh bảo hành" 
                                 class="warranty-image"
                                 onclick="window.open('{{ asset('storage/' . $anh->duong_dan) }}', '_blank')">
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column: Warranty Info -->
            <div class="col-lg-4">
                <!-- Warranty Details -->
                <div class="info-card">
                    <h4><i class="fa fa-info-circle"></i> Thông tin bảo hành</h4>
                    <div class="info-row">
                        <div class="info-label">Hình thức:</div>
                        <div class="info-value">
                            @if($warranty->hinh_thuc_bao_hanh == 'sua_chua')
                                Sửa chữa
                            @elseif($warranty->hinh_thuc_bao_hanh == 'thay_the')
                                Thay thế
                            @else
                                Đổi mới
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Trạng thái:</div>
                        <div class="info-value">
                            <span class="status-badge status-{{ $warranty->trang_thai }}">
                                @if($warranty->trang_thai == 'cho_tiep_nhan')
                                    Chờ tiếp nhận
                                @elseif($warranty->trang_thai == 'dang_xu_ly')
                                    Đang xử lý
                                @elseif($warranty->trang_thai == 'hoan_tat')
                                    Hoàn tất
                                @else
                                    Từ chối
                                @endif
                            </span>
                        </div>
                    </div>
                    @if($warranty->phieu_bao_hanh_chinh_hang)
                    <div class="info-row">
                        <div class="info-label">Phiếu BH:</div>
                        <div class="info-value">{{ $warranty->phieu_bao_hanh_chinh_hang }}</div>
                    </div>
                    @endif
                </div>

                <!-- Order Info -->
                @if($warranty->donHang)
                <div class="info-card">
                    <h4><i class="fa fa-shopping-cart"></i> Thông tin đơn hàng</h4>
                    <div class="info-row">
                        <div class="info-label">Mã đơn hàng:</div>
                        <div class="info-value">
                            <a href="{{ route('orders.show', $warranty->donHang->id) }}" style="color: #c40316;">
                                #{{ $warranty->donHang->ma_don_hang }}
                            </a>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Ngày đặt:</div>
                        <div class="info-value">{{ $warranty->donHang->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="info-card">
                    <a href="{{ route('warranty.index') }}" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="fa fa-arrow-left"></i> Quay lại danh sách
                    </a>
                    @if($warranty->trang_thai == 'cho_tiep_nhan')
                    <a href="{{ route('warranty.create') }}" class="btn btn-primary w-100">
                        <i class="fa fa-plus"></i> Tạo yêu cầu mới
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!--warranty detail area end-->
@endsection
