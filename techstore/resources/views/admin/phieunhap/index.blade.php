@extends('admin.layout')

@section('title', 'Quản lý Nhập hàng')

@push('styles')
<style>
    .page-header-compact {
        background: white;
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        border: 1px solid var(--border-color);
        margin-bottom: 1rem;
    }
    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
    }
    .header-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .search-box-compact {
        position: relative;
        flex: 1;
        max-width: 300px;
    }
    .search-box-compact input {
        padding-left: 2.5rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        height: 38px;
    }
    .search-box-compact i {
        position: absolute;
        left: 0.875rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
    }
    .filter-controls {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }
    .filter-controls input[type="date"] {
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.5rem;
        font-size: 0.875rem;
        height: 38px;
    }
    .sort-icon {
        display: inline-block;
        margin-left: 0.5rem;
        font-size: 0.75rem;
        opacity: 0.6;
    }
    .sort-icon.active {
        opacity: 1;
        color: var(--primary-color);
    }
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10;
    }
    .loading-overlay.active {
        display: flex;
    }
</style>
@endpush

@section('content')
<div class="page-header-compact">
    <div class="header-row">
        <div class="header-left">
            <h5 class="header-title">
                <i class="bi bi-box-arrow-in-down"></i>
                Quản lý Nhập hàng
            </h5>
            <div class="search-box-compact">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Tìm kiếm..." value="{{ request('search') }}">
            </div>
            <div class="filter-controls">
                <input type="date" id="dateFrom" placeholder="Từ ngày" value="{{ request('date_from') }}">
                <input type="date" id="dateTo" placeholder="Đến ngày" value="{{ request('date_to') }}">
            </div>
        </div>
        <a href="{{ route('admin.phieunhap.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tạo phiếu nhập
        </a>
    </div>
</div>

<div class="card position-relative">
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="card-body">
        <div id="tableContainer">
            @include('admin.phieunhap.table')
        </div>
        <div id="paginationContainer">
            @include('admin.phieunhap.pagination')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentSortBy = '{{ request('sort_by', 'created_at') }}';
let currentSortOrder = '{{ request('sort_order', 'desc') }}';
let searchTimeout;

function loadData() {
    const search = document.getElementById('searchInput').value;
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    
    document.getElementById('loadingOverlay').classList.add('active');
    
    const params = new URLSearchParams({
        search: search || '',
        date_from: dateFrom || '',
        date_to: dateTo || '',
        sort_by: currentSortBy,
        sort_order: currentSortOrder,
        page: 1
    });
    
    fetch(`{{ route('admin.phieunhap.index') }}?${params}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('tableContainer').innerHTML = data.html;
        document.getElementById('paginationContainer').innerHTML = data.pagination;
        document.getElementById('loadingOverlay').classList.remove('active');
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('loadingOverlay').classList.remove('active');
    });
}

function sort(column) {
    if (currentSortBy === column) {
        currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
    } else {
        currentSortBy = column;
        currentSortOrder = 'asc';
    }
    loadData();
}

// Search
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(loadData, 500);
});

// Date filters
document.getElementById('dateFrom').addEventListener('change', loadData);
document.getElementById('dateTo').addEventListener('change', loadData);

// Pagination
document.addEventListener('click', function(e) {
    if (e.target.closest('.pagination a')) {
        e.preventDefault();
        const url = new URL(e.target.closest('.pagination a').href);
        const params = new URLSearchParams(url.search);
        
        document.getElementById('loadingOverlay').classList.add('active');
        
        fetch(e.target.closest('.pagination a').href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('tableContainer').innerHTML = data.html;
            document.getElementById('paginationContainer').innerHTML = data.pagination;
            document.getElementById('loadingOverlay').classList.remove('active');
        });
    }
});
</script>
@endpush

