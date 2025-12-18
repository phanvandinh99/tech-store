@extends('admin.layout')

@section('title', 'Chi tiết đánh giá')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-star-half"></i> Chi tiết đánh giá #{{ $danhGia->id }}
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Sản phẩm:</strong>
                        <p>{{ $danhGia->sanPham->ten ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Khách hàng:</strong>
                        <p>{{ $danhGia->nguoiDung->name ?? 'N/A' }} ({{ $danhGia->nguoiDung->email ?? '' }})</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Đánh giá:</strong>
                        <p>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $danhGia->so_sao ? '-fill text-warning' : '' }}" style="font-size: 1.2rem;"></i>
                            @endfor
                            <span class="ms-2">({{ $danhGia->so_sao }}/5 sao)</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Ngày đánh giá:</strong>
                        <p>{{ $danhGia->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if($danhGia->donHang)
                <div class="mb-3">
                    <strong>Đơn hàng liên quan:</strong>
                    <p>
                        <a href="{{ route('admin.donhang.show', $danhGia->donHang->id) }}">
                            #{{ $danhGia->donHang->ma_don_hang }}
                        </a>
                    </p>
                </div>
                @endif

                <div class="mb-3">
                    <strong>Nội dung đánh giá:</strong>
                    <div class="bg-light p-3 rounded mt-2">
                        {{ $danhGia->noi_dung ?: 'Không có nội dung' }}
                    </div>
                </div>

                @if($danhGia->anhDanhGia->count() > 0)
                <div class="mb-3">
                    <strong>Hình ảnh đính kèm:</strong>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach($danhGia->anhDanhGia as $anh)
                            <a href="{{ asset('storage/' . $anh->duong_dan) }}" target="_blank">
                                <img src="{{ asset('storage/' . $anh->duong_dan) }}" class="img-thumbnail" style="max-width: 150px;">
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Bình luận -->
                @if($danhGia->binhLuans->count() > 0)
                <div class="mb-3">
                    <strong>Bình luận ({{ $danhGia->binhLuans->count() }}):</strong>
                    <div class="mt-2">
                        @foreach($danhGia->binhLuans as $bl)
                        <div class="border-start border-3 ps-3 mb-2 {{ $bl->trang_thai != 'approved' ? 'opacity-50' : '' }}">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $bl->nguoiDung->name ?? 'N/A' }}</strong>
                                <small class="text-muted">{{ $bl->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <p class="mb-1">{{ $bl->noi_dung }}</p>
                            <span class="badge bg-{{ $bl->trang_thai == 'approved' ? 'success' : ($bl->trang_thai == 'pending' ? 'warning' : 'secondary') }}">
                                {{ $bl->trang_thai }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-gear"></i> Cập nhật trạng thái
            </div>
            <div class="card-body">
                <form action="{{ route('admin.danhgia.status', $danhGia->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label">Trạng thái hiện tại:</label>
                        <p>
                            @switch($danhGia->trang_thai)
                                @case('pending')
                                    <span class="badge bg-warning">Chờ duyệt</span>
                                    @break
                                @case('approved')
                                    <span class="badge bg-success">Đã duyệt</span>
                                    @break
                                @case('hidden')
                                    <span class="badge bg-secondary">Đã ẩn</span>
                                    @break
                                @case('rejected')
                                    <span class="badge bg-danger">Từ chối</span>
                                    @break
                            @endswitch
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Chuyển sang:</label>
                        <select class="form-select" name="trang_thai" required>
                            <option value="pending" {{ $danhGia->trang_thai == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            <option value="approved" {{ $danhGia->trang_thai == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                            <option value="hidden" {{ $danhGia->trang_thai == 'hidden' ? 'selected' : '' }}>Ẩn</option>
                            <option value="rejected" {{ $danhGia->trang_thai == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i> Cập nhật
                    </button>
                </form>

                <hr>

                <form action="{{ route('admin.danhgia.destroy', $danhGia->id) }}" method="POST"
                    onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash"></i> Xóa đánh giá
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.danhgia.index') }}" class="btn btn-secondary w-100">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>
@endsection

