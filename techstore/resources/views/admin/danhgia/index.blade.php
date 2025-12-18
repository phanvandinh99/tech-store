@extends('admin.layout')

@section('title', 'Quản lý đánh giá')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-6">
        <div class="card text-center">
            <div class="card-body py-3">
                <h4 class="mb-0">{{ $thongKe['tong'] }}</h4>
                <small class="text-muted">Tổng đánh giá</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center border-warning">
            <div class="card-body py-3">
                <h4 class="mb-0 text-warning">{{ $thongKe['cho_duyet'] }}</h4>
                <small class="text-muted">Chờ duyệt</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center border-success">
            <div class="card-body py-3">
                <h4 class="mb-0 text-success">{{ $thongKe['da_duyet'] }}</h4>
                <small class="text-muted">Đã duyệt</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center border-secondary">
            <div class="card-body py-3">
                <h4 class="mb-0 text-secondary">{{ $thongKe['da_an'] }}</h4>
                <small class="text-muted">Đã ẩn</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="bi bi-star-half"></i> Danh sách đánh giá</span>
        <a href="{{ route('admin.danhgia.binhluan') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-chat-dots"></i> Quản lý bình luận
        </a>
    </div>
    <div class="card-body">
        <!-- Filters -->
        <div class="row mb-3 g-2">
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchInput" placeholder="Tìm sản phẩm, khách hàng..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterTrangThai">
                    <option value="">-- Trạng thái --</option>
                    <option value="pending" {{ request('trang_thai') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="approved" {{ request('trang_thai') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                    <option value="hidden" {{ request('trang_thai') == 'hidden' ? 'selected' : '' }}>Đã ẩn</option>
                    <option value="rejected" {{ request('trang_thai') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterSoSao">
                    <option value="">-- Số sao --</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('so_sao') == $i ? 'selected' : '' }}>{{ $i }} sao</option>
                    @endfor
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
            @include('admin.danhgia.table')
        </div>

        <!-- Pagination -->
        <div id="paginationContainer">
            @include('admin.danhgia.pagination')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function applyFilters() {
        const search = document.getElementById('searchInput').value;
        const trangThai = document.getElementById('filterTrangThai').value;
        const soSao = document.getElementById('filterSoSao').value;
        let url = '{{ route("admin.danhgia.index") }}?';
        if (search) url += 'search=' + encodeURIComponent(search) + '&';
        if (trangThai) url += 'trang_thai=' + trangThai + '&';
        if (soSao) url += 'so_sao=' + soSao;
        window.location.href = url;
    }

    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') applyFilters();
    });
</script>
@endpush

