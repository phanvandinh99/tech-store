@extends('admin.layout')

@section('title', 'Quản lý bảo hành')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-6">
        <div class="card text-center">
            <div class="card-body py-3">
                <h4 class="mb-0">{{ $thongKe['tong'] }}</h4>
                <small class="text-muted">Tổng yêu cầu</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center border-warning">
            <div class="card-body py-3">
                <h4 class="mb-0 text-warning">{{ $thongKe['cho_tiep_nhan'] }}</h4>
                <small class="text-muted">Chờ tiếp nhận</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center border-info">
            <div class="card-body py-3">
                <h4 class="mb-0 text-info">{{ $thongKe['dang_xu_ly'] }}</h4>
                <small class="text-muted">Đang xử lý</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center border-success">
            <div class="card-body py-3">
                <h4 class="mb-0 text-success">{{ $thongKe['hoan_tat'] }}</h4>
                <small class="text-muted">Hoàn tất</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-shield-check"></i> Danh sách yêu cầu bảo hành
    </div>
    <div class="card-body">
        <!-- Filters -->
        <div class="row mb-3 g-2">
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchInput" placeholder="Tìm mã yêu cầu, khách hàng..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterTrangThai">
                    <option value="">-- Trạng thái --</option>
                    <option value="cho_tiep_nhan" {{ request('trang_thai') == 'cho_tiep_nhan' ? 'selected' : '' }}>Chờ tiếp nhận</option>
                    <option value="dang_xu_ly" {{ request('trang_thai') == 'dang_xu_ly' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="hoan_tat" {{ request('trang_thai') == 'hoan_tat' ? 'selected' : '' }}>Hoàn tất</option>
                    <option value="tu_choi" {{ request('trang_thai') == 'tu_choi' ? 'selected' : '' }}>Từ chối</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterHinhThuc">
                    <option value="">-- Hình thức --</option>
                    <option value="sua_chua" {{ request('hinh_thuc') == 'sua_chua' ? 'selected' : '' }}>Sửa chữa</option>
                    <option value="thay_the" {{ request('hinh_thuc') == 'thay_the' ? 'selected' : '' }}>Thay thế</option>
                    <option value="doi_moi" {{ request('hinh_thuc') == 'doi_moi' ? 'selected' : '' }}>Đổi mới</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" onclick="applyFilters()">
                    <i class="bi bi-search"></i> Lọc
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive" id="tableContainer">
            @include('admin.baohanh.table')
        </div>

        <!-- Pagination -->
        <div id="paginationContainer">
            @include('admin.baohanh.pagination')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function applyFilters() {
        const search = document.getElementById('searchInput').value;
        const trangThai = document.getElementById('filterTrangThai').value;
        const hinhThuc = document.getElementById('filterHinhThuc').value;
        let url = '{{ route("admin.baohanh.index") }}?';
        if (search) url += 'search=' + encodeURIComponent(search) + '&';
        if (trangThai) url += 'trang_thai=' + trangThai + '&';
        if (hinhThuc) url += 'hinh_thuc=' + hinhThuc;
        window.location.href = url;
    }

    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') applyFilters();
    });
</script>
@endpush

