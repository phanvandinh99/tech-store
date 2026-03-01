@extends('admin.layout')

@section('title', 'Thêm IMEI')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Thêm IMEI</h2>
        <a href="{{ route('admin.imei.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.imei.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                    <select name="sanpham_id" id="sanpham_id" class="form-select @error('sanpham_id') is-invalid @enderror" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        @foreach($sanPhams as $sp)
                            <option value="{{ $sp->id }}" {{ old('sanpham_id') == $sp->id ? 'selected' : '' }}>
                                {{ $sp->ten }}
                            </option>
                        @endforeach
                    </select>
                    @error('sanpham_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Biến thể <span class="text-danger">*</span></label>
                    <select name="bien_the_id" id="bien_the_id" class="form-select @error('bien_the_id') is-invalid @enderror" required>
                        <option value="">-- Chọn sản phẩm trước --</option>
                    </select>
                    @error('bien_the_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Số IMEI/Serial <span class="text-danger">*</span></label>
                    <input type="text" name="so_imei" class="form-control @error('so_imei') is-invalid @enderror" 
                           value="{{ old('so_imei') }}" placeholder="Nhập số IMEI hoặc Serial Number" required>
                    @error('so_imei')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Ví dụ: 123456789012345</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="ghi_chu" class="form-control" rows="3">{{ old('ghi_chu') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu
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
                @if(old('bien_the_id'))
                    if (bt.id == {{ old('bien_the_id') }}) {
                        option.selected = true;
                    }
                @endif
                @if(isset($bienTheId))
                    if (bt.id == {{ $bienTheId }}) {
                        option.selected = true;
                    }
                @endif
                bienTheSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            bienTheSelect.innerHTML = '<option value="">-- Lỗi tải dữ liệu --</option>';
        });
});

// Trigger change if product is pre-selected
@if(old('sanpham_id') || isset($bienTheId))
    document.getElementById('sanpham_id').dispatchEvent(new Event('change'));
@endif
</script>
@endpush
@endsection
