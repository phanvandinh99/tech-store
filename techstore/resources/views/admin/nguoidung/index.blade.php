@extends('admin.layout')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-people"></i> Quản lý người dùng</h4>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.nguoidung.index') }}" id="searchForm">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" 
                           value="{{ request('search') }}" placeholder="Tìm theo tên, email...">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="vai_tro">
                        <option value="">Tất cả vai trò</option>
                        <option value="admin" {{ request('vai_tro') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="customer" {{ request('vai_tro') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="trang_thai">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" {{ request('trang_thai') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ request('trang_thai') == 'inactive' ? 'selected' : '' }}>Tạm khóa</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-body">
        <div id="tableContainer">
            @include('admin.nguoidung.table')
        </div>
    </div>
</div>

<!-- Pagination -->
<div id="paginationContainer" class="mt-3">
    @include('admin.nguoidung.pagination')
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto search on form change
    $('#searchForm select').change(function() {
        $('#searchForm').submit();
    });
    
    // AJAX pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        loadPage(url);
    });
    
    function loadPage(url) {
        $.get(url, function(data) {
            $('#tableContainer').html(data.html);
            $('#paginationContainer').html(data.pagination);
        });
    }
});
</script>
@endpush