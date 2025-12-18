@extends('admin.layout')

@section('title', 'Quản lý mã giảm giá')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="bi bi-ticket-perforated"></i> Danh sách mã giảm giá</span>
        <a href="{{ route('admin.magiamgia.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Thêm mã giảm giá
        </a>
    </div>
    <div class="card-body">
        <!-- Filters -->
        <div class="row mb-3 g-2">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Tìm mã hoặc tên..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterTrangThai">
                    <option value="">-- Trạng thái --</option>
                    <option value="active" {{ request('trang_thai') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request('trang_thai') == 'inactive' ? 'selected' : '' }}>Tạm dừng</option>
                    <option value="expired" {{ request('trang_thai') == 'expired' ? 'selected' : '' }}>Hết hạn</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive" id="tableContainer">
            @include('admin.magiamgia.table')
        </div>

        <!-- Pagination -->
        <div id="paginationContainer">
            @include('admin.magiamgia.pagination')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('searchBtn').addEventListener('click', function() {
        applyFilters();
    });

    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') applyFilters();
    });

    document.getElementById('filterTrangThai').addEventListener('change', function() {
        applyFilters();
    });

    function applyFilters() {
        const search = document.getElementById('searchInput').value;
        const trangThai = document.getElementById('filterTrangThai').value;
        let url = '{{ route("admin.magiamgia.index") }}?';
        if (search) url += 'search=' + encodeURIComponent(search) + '&';
        if (trangThai) url += 'trang_thai=' + trangThai;
        window.location.href = url;
    }
</script>
@endpush

