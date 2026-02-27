@extends('admin.layout')

@section('title', 'Sửa Thuộc tính')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Sửa Thuộc tính: {{ $thuocTinh->ten }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.thuoctinh.index') }}">Thuộc tính</a></li>
                    <li class="breadcrumb-item active">Sửa</li>
                </ol>
            </nav>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Có lỗi xảy ra:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.thuoctinh.update', $thuocTinh->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên thuộc tính <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten') is-invalid @enderror" 
                               name="ten" value="{{ old('ten', $thuocTinh->ten) }}" 
                               placeholder="Ví dụ: Màu sắc, Dung lượng, RAM..." required>
                        @error('ten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Tên thuộc tính phải là duy nhất</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Giá trị thuộc tính <span class="text-danger">*</span></label>
                        <div id="giaTriContainer">
                            @foreach($thuocTinh->giaTriThuocTinhs as $index => $giaTri)
                            <div class="input-group mb-2 gia-tri-item">
                                <input type="text" class="form-control" name="gia_tri[]" 
                                       value="{{ old('gia_tri.' . $index, $giaTri->giatri) }}" 
                                       placeholder="Nhập giá trị" required>
                                <button type="button" class="btn btn-danger" onclick="removeGiaTri(this)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            @endforeach
                            
                            @if($thuocTinh->giaTriThuocTinhs->count() == 0)
                            <div class="input-group mb-2 gia-tri-item">
                                <input type="text" class="form-control" name="gia_tri[]" 
                                       placeholder="Nhập giá trị" required>
                                <button type="button" class="btn btn-danger" onclick="removeGiaTri(this)" disabled>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="addGiaTri()">
                            <i class="bi bi-plus-circle"></i> Thêm giá trị
                        </button>
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle"></i> Lưu ý: Xóa giá trị đang được sử dụng có thể ảnh hưởng đến sản phẩm
                        </small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Cập nhật thuộc tính
                        </button>
                        <a href="{{ route('admin.thuoctinh.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Hủy
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function addGiaTri() {
    const container = document.getElementById('giaTriContainer');
    const newItem = document.createElement('div');
    newItem.className = 'input-group mb-2 gia-tri-item';
    newItem.innerHTML = `
        <input type="text" class="form-control" name="gia_tri[]" 
               placeholder="Nhập giá trị" required>
        <button type="button" class="btn btn-danger" onclick="removeGiaTri(this)">
            <i class="bi bi-trash"></i>
        </button>
    `;
    container.appendChild(newItem);
    updateRemoveButtons();
}

function removeGiaTri(button) {
    button.closest('.gia-tri-item').remove();
    updateRemoveButtons();
}

function updateRemoveButtons() {
    const items = document.querySelectorAll('.gia-tri-item');
    items.forEach((item, index) => {
        const removeBtn = item.querySelector('.btn-danger');
        removeBtn.disabled = items.length === 1;
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateRemoveButtons();
});
</script>
@endpush
@endsection
