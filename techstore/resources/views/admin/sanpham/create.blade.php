@extends('admin.layout')

@section('title', 'Thêm Sản phẩm')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Thêm Sản phẩm mới</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sanpham.store') }}" method="POST" id="sanphamForm" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Thông tin cơ bản -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ten" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ten') is-invalid @enderror" 
                                   id="ten" name="ten" value="{{ old('ten') }}" required>
                            @error('ten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="danhmuc_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-select @error('danhmuc_id') is-invalid @enderror" 
                                    id="danhmuc_id" name="danhmuc_id" required>
                                <option value="">Chọn danh mục</option>
                                @foreach($danhMucs as $danhMuc)
                                    <option value="{{ $danhMuc->id }}" {{ old('danhmuc_id') == $danhMuc->id ? 'selected' : '' }}>
                                        {{ $danhMuc->ten }}
                                    </option>
                                @endforeach
                            </select>
                            @error('danhmuc_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="mota" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mota') is-invalid @enderror" 
                                  id="mota" name="mota" rows="4">{{ old('mota') }}</textarea>
                        @error('mota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Thuộc tính sản phẩm -->
                    <hr>
                    <h5 class="mb-3"><i class="bi bi-tags"></i> Thuộc tính sản phẩm</h5>
                    <div class="mb-3">
                        <label class="form-label">Chọn thuộc tính</label>
                        <div class="row">
                            @foreach($thuocTinhs as $thuocTinh)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input thuoc-tinh-checkbox" 
                                           type="checkbox" 
                                           name="thuoc_tinh_ids[]" 
                                           value="{{ $thuocTinh->id }}"
                                           id="thuoc_tinh_{{ $thuocTinh->id }}"
                                           data-thuoctinh-id="{{ $thuocTinh->id }}">
                                    <label class="form-check-label" for="thuoc_tinh_{{ $thuocTinh->id }}">
                                        <strong>{{ $thuocTinh->ten }}</strong>
                                    </label>
                                </div>
                                <div class="ms-4">
                                    @foreach($thuocTinh->giaTriThuocTinhs as $giaTri)
                                        <small class="d-block text-muted">- {{ $giaTri->giatri }}</small>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Ảnh sản phẩm chung -->
                    <hr>
                    <h5 class="mb-3"><i class="bi bi-images"></i> Ảnh sản phẩm (chung)</h5>
                    <div class="mb-3">
                        <label for="images" class="form-label">Chọn ảnh</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                        <small class="text-muted">Có thể chọn nhiều ảnh. Ảnh đầu tiên sẽ là ảnh chính.</small>
                    </div>
                    <div id="imagePreview" class="row mb-3"></div>

                    <!-- Biến thể sản phẩm -->
                    <hr>
                    <h5 class="mb-3"><i class="bi bi-box-seam"></i> Biến thể sản phẩm</h5>
                    <div id="bienTheContainer">
                        <div class="bien-the-item card mb-3">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>Biến thể 1</strong>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeBienThe(this)" disabled>
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">SKU <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="bien_the[0][sku]" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="bien_the[0][gia]" min="0" step="1000" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Giá vốn (VNĐ) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="bien_the[0][gia_von]" min="0" step="1000" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Số lượng tồn <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="bien_the[0][so_luong_ton]" min="0" required>
                                    </div>
                                </div>
                                
                                <!-- Giá trị thuộc tính cho biến thể -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label">Giá trị thuộc tính (tùy chọn)</label>
                                        <div id="giatri_thuoctinh_0" class="giatri-thuoctinh-container">
                                            <!-- Sẽ được populate bằng JavaScript -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Ảnh cho biến thể -->
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label">Ảnh cho biến thể này (tùy chọn)</label>
                                        <input type="file" class="form-control" name="bien_the[0][images][]" multiple accept="image/*">
                                        <small class="text-muted">Nếu không chọn, sẽ dùng ảnh chung của sản phẩm.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addBienThe()">
                        <i class="bi bi-plus"></i> Thêm biến thể
                    </button>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.sanpham.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let bienTheIndex = 1;
const thuocTinhs = @json($thuocTinhs->mapWithKeys(function($tt) {
    return [$tt->id => $tt->giaTriThuocTinhs->pluck('id', 'giatri')];
}));

// Preview ảnh
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    Array.from(e.target.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-md-2 mb-2';
            col.innerHTML = `
                <div class="position-relative">
                    <img src="${e.target.result}" class="img-thumbnail" style="width: 100%; height: 100px; object-fit: cover;">
                    ${index === 0 ? '<span class="badge bg-primary position-absolute top-0 start-0 m-1">Ảnh chính</span>' : ''}
                </div>
            `;
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    });
});

