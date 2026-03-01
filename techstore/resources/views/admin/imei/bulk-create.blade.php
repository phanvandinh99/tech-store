@extends('admin.layout')

@section('title', 'Nhập nhiều IMEI')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Nhập nhiều IMEI</h2>
        <a href="{{ route('admin.imei.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Hướng dẫn:</strong>
                <ul class="mb-0">
                    <li>Nhập mỗi số IMEI trên một dòng</li>
                    <li>Tất cả IMEI sẽ được gán cho cùng một biến thể sản phẩm</li>
                    <li>Hệ thống sẽ tự động bỏ qua các IMEI trùng lặp</li>
                </ul>
            </div>

            <form action="{{ route('admin.imei.bulk-store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                    <select name="sanpham_id" id="sanpham_id" class="form-select" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        @foreach($sanPhams as $sp)
                            <option value="{{ $sp->id }}" {{ old('sanpham_id') == $sp->id ? 'selected' : '' }}>
                                {{ $sp->ten }}
                            </option>
                        @endforeach
                    </select>
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
                    <label class="form-label">Danh sách IMEI <span class="text-danger">*</span></label>
                    <textarea name="imei_list" class="form-control @error('imei_list') is-invalid @enderror" 
                              rows="10" placeholder="Nhập mỗi IMEI trên một dòng&#10;Ví dụ:&#10;123456789012345&#10;234567890123456&#10;345678901234567" required>{{ old('imei_list') }}</textarea>
                    @error('imei_list')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Số lượng IMEI: <span id="imei_count">0</span></small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu tất cả
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
// Load variants when product changes
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
                bienTheSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            bienTheSelect.innerHTML = '<option value="">-- Lỗi tải dữ liệu --</option>';
        });
});

// Count IMEI lines
document.querySelector('textarea[name="imei_list"]').addEventListener('input', function() {
    const lines = this.value.split('\n').filter(line => line.trim() !== '');
    document.getElementById('imei_count').textContent = lines.length;
});

// Trigger change if product is pre-selected
@if(old('sanpham_id'))
    document.getElementById('sanpham_id').dispatchEvent(new Event('change'));
@endif

// Initial count
document.querySelector('textarea[name="imei_list"]').dispatchEvent(new Event('input'));
</script>
@endpush
@endsection
