@extends('admin.layout')

@section('title', 'Sửa IMEI')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Sửa IMEI</h2>
        <a href="{{ route('admin.imei.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.imei.update', $imei->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                    <select name="sanpham_id" id="sanpham_id" class="form-select" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        @foreach($sanPhams as $sp)
                            <option value="{{ $sp->id }}" {{ $imei->bienThe->sanpham_id == $sp->id ? 'selected' : '' }}>
                                {{ $sp->ten }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Biến thể <span class="text-danger">*</span></label>
                    <select name="bien_the_id" id="bien_the_id" class="form-select @error('bien_the_id') is-invalid @enderror" required>
                        <option value="{{ $imei->bien_the_id }}">
                            {{ $imei->bienThe->sku }} - {{ $imei->bienThe->gia_tri_thuoc_tinh }}
                        </option>
                    </select>
                    @error('bien_the_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Số IMEI/Serial <span class="text-danger">*</span></label>
                    <input type="text" name="so_imei" class="form-control @error('so_imei') is-invalid @enderror" 
                           value="{{ old('so_imei', $imei->so_imei) }}" required>
                    @error('so_imei')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                    <select name="trang_thai" class="form-select @error('trang_thai') is-invalid @enderror" required>
                        <option value="available" {{ $imei->trang_thai == 'available' ? 'selected' : '' }}>Có sẵn</option>
                        <option value="sold" {{ $imei->trang_thai == 'sold' ? 'selected' : '' }}>Đã bán</option>
                        <option value="warranty" {{ $imei->trang_thai == 'warranty' ? 'selected' : '' }}>Đang bảo hành</option>
                        <option value="returned" {{ $imei->trang_thai == 'returned' ? 'selected' : '' }}>Đã trả lại</option>
                    </select>
                    @error('trang_thai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="ghi_chu" class="form-control" rows="3">{{ old('ghi_chu', $imei->ghi_chu) }}</textarea>
                </div>

                @if($imei->chiTietDonHang)
                <div class="alert alert-info">
                    <strong>Thông tin đơn hàng:</strong><br>
                    Mã đơn: <a href="{{ route('admin.donhang.show', $imei->chiTietDonHang->donhang_id) }}">
                        {{ $imei->chiTietDonHang->donHang->ma_don_hang }}
                    </a><br>
                    Ngày bán: {{ $imei->ngay_ban ? $imei->ngay_ban->format('d/m/Y H:i') : '-' }}
                </div>
                @endif

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                    <a href="{{ route('admin.imei.index') }}" class="btn btn-secondary">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('sanpham_id').addEventListener('change', function() {
    const sanphamId = this.value;
    const bienTheSelect = document.getElementById('bien_the_id');
    const currentBienTheId = {{ $imei->bien_the_id }};
    
    bienTheSelect.innerHTML = '<option value="">-- Đang tải... --</option>';
    
    if (!sanphamId) {
        bienTheSelect.innerHTML = '<option value="">-- Chọn sản phẩm trước --</option>';
        return;
    }
    
    fetch(`/admin/imei/api/bien-the/${sanphamId}`)
        .then(response => response.json())
        .then(data => {
            bienTheSelect.innerHTML = '<option value="">-- Chọn biến thể --</option>';
            data.forEach(bt => {
                const option = document.createElement('option');
                option.value = bt.id;
                option.textContent = `${bt.sku} - ${bt.gia_tri} (Tồn: ${bt.so_luong_ton})`;
                if (bt.id == currentBienTheId) {
                    option.selected = true;
                }
                bienTheSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            bienTheSelect.innerHTML = '<option value="">-- Lỗi tải dữ liệu --</option>';
        });
});
</script>
@endpush
@endsection
