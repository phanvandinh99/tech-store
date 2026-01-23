@extends('frontend.layout')

@section('title', 'Đánh giá của tôi')

@section('content')
<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-star"></i> Đánh giá của tôi</h4>
                </div>
                <div class="card-body">
                    @if($danhGias->count() > 0)
                        <div class="row">
                            @foreach($danhGias as $danhGia)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <!-- Thông tin sản phẩm -->
                                            <div class="d-flex mb-3">
                                                @if($danhGia->sanPham->anhSanPhams->first())
                                                    <img src="{{ asset('storage/' . $danhGia->sanPham->anhSanPhams->first()->duong_dan) }}" 
                                                         class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="Product">
                                                @else
                                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded me-3" 
                                                         style="width: 60px; height: 60px;">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $danhGia->sanPham->ten }}</h6>
                                                    <small class="text-muted">Đơn hàng: {{ $danhGia->donHang->ma_don_hang }}</small>
                                                </div>
                                            </div>

                                            <!-- Đánh giá sao -->
                                            <div class="mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $danhGia->so_sao)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                                <span class="ms-2 text-muted">{{ $danhGia->so_sao }}/5</span>
                                            </div>

                                            <!-- Nội dung đánh giá -->
                                            <p class="text-muted mb-3">{{ Str::limit($danhGia->noi_dung, 100) }}</p>

                                            <!-- Ảnh đánh giá -->
                                            @if($danhGia->anhDanhGia->count() > 0)
                                                <div class="mb-3">
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($danhGia->anhDanhGia->take(3) as $anh)
                                                            <img src="{{ asset('storage/' . $anh->duong_dan) }}" 
                                                                 class="rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="Review">
                                                        @endforeach
                                                        @if($danhGia->anhDanhGia->count() > 3)
                                                            <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                                                 style="width: 50px; height: 50px;">
                                                                <small>+{{ $danhGia->anhDanhGia->count() - 3 }}</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Trạng thái -->
                                            <div class="mb-3">
                                                @if($danhGia->trang_thai == 'pending')
                                                    <span class="badge bg-warning">Chờ duyệt</span>
                                                @elseif($danhGia->trang_thai == 'approved')
                                                    <span class="badge bg-success">Đã duyệt</span>
                                                @elseif($danhGia->trang_thai == 'hidden')
                                                    <span class="badge bg-secondary">Đã ẩn</span>
                                                @else
                                                    <span class="badge bg-danger">Bị từ chối</span>
                                                @endif
                                            </div>

                                            <!-- Ngày tạo -->
                                            <small class="text-muted">{{ $danhGia->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('reviews.show', $danhGia->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Xem chi tiết
                                                </a>
                                                @if($danhGia->trang_thai == 'pending')
                                                    <a href="{{ route('reviews.edit', $danhGia->id) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit"></i> Sửa
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $danhGias->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                            <h5>Chưa có đánh giá nào</h5>
                            <p class="text-muted">Bạn chưa đánh giá sản phẩm nào. Hãy mua sắm và chia sẻ trải nghiệm của bạn!</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i> Mua sắm ngay
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection