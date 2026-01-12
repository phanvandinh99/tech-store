@extends('admin.layout')

@section('title', 'Quản lý Nhà cung cấp')

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
                <i class="bi bi-building"></i>
                Quản lý Nhà cung cấp
            </h5>
            <div class="search-box-compact">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Tìm kiếm..." value="{{ request('search') }}">
            </div>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNhaCungCapModal">
            <i class="bi bi-plus-circle"></i> Thêm nhà cung cấp
        </button>
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
            @include('admin.nhacungcap.table')
        </div>
        <div id="paginationContainer">
            @include('admin.nhacungcap.pagination')
        </div>
    </div>
</div>

<!-- Modal Thêm/Sửa nhà cung cấp -->
<div class="modal fade" id="addNhaCungCapModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm nhà cung cấp mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addNhaCungCapForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên nhà cung cấp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="ten" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="sdt">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <textarea class="form-control" name="dia_chi" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sửa nhà cung cấp -->
<div class="modal fade" id="editNhaCungCapModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa nhà cung cấp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editNhaCungCapForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên nhà cung cấp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="ten" id="edit_ten" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="sdt" id="edit_sdt">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="edit_email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <textarea class="form-control" name="dia_chi" id="edit_dia_chi" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
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
    
    document.getElementById('loadingOverlay').classList.add('active');
    
    const params = new URLSearchParams({
        search: search || '',
        sort_by: currentSortBy,
        sort_order: currentSortOrder,
        page: 1
    });
    
    fetch(`{{ route('admin.nhacungcap.index') }}?${params}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            if (!response.ok) {
                return response.json().then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }
                    throw new Error(data.message || 'Network response was not ok');
                });
            }
            return response.json();
        } else {
            throw new Error('Response is not JSON');
        }
    })
    .then(data => {
        if (data && data.redirect) {
            window.location.href = data.redirect;
            return;
        }
        if (data && data.html) {
            document.getElementById('tableContainer').innerHTML = data.html;
        }
        if (data && data.pagination) {
            document.getElementById('paginationContainer').innerHTML = data.pagination;
        }
        document.getElementById('loadingOverlay').classList.remove('active');
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('loadingOverlay').classList.remove('active');
        alert('Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại!');
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

// Thêm nhà cung cấp
document.getElementById('addNhaCungCapForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Đang xử lý...';
    
    fetch('{{ route('admin.nhacungcap.store') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            if (!response.ok) {
                return response.json().then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }
                    throw new Error(data.message || 'Network response was not ok');
                });
            }
            return response.json();
        } else {
            return response.text().then(text => {
                throw new Error('Response is not JSON: ' + text.substring(0, 100));
            });
        }
    })
    .then(data => {
        if (!data) return;
        if (data.redirect) {
            window.location.href = data.redirect;
            return;
        }
        if (data.success) {
            document.getElementById('addNhaCungCapModal').querySelector('.btn-close').click();
            this.reset();
            loadData();
            if (typeof showToast === 'function') {
                showToast('success', data.message || 'Thêm nhà cung cấp thành công!');
            }
        } else {
            let errorMsg = data.message || 'Có lỗi xảy ra!';
            if (data.errors) {
                errorMsg += '\n' + Object.values(data.errors).flat().join('\n');
            }
            alert(errorMsg);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi thêm nhà cung cấp!');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Sửa nhà cung cấp - từ data attributes (cách mới, an toàn hơn)
function editNhaCungCapFromButton(button) {
    const id = button.getAttribute('data-edit-id');
    const data = {
        ten: button.getAttribute('data-edit-ten') || '',
        sdt: button.getAttribute('data-edit-sdt') || '',
        email: button.getAttribute('data-edit-email') || '',
        dia_chi: button.getAttribute('data-edit-diachi') || ''
    };
    editNhaCungCap(id, data);
}

// Sửa nhà cung cấp - function gốc (giữ lại để tương thích)
function editNhaCungCap(id, data) {
    const modal = new bootstrap.Modal(document.getElementById('editNhaCungCapModal'));
    const form = document.getElementById('editNhaCungCapForm');
    
    // Sử dụng route helper hoặc tạo URL đúng cách
    const updateUrl = `{{ url('/admin/nhacungcap') }}/${id}`;
    form.setAttribute('data-action', updateUrl);
    form.action = updateUrl;
    
    document.getElementById('edit_ten').value = data.ten || '';
    document.getElementById('edit_sdt').value = data.sdt || '';
    document.getElementById('edit_email').value = data.email || '';
    document.getElementById('edit_dia_chi').value = data.dia_chi || '';
    
    modal.show();
}

document.getElementById('editNhaCungCapForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('_method', 'PUT');
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Đang xử lý...';
    
    // Lấy URL từ action hoặc data-action attribute
    const actionUrl = this.action || this.getAttribute('data-action');
    if (!actionUrl) {
        alert('Không tìm thấy URL cập nhật!');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        return;
    }
    
    fetch(actionUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(async response => {
        const contentType = response.headers.get('content-type');
        
        // Clone response để có thể đọc nhiều lần nếu cần
        const clonedResponse = response.clone();
        
        // Kiểm tra content-type trước
        if (!contentType || !contentType.includes('application/json')) {
            const text = await clonedResponse.text();
            console.error('Unexpected content-type:', contentType, 'Response:', text.substring(0, 200));
            throw new Error('Response is not JSON. Content-Type: ' + contentType);
        }
        
        // Parse JSON
        try {
            const data = await response.json();
            if (!response.ok) {
                if (data.redirect) {
                    window.location.href = data.redirect;
                    return null;
                }
                throw new Error(data.message || 'Network response was not ok');
            }
            return data;
        } catch (e) {
            // Nếu parse JSON thất bại, lấy text để debug
            const text = await clonedResponse.text();
            console.error('JSON parse error:', e, 'Response text:', text.substring(0, 200));
            throw new Error('Invalid JSON response: ' + text.substring(0, 100));
        }
    })
    .then(data => {
        if (!data) return;
        if (data.redirect) {
            window.location.href = data.redirect;
            return;
        }
        if (data.success) {
            document.getElementById('editNhaCungCapModal').querySelector('.btn-close').click();
            loadData();
            if (typeof showToast === 'function') {
                showToast('success', data.message || 'Cập nhật nhà cung cấp thành công!');
            }
        } else {
            let errorMsg = data.message || 'Có lỗi xảy ra!';
            if (data.errors) {
                errorMsg += '\n' + Object.values(data.errors).flat().join('\n');
            }
            alert(errorMsg);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cập nhật nhà cung cấp: ' + error.message);
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Xóa nhà cung cấp
function deleteNhaCungCap(id) {
    if (!confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này?')) return;
    
    fetch(`/admin/nhacungcap/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            if (!response.ok) {
                return response.json().then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }
                    throw new Error(data.message || 'Network response was not ok');
                });
            }
            return response.json();
        } else {
            return response.text().then(text => {
                throw new Error('Response is not JSON');
            });
        }
    })
    .then(data => {
        if (!data) return;
        if (data.redirect) {
            window.location.href = data.redirect;
            return;
        }
        if (data.success) {
            loadData();
            if (typeof showToast === 'function') {
                showToast('success', data.message || 'Xóa nhà cung cấp thành công!');
            }
        } else {
            alert(data.message || 'Có lỗi xảy ra!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi xóa nhà cung cấp!');
    });
}

// Pagination
document.addEventListener('click', function(e) {
    if (e.target.closest('.pagination a')) {
        e.preventDefault();
        document.getElementById('loadingOverlay').classList.add('active');
        
        fetch(e.target.closest('.pagination a').href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                if (!response.ok) {
                    return response.json().then(data => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                            return;
                        }
                        throw new Error(data.message || 'Network response was not ok');
                    });
                }
                return response.json();
            } else {
                throw new Error('Response is not JSON');
            }
        })
        .then(data => {
            if (!data) return;
            if (data.redirect) {
                window.location.href = data.redirect;
                return;
            }
            if (data.html) {
                document.getElementById('tableContainer').innerHTML = data.html;
            }
            if (data.pagination) {
                document.getElementById('paginationContainer').innerHTML = data.pagination;
            }
            document.getElementById('loadingOverlay').classList.remove('active');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('loadingOverlay').classList.remove('active');
            alert('Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại!');
        });
    }
});
</script>
@endpush

