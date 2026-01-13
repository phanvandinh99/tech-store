@extends('frontend.layout')

@section('title', 'Yêu cầu bảo hành - Tech Store')

@push('styles')
<style>
    .warranty-container {
        padding: 2rem 0;
        min-height: 60vh;
    }
    .warranty-header {
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
    .warranty-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: box-shadow 0.3s;
    }
    .warranty-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .warranty-header-info {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .warranty-info h4 {
        margin: 0 0 0.5rem 0;
        font-size: 1.1rem;
        color: #333;
    }
    .warranty-meta {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        font-size: 0.9rem;
        color: #666;
    }
    .warranty-meta span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .product-info {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.25rem;
        border: 1px solid #e0e0e0;
    }
    .product-details h5 {
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
        color: #333;
    }
    .product-details small {
        color: #666;
    }
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #666;
    }
    .empty-state i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 1rem;
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
                        <li>Yêu cầu bảo hành</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--warranty area start-->
<div class="warranty-container">
    <div class="container">
        <div class="warranty-header">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Yêu cầu bảo hành</h2>
                <a href="{{ route('warranty.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tạo yêu cầu mới
                </a>
            </div>

            <!-- Status Filter -->
            <div class="status-filter">
                <a href="{{ route('warranty.index') }}" 
                   class="status-btn {{ !request('status') ? 'active' : '' }}">
                    Tất cả ({{ $statusCounts['all'] }})
                </a>
                <a href="{{ route('warranty.index', ['status' => 'cho_tiep_nhan']) }}" 
                   class="status-btn {{ request('status') == 'cho_tiep_nhan' ? 'active' : '' }}">
                    Chờ tiếp nhận ({{ $statusCounts['cho_tiep_nhan'] }})
                </a>
                <a href="{{ route('warranty.index', ['status' => 'dang_xu_ly']) }}" 
                   class="status-btn {{ request('status') == 'dang_xu_ly' ? 'active' : '' }}">
                    Đang xử lý ({{ $statusCounts['dang_xu_ly'] }})
                </a>
                <a href="{{ route('warranty.index', ['status' => 'hoan_tat']) }}" 
                   class="status-btn {{ request('status') == 'hoan_tat' ? 'active' : '' }}">
                    Hoàn tất ({{ $statusCounts['hoan_tat'] }})
                </a>
                <a href="{{ route('warranty.index', ['status' => 'tu_choi']) }}" 
                   class="status-btn {{ request('status') == 'tu_choi' ? 'active' : '' }}">
                    Từ chối ({{ $statusCounts['tu_choi'] }})
                </a>
            </div>
        </div>

        @if($warranties->count() > 0)
            @foreach($warranties as $warranty)
            <div class="warranty-card">
                <div class="warranty-header-info">
                    <div class="warranty-info">
                        <h4>Mã yêu cầu: {{ $warranty->ma_yeu_cau }}</h4>
                        <div class="warranty-meta">
                            <span>
                                <i class="fa fa-calendar"></i>
                                Ngày tạo: {{ $warranty->created_at->format('d/m/Y H:i') }}
                            </span>
                            @if($warranty->donHang)
                            <span>
                                <i class="fa fa-shopping-cart"></i>
                                Đơn hàng: #{{ $warranty->donHang->ma_don_hang }}
                            </span>
                            @endif
                            <span>
                                <i class="fa fa-wrench"></i>
                                Hình thức: 
                                @if($warranty->hinh_thuc_bao_hanh == 'sua_chua')
                                    Sửa chữa
                                @elseif($warranty->hinh_thuc_bao_hanh == 'thay_the')
                                    Thay thế
                                @else
                                    Đổi mới
                                @endif
                            </span>
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

                <div class="product-info">
                    @php
                        $primaryImage = $warranty->bienThe->sanPham->anhSanPhams->where('la_anh_chinh', 1)->first() 
                            ?? $warranty->bienThe->sanPham->anhSanPhams->first();
                        $imagePath = $primaryImage 
                            ? asset('storage/' . $primaryImage->url) 
                            : asset('assets/img/s-product/product.jpg');
                    @endphp
                    <img src="{{ $imagePath }}" alt="{{ $warranty->bienThe->sanPham->ten }}" class="product-image">
                    <div class="product-details">
                        <h5>{{ $warranty->bienThe->sanPham->ten }}</h5>
                        <small>SKU: {{ $warranty->bienThe->sku }}</small>
                    </div>
                </div>

                <div class="mt-3">
                    <p class="mb-2"><strong>Mô tả lỗi:</strong></p>
                    <p class="text-muted">{{ \Illuminate\Support\Str::limit($warranty->mo_ta_loi, 150) }}</p>
                </div>

                <div class="mt-3">
                    <a href="{{ route('warranty.show', $warranty->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fa fa-eye"></i> Xem chi tiết
                    </a>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-4">
                {{ $warranties->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fa fa-inbox"></i>
                <h3>Chưa có yêu cầu bảo hành nào</h3>
                <p>Bạn chưa có yêu cầu bảo hành nào. Hãy tạo yêu cầu mới nếu sản phẩm của bạn cần bảo hành.</p>
                <a href="{{ route('warranty.create') }}" class="btn btn-primary mt-3">
                    <i class="fa fa-plus"></i> Tạo yêu cầu bảo hành
                </a>
            </div>
        @endif
    </div>
</div>
<!--warranty area end-->
@endsection
