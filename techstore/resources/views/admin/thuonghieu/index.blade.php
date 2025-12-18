@extends('admin.layout')

@section('title', 'Quản lý thương hiệu')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="bi bi-bookmark-star"></i> Danh sách thương hiệu</span>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-lg"></i> Thêm thương hiệu
        </button>
    </div>
    <div class="card-body">
        <!-- Search -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive" id="tableContainer">
            @include('admin.thuonghieu.table')
        </div>

        <!-- Pagination -->
        <div id="paginationContainer">
            @include('admin.thuonghieu.pagination')
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.thuonghieu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Thêm thương hiệu mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên thương hiệu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="ten" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="mo_ta" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" class="form-control" name="hinh_logo" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Sửa thương hiệu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên thương hiệu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="ten" id="editTen" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="mo_ta" id="editMoTa" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo hiện tại</label>
                        <div id="currentLogo"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo mới</label>
                        <input type="file" class="form-control" name="hinh_logo" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Search
    document.getElementById('searchBtn').addEventListener('click', function() {
        const search = document.getElementById('searchInput').value;
        window.location.href = '{{ route("admin.thuonghieu.index") }}?search=' + encodeURIComponent(search);
    });

    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('searchBtn').click();
        }
    });

    // Edit Modal
    function openEditModal(id, ten, moTa, logo) {
        document.getElementById('editForm').action = '{{ route("admin.thuonghieu.index") }}/' + id;
        document.getElementById('editTen').value = ten;
        document.getElementById('editMoTa').value = moTa || '';
        
        const logoContainer = document.getElementById('currentLogo');
        if (logo) {
            logoContainer.innerHTML = '<img src="/storage/' + logo + '" class="img-thumbnail" style="max-width: 100px;">';
        } else {
            logoContainer.innerHTML = '<span class="text-muted">Chưa có logo</span>';
        }
        
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }
</script>
@endpush

