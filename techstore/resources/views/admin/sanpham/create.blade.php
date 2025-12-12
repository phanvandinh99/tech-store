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
                <form action="{{ route('admin.sanpham.store') }}" method="POST" id="sanphamForm">
                    @csrf
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
                                  id="mota" name="mota" rows="3">{{ old('mota') }}</textarea>
                        @error('mota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    <h5>Biến thể sản phẩm</h5>
                    <div id="bienTheContainer">
                        <div class="bien-the-item card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">SKU <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="bien_the[0][sku]" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Giá bán <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="bien_the[0][gia]" min="0" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Giá vốn <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="bien_the[0][gia_von]" min="0" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Số lượng tồn <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="bien_the[0][so_luong_ton]" min="0" required>
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

function addBienThe() {
    const container = document.getElementById('bienTheContainer');
    const newItem = document.createElement('div');
    newItem.className = 'bien-the-item card mb-3';
    newItem.innerHTML = `
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>Biến thể ${bienTheIndex + 1}</strong>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeBienThe(this)">
                    <i class="bi bi-trash"></i> Xóa
                </button>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">SKU <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="bien_the[${bienTheIndex}][sku]" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Giá bán <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="bien_the[${bienTheIndex}][gia]" min="0" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Giá vốn <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="bien_the[${bienTheIndex}][gia_von]" min="0" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Số lượng tồn <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="bien_the[${bienTheIndex}][so_luong_ton]" min="0" required>
                </div>
            </div>
        </div>
    `;
    container.appendChild(newItem);
    bienTheIndex++;
}

function removeBienThe(btn) {
    if (document.querySelectorAll('.bien-the-item').length > 1) {
        btn.closest('.bien-the-item').remove();
    } else {
        alert('Sản phẩm phải có ít nhất 1 biến thể!');
    }
}
</script>
@endpush
@endsection

