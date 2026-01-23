@extends('frontend.layout')

@section('title', 'Chi tiết đánh giá')

@section('content')
<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-star"></i> Chi tiết đánh giá</h4>
                </div>
                <div class="card-body">
                    <!-- Thông tin sản phẩm -->
                    <div class="product-info mb-4 p-3 bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                @if($danhGia->sanPham->anhSanPhams->first())
                                    <img src="{{ asset('storage/' . $danhGia->sanPham->anhSanPhams->first()->duong_dan) }}" 
                                         class="img-fluid rounded" alt="Product">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" 
                                         style="height: 100px;">
                                        <i class="fas fa-image fa-2x"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h5>{{ $danhGia->sanPham->ten }}</h5>
                                <p class="text-muted mb-1">
                                    <strong>Đơn hàng:</strong> {{ $danhGia->donHang->ma_don_hang }}
                                </p>
                                <p class="text-muted mb-1">
                                    <strong>Ngày mua:</strong> {{ $danhGia->donHang->created_at->format('d/m/Y') }}
                                </p>
                                <p class="text-muted mb-0">
                                    <strong>Trạng thái đánh giá:</strong>
                                    @if($danhGia->trang_thai == 'pending')
                                        <span class="badge bg-warning">Chờ duyệt</span>
                                    @elseif($danhGia->trang_thai == 'approved')
                                        <span class="badge bg-success">Đã duyệt</span>
                                    @elseif($danhGia->trang_thai == 'hidden')
                                        <span class="badge bg-secondary">Đã ẩn</span>
                                    @else
                                        <span class="badge bg-danger">Bị từ chối</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Đánh giá -->
                    <div class="review-content">
                        <!-- Đánh giá sao -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Đánh giá:</label>
                            <div class="d-flex align-items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $danhGia->so_sao)
                                        <i class="fas fa-star text-warning me-1"></i>
                                    @else
                                        <i class="far fa-star text-muted me-1"></i>
                                    @endif
                                @endfor
                                <span class="ms-2">{{ $danhGia->so_sao }}/5 sao</span>
                            </div>
                        </div>

                        <!-- Nội dung đánh giá -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nhận xét:</label>
                            <div class="p-3 bg-light rounded">
                                {{ $danhGia->noi_dung }}
                            </div>
                        </div>

                        <!-- Ảnh đánh giá -->
                        @if($danhGia->anhDanhGia->count() > 0)
                            <div class="mb-4">
                                <label class="form-label fw-bold">Hình ảnh:</label>
                                <div class="row">
                                    @foreach($danhGia->anhDanhGia as $anh)
                                        <div class="col-md-3 mb-3">
                                            <img src="{{ asset('storage/' . $anh->duong_dan) }}" 
                                                 class="img-fluid rounded cursor-pointer" 
                                                 alt="Review Image"
                                                 onclick="showImageModal('{{ asset('storage/' . $anh->duong_dan) }}')">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Thông tin thời gian -->
                        <div class="mb-4">
                            <small class="text-muted">
                                <strong>Ngày đánh giá:</strong> {{ $danhGia->created_at->format('d/m/Y H:i') }}
                                @if($danhGia->updated_at != $danhGia->created_at)
                                    <br><strong>Cập nhật lần cuối:</strong> {{ $danhGia->updated_at->format('d/m/Y H:i') }}
                                @endif
                            </small>
                        </div>
                    </div>

                    <!-- Bình luận từ admin (nếu có) -->
                    @if($danhGia->binhLuans->count() > 0)
                        <div class="admin-comments mt-4">
                            <h6><i class="fas fa-comments"></i> Phản hồi từ cửa hàng:</h6>
                            @foreach($danhGia->binhLuans as $binhLuan)
                                <div class="card mb-2">
                                    <div class="card-body py-2">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>{{ $binhLuan->nguoiDung->ho_ten ?? 'Quản trị viên' }}</strong>
                                                <p class="mb-1">{{ $binhLuan->noi_dung }}</p>
                                            </div>
                                            <small class="text-muted">{{ $binhLuan->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('reviews.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách
                        </a>
                        @if($danhGia->trang_thai == 'pending')
                            <a href="{{ route('reviews.edit', $danhGia->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hình ảnh đánh giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Review Image">
            </div>
        </div>
    </div>
</div>

<style>
.cursor-pointer {
    cursor: pointer;
}
</style>

<script>
function showImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
@endsection