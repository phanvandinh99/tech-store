@extends('admin.layout')

@section('title', 'Chi tiết Phiếu nhập #' . $phieuNhap->id)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-file-text"></i> Phiếu nhập #{{ $phieuNhap->id }}</h4>
                <div>
                    <a href="{{ route('admin.phieunhap.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <button class="btn btn-danger btn-sm" onclick="deletePhieuNhap({{ $phieuNhap->id }})">
                        <i class="bi bi-trash"></i> Xóa
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Mã phiếu:</th>
                                <td><strong>#{{ $phieuNhap->id }}</strong></td>
                            </tr>
                            <tr>
                                <th>Nhà cung cấp:</th>
                                <td>
                                    @if($phieuNhap->nhaCungCap)
                                        <strong>{{ $phieuNhap->nhaCungCap->ten }}</strong>
                                        @if($phieuNhap->nhaCungCap->sdt)
                                            <br><small class="text-muted">{{ $phieuNhap->nhaCungCap->sdt }}</small>
                                        @endif
                                        @if($phieuNhap->nhaCungCap->email)
                                            <br><small class="text-muted">{{ $phieuNhap->nhaCungCap->email }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">Không có</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày nhập:</th>
                                <td>{{ $phieuNhap->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Tổng số lượng:</th>
                                <td><strong>{{ $phieuNhap->chiTietPhieuNhaps->sum('so_luong_nhap') }}</strong> sản phẩm</td>
                            </tr>
                            <tr>
                                <th>Số loại sản phẩm:</th>
                                <td>{{ $phieuNhap->chiTietPhieuNhaps->count() }} loại</td>
                            </tr>
                            <tr>
                                <th>Tổng tiền:</th>
                                <td><strong class="text-primary" style="font-size: 1.25rem;">{{ number_format($phieuNhap->tong_tien) }} đ</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                @if($phieuNhap->ghi_chu)
                <div class="mt-3">
                    <strong>Ghi chú:</strong>
                    <p class="mb-0">{{ $phieuNhap->ghi_chu }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list-ul"></i> Chi tiết sản phẩm nhập</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Sản phẩm</th>
                                <th>SKU</th>
                                <th class="text-end">Số lượng</th>
                                <th class="text-end">Giá vốn nhập</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($phieuNhap->chiTietPhieuNhaps as $index => $ct)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $ct->bienThe->sanPham->ten }}</strong>
                                    <br><small class="text-muted">{{ $ct->bienThe->sanPham->danhMuc->ten }}</small>
                                </td>
                                <td><code>{{ $ct->bienThe->sku }}</code></td>
                                <td class="text-end">{{ number_format($ct->so_luong_nhap) }}</td>
                                <td class="text-end">{{ number_format($ct->gia_von_nhap) }} đ</td>
                                <td class="text-end"><strong>{{ number_format($ct->so_luong_nhap * $ct->gia_von_nhap) }} đ</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Tổng cộng:</th>
                                <th class="text-end text-primary">{{ number_format($phieuNhap->tong_tien) }} đ</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deletePhieuNhap(id) {
    if (!confirm('Bạn có chắc chắn muốn xóa phiếu nhập này? Số lượng tồn kho sẽ được hoàn trả!')) return;
    
    fetch(`/admin/phieunhap/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            window.location.href = '{{ route('admin.phieunhap.index') }}';
        } else {
            alert('Có lỗi xảy ra!');
        }
    });
}
</script>
@endpush
@endsection