// Cập nhật giá trị thuộc tính khi chọn thuộc tính
document.querySelectorAll('.thuoc-tinh-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        updateGiaTriThuocTinhForAllVariants();
    });
});

function updateGiaTriThuocTinhForAllVariants() {
    document.querySelectorAll('.bien-the-item').forEach((item, index) => {
        updateGiaTriThuocTinh(index);
    });
}

function updateGiaTriThuocTinh(bienTheIndex) {
    const container = document.getElementById(`giatri_thuoctinh_${bienTheIndex}`);
    if (!container) return;
    
    container.innerHTML = '';
    
    document.querySelectorAll('.thuoc-tinh-checkbox:checked').forEach(checkbox => {
        const thuocTinhId = checkbox.value;
        const giatriList = thuocTinhs[thuocTinhId] || {};
        
        const row = document.createElement('div');
        row.className = 'mb-2';
        row.innerHTML = `
            <label class="form-label small"><strong>${checkbox.nextElementSibling.textContent.trim()}</strong></label>
            <select class="form-select form-select-sm" name="bien_the[${bienTheIndex}][giatri_thuoctinh_ids][]">
                <option value="">-- Chọn giá trị --</option>
                ${Object.entries(giatriList).map(([giatri, id]) => 
                    `<option value="${id}">${giatri}</option>`
                ).join('')}
            </select>
        `;
        container.appendChild(row);
    });
}

function addBienThe() {
    const container = document.getElementById('bienTheContainer');
    const newItem = document.createElement('div');
    newItem.className = 'bien-the-item card mb-3';
    newItem.innerHTML = `
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <strong>Biến thể ${bienTheIndex + 1}</strong>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeBienThe(this)">
                    <i class="bi bi-trash"></i> Xóa
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">SKU <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="bien_the[${bienTheIndex}][sku]" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="bien_the[${bienTheIndex}][gia]" min="0" step="1000" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Giá vốn (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="bien_the[${bienTheIndex}][gia_von]" min="0" step="1000" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Số lượng tồn <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="bien_the[${bienTheIndex}][so_luong_ton]" min="0" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Giá trị thuộc tính (tùy chọn)</label>
                    <div id="giatri_thuoctinh_${bienTheIndex}" class="giatri-thuoctinh-container"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label class="form-label">Ảnh cho biến thể này (tùy chọn)</label>
                    <input type="file" class="form-control" name="bien_the[${bienTheIndex}][images][]" multiple accept="image/*">
                </div>
            </div>
        </div>
    `;
    container.appendChild(newItem);
    updateGiaTriThuocTinh(bienTheIndex);
    bienTheIndex++;
    
    // Enable delete button cho biến thể đầu tiên
    const firstDeleteBtn = container.querySelector('.bien-the-item:first-child .btn-danger');
    if (firstDeleteBtn) {
        firstDeleteBtn.disabled = false;
    }
}

function removeBienThe(btn) {
    if (document.querySelectorAll('.bien-the-item').length > 1) {
        btn.closest('.bien-the-item').remove();
        // Renumber variants
        document.querySelectorAll('.bien-the-item').forEach((item, index) => {
            item.querySelector('.card-header strong').textContent = `Biến thể ${index + 1}`;
            // Update all inputs in this variant
            item.querySelectorAll('input, select').forEach(input => {
                const name = input.name;
                if (name) {
                    input.name = name.replace(/bien_the\[\d+\]/, `bien_the[${index}]`);
                }
            });
            // Update container ID
            const container = item.querySelector('.giatri-thuoctinh-container');
            if (container) {
                container.id = `giatri_thuoctinh_${index}`;
                updateGiaTriThuocTinh(index);
            }
        });
        bienTheIndex = document.querySelectorAll('.bien-the-item').length;
    } else {
        alert('Sản phẩm phải có ít nhất 1 biến thể!');
    }
}

// Initialize giá trị thuộc tính cho biến thể đầu tiên
updateGiaTriThuocTinh(0);
</script>
@endpush
@endsection
