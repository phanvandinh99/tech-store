@extends('admin.layout')

@section('title', 'Nhật ký hoạt động')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4 col-6">
        <div class="card text-center">
            <div class="card-body py-3">
                <h4 class="mb-0">{{ $thongKe['tong'] }}</h4>
                <small class="text-muted">Tổng hoạt động</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-6">
        <div class="card text-center border-primary">
            <div class="card-body py-3">
                <h4 class="mb-0 text-primary">{{ $thongKe['hom_nay'] }}</h4>
                <small class="text-muted">Hôm nay</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-6">
        <div class="card text-center border-info">
            <div class="card-body py-3">
                <h4 class="mb-0 text-info">{{ $thongKe['tuan_nay'] }}</h4>
                <small class="text-muted">Tuần này</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-clock-history"></i> Nhật ký hoạt động
    </div>
    <div class="card-body">
        <!-- Filters -->
        <div class="row mb-3 g-2">
            <div class="col-md-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterHanhDong">
                    <option value="">-- Hành động --</option>
                    <option value="create" {{ request('hanh_dong') == 'create' ? 'selected' : '' }}>Tạo mới</option>
                    <option value="update" {{ request('hanh_dong') == 'update' ? 'selected' : '' }}>Cập nhật</option>
                    <option value="delete" {{ request('hanh_dong') == 'delete' ? 'selected' : '' }}>Xóa</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterLoaiModel">
                    <option value="">-- Loại --</option>
                    @foreach($loaiModels as $lm)
                        <option value="{{ $lm }}" {{ request('loai_model') == $lm ? 'selected' : '' }}>{{ $lm }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" id="filterNgayBatDau" value="{{ request('ngay_bat_dau') }}" placeholder="Từ ngày">
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" id="filterNgayKetThuc" value="{{ request('ngay_ket_thuc') }}" placeholder="Đến ngày">
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary w-100" onclick="applyFilters()">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            @include('admin.nhatky.table')
        </div>

        <!-- Pagination -->
        <div id="paginationContainer">
            @include('admin.nhatky.pagination')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function applyFilters() {
        const search = document.getElementById('searchInput').value;
        const hanhDong = document.getElementById('filterHanhDong').value;
        const loaiModel = document.getElementById('filterLoaiModel').value;
        const ngayBatDau = document.getElementById('filterNgayBatDau').value;
        const ngayKetThuc = document.getElementById('filterNgayKetThuc').value;
        
        let url = '{{ route("admin.nhatky.index") }}?';
        if (search) url += 'search=' + encodeURIComponent(search) + '&';
        if (hanhDong) url += 'hanh_dong=' + hanhDong + '&';
        if (loaiModel) url += 'loai_model=' + loaiModel + '&';
        if (ngayBatDau) url += 'ngay_bat_dau=' + ngayBatDau + '&';
        if (ngayKetThuc) url += 'ngay_ket_thuc=' + ngayKetThuc;
        window.location.href = url;
    }

    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') applyFilters();
    });
</script>
@endpush

