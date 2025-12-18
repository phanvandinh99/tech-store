@extends('admin.layout')

@section('title', 'Chi tiết yêu cầu bảo hành')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-shield-check"></i> Yêu cầu bảo hành: {{ $yeuCau->ma_yeu_cau }}
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Khách hàng:</strong>
                        <p>{{ $yeuCau->nguoiDung->name ?? 'N/A' }}<br>
                        <small class="text-muted">{{ $yeuCau->nguoiDung->email ?? '' }} | {{ $yeuCau->nguoiDung->sdt ?? '' }}</small></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Sản phẩm:</strong>
                        <p>{{ $yeuCau->bienThe->sanPham->ten ?? 'N/A' }}<br>
                        <small class="text-muted">SKU: {{ $yeuCau->bienThe->sku ?? '' }}</small></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Hình thức bảo hành:</strong>
                        <p>
                            @switch($yeuCau->hinh_thuc_bao_hanh)
                                @case('sua_chua')
                                    <span class="badge bg-info">Sửa chữa</span>
                                    @break
                                @case('thay_the')
                                    <span class="badge bg-warning">Thay thế linh kiện</span>
                                    @break
                                @case('doi_moi')
                                    <span class="badge bg-primary">Đổi mới sản phẩm</span>
                                    @break
                            @endswitch
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Ngày tạo yêu cầu:</strong>
                        <p>{{ $yeuCau->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if($yeuCau->donHang)
                <div class="mb-3">
                    <strong>Đơn hàng liên quan:</strong>
                    <p>
                        <a href="{{ route('admin.donhang.show', $yeuCau->donHang->id) }}">
                            #{{ $yeuCau->donHang->ma_don_hang }}
                        </a>
                        ({{ $yeuCau->donHang->created_at->format('d/m/Y') }})
                    </p>
                </div>
                @endif

                <div class="mb-3">
                    <strong>Mô tả lỗi:</strong>
                    <div class="bg-light p-3 rounded mt-2">
                        {{ $yeuCau->mo_ta_loi }}
                    </div>
                </div>

                @if($yeuCau->anhBaoHanh->count() > 0)
                <div class="mb-3">
                    <strong>Hình ảnh đính kèm:</strong>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach($yeuCau->anhBaoHanh as $anh)
                            <a href="{{ asset('storage/' . $anh->duong_dan) }}" target="_blank">
                                <img src="{{ asset('storage/' . $anh->duong_dan) }}" class="img-thumbnail" style="max-width: 150px;">
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($yeuCau->ngay_tiep_nhan)
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Ngày tiếp nhận:</strong>
                        <p>{{ $yeuCau->ngay_tiep_nhan->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($yeuCau->ngay_hoan_thanh)
                    <div class="col-md-6">
                        <strong>Ngày hoàn thành:</strong>
                        <p>{{ $yeuCau->ngay_hoan_thanh->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
                @endif

                @if($yeuCau->phieu_bao_hanh_chinh_hang)
                <div class="mb-3">
                    <strong>Phiếu bảo hành chính hãng:</strong>
                    <p><code>{{ $yeuCau->phieu_bao_hanh_chinh_hang }}</code></p>
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
                <form action="{{ route('admin.baohanh.status', $yeuCau->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label">Trạng thái hiện tại:</label>
                        <p>
                            @switch($yeuCau->trang_thai)
                                @case('cho_tiep_nhan')
                                    <span class="badge bg-warning">Chờ tiếp nhận</span>
                                    @break
                                @case('dang_xu_ly')
                                    <span class="badge bg-info">Đang xử lý</span>
                                    @break
                                @case('hoan_tat')
                                    <span class="badge bg-success">Hoàn tất</span>
                                    @break
                                @case('tu_choi')
                                    <span class="badge bg-danger">Từ chối</span>
                                    @break
                            @endswitch
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Chuyển sang:</label>
                        <select class="form-select" name="trang_thai" required>
                            <option value="cho_tiep_nhan" {{ $yeuCau->trang_thai == 'cho_tiep_nhan' ? 'selected' : '' }}>Chờ tiếp nhận</option>
                            <option value="dang_xu_ly" {{ $yeuCau->trang_thai == 'dang_xu_ly' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="hoan_tat" {{ $yeuCau->trang_thai == 'hoan_tat' ? 'selected' : '' }}>Hoàn tất</option>
                            <option value="tu_choi" {{ $yeuCau->trang_thai == 'tu_choi' ? 'selected' : '' }}>Từ chối</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ghi chú nội bộ:</label>
                        <textarea class="form-control" name="ghi_chu_noi_bo" rows="3">{{ $yeuCau->ghi_chu_noi_bo }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số phiếu bảo hành chính hãng:</label>
                        <input type="text" class="form-control" name="phieu_bao_hanh_chinh_hang" 
                            value="{{ $yeuCau->phieu_bao_hanh_chinh_hang }}" placeholder="VD: BH-2024-001">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i> Cập nhật
                    </button>
                </form>

                <hr>

                <form action="{{ route('admin.baohanh.destroy', $yeuCau->id) }}" method="POST"
                    onsubmit="return confirm('Bạn có chắc muốn xóa yêu cầu này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash"></i> Xóa yêu cầu
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.baohanh.index') }}" class="btn btn-secondary w-100">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>
@endsection

