@extends('admin.layout')

@section('title', 'Quản lý Người dùng')

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
        font-size: 0.875rem;
    }
    .table-container {
        background: white;
        border-radius: 0.75rem;
        border: 1px solid var(--border-color);
        overflow: hidden;
        position: relative;
    }
    .table {
        margin: 0;
        font-size: 0.875rem;
        width: 100%;
    }
    .table thead {
        background: #f9fafb;
    }
    .table thead th {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--text-primary);
        padding: 0.75rem 1rem;
        border-bottom: 2px solid var(--border-color);
        white-space: nowrap;
        position: relative;
        cursor: pointer;
        user-select: none;
        text-align: left;
    }
    .table thead th:hover {
        background-color: #f3f4f6;
    }
    .table thead th.sortable {
        padding-right: 1.75rem;
    }
    .sort-icon {
        display: inline-block;
        margin-left: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.7rem;
        opacity: 0.5;
        transition: all 0.2s;
        vertical-align: middle;
    }
    .table thead th:hover .sort-icon {
        opacity: 1;
    }
    .table thead th.sort-asc .sort-icon,
    .table thead th.sort-desc .sort-icon {
        opacity: 1;
        color: var(--primary-color);
    }
    .table thead th.sort-asc .sort-icon i.bi-arrow-down-up::before {
        content: "\f128";
    }
    .table thead th.sort-desc .sort-icon i.bi-arrow-down-up::before {
        content: "\f12a";
    }
    .table thead th.sort-asc .sort-icon i,
    .table thead th.sort-desc .sort-icon i {
        font-weight: bold;
    }
    .table tbody td {
        padding: 0.75rem 1rem;
        vertical-align: middle;
    }
    .table tbody td:nth-child(2) {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .table tbody tr {
        transition: background-color 0.15s;
    }
    .table tbody tr:hover {
        background-color: #f9fafb;
    }
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    .btn-icon-sm {
        width: 28px;
        height: 28px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.4rem;
        font-size: 0.8rem;
    }
    .pagination-container {
        background: white;
        padding: 1rem 1.25rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .pagination-info {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    .pagination {
        margin: 0;
    }
    .pagination .page-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.8rem;
        border-color: var(--border-color);
        color: var(--text-primary);
    }
    .pagination .page-link:hover {
        background-color: var(--sidebar-hover);
        border-color: var(--border-color);
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
        border-color: #2563eb;
    }
    .loading-overlay {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        z-index: 10;
        align-items: center;
        justify-content: center;
    }
    .loading-overlay.show {
        display: flex;
    }
    .empty-state {
        text-align: center;
        padding: 2.5rem 1rem;
        color: var(--text-secondary);
    }
    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        opacity: 0.3;
    }
    .empty-state p {
        margin: 0;
        font-size: 0.875rem;
    }
    @media (max-width: 768px) {
        .header-row {
            flex-direction: column;
            align-items: stretch;
        }
        .header-left {
            flex-direction: column;
            align-items: stretch;
        }
        .search-box-compact {
            max-width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header-compact">
    <div class="header-row">
        <div class="header-left">
            <h4 class="header-title">
                <i class="bi bi-people"></i>
                <span>Quản lý Người dùng</span>
            </h4>
            <div class="search-box-compact">
                <i class="bi bi-search"></i>
                <input type="text" 
                       id="searchInput" 
                       class="form-control" 
                       placeholder="Tìm kiếm..." 
                       value="{{ request('search') }}">
            </div>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Đang tải...</span>
        </div>
    </div>
    <div id="tableContent">
        @include('admin.nguoidung.table', ['users' => $users])
    </div>
    <div id="paginationContent">
        @include('admin.nguoidung.pagination', ['users' => $users])
    </div>
</div>
@endsection

@push('scripts')
<script>
    let searchTimeout;
    let currentSortBy = '{{ request('sort_by', 'created_at') }}';
    let currentSortOrder = '{{ request('sort_order', 'desc') }}';
    
    const searchInput = document.getElementById('searchInput');
    const tableContent = document.getElementById('tableContent');
    const paginationContent = document.getElementById('paginationContent');
    const loadingOverlay = document.getElementById('loadingOverlay');

    function loadData() {
        const search = searchInput.value;

        loadingOverlay.classList.add('show');

        const url = new URL('{{ route('admin.nguoidung.index') }}', window.location.origin);
        if (search) url.searchParams.set('search', search);
        url.searchParams.set('sort_by', currentSortBy);
        url.searchParams.set('sort_order', currentSortOrder);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            tableContent.innerHTML = data.html;
            paginationContent.innerHTML = data.pagination;
            loadingOverlay.classList.remove('show');
            updateSortIcons();
        })
        .catch(error => {
            console.error('Error:', error);
            loadingOverlay.classList.remove('show');
            showToast('Có lỗi xảy ra khi tải dữ liệu', 'error');
        });
    }

    function sortColumn(column) {
        if (currentSortBy === column) {
            currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            currentSortBy = column;
            currentSortOrder = 'desc';
        }
        loadData();
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateSortIcons();
    });

    function updateSortIcons() {
        document.querySelectorAll('.table thead th.sortable').forEach(th => {
            th.classList.remove('sort-asc', 'sort-desc');
            const icon = th.querySelector('.sort-icon i');
            if (icon) {
                icon.className = 'bi bi-arrow-down-up';
            }
        });

        const currentTh = document.querySelector(`.table thead th[data-sort="${currentSortBy}"]`);
        if (currentTh) {
            currentTh.classList.add(`sort-${currentSortOrder}`);
            const icon = currentTh.querySelector('.sort-icon i');
            if (icon) {
                icon.className = currentSortOrder === 'asc' 
                    ? 'bi bi-arrow-up' 
                    : 'bi bi-arrow-down';
            }
        }
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadData();
        }, 500);
    });

    tableContent.addEventListener('click', function(e) {
        const th = e.target.closest('th.sortable');
        if (th) {
            const column = th.getAttribute('data-sort');
            if (column) {
                sortColumn(column);
            }
        }
    });

    paginationContent.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href && !link.hasAttribute('data-no-ajax')) {
            e.preventDefault();
            const url = link.href;
            
            loadingOverlay.classList.add('show');

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                tableContent.innerHTML = data.html;
                paginationContent.innerHTML = data.pagination;
                loadingOverlay.classList.remove('show');
                updateSortIcons();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Error:', error);
                loadingOverlay.classList.remove('show');
            });
        }
    });
</script>
@endpush
