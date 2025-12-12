@extends('admin.layout')

@section('title', 'Tạo Phiếu nhập')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Tạo Phiếu nhập mới</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.phieunhap.store') }}" method="POST" id="phieuNhapForm">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="nha_cung_cap_id" class="form-label">Nhà cung cấp</label>
                            <div class="input-group">
                                <select class="form-select" id="nha_cung_cap_id" name="nha_cung_cap_id">
                                    <option value="">-- Chọn nhà cung cấp --</option>
                                    @foreach($nhaCungCaps as $ncc)
                                        <option value="{{ $ncc->id }}">{{ $ncc->ten }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addNhaCungCapModal">
                                    <i class="bi bi-plus"></i> Thêm mới
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="ghi_chu" class="form-label">Ghi chú</label>
                            <input type="text" class="form-control" id="ghi_chu" name="ghi_chu" placeholder="Ghi chú về phiếu nhập...">
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="bi bi-list-ul"></i> Chi tiết nhập hàng</h5>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addChiTiet()">
                            <i class="bi bi-plus"></i> Thêm sản phẩm
                        </button>
                    </div>

                    <div id="chiTietContainer">
                        <!-- Sẽ được thêm bằng JavaScript -->
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle"></i> <strong>Lưu ý:</strong> Khi tạo phiếu nhập, số lượng tồn kho và giá vốn sẽ được cập nhật tự động.
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.phieunhap.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Tạo phiếu nhập
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm nhà cung cấp -->
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

@push('scripts')
<script>
const sanPhams = @json($sanPhams->map(function($sp) {
    return [
        'id' => $sp->id,
        'ten' => $sp->ten,
        'danh_muc' => $sp->danhMuc->ten ?? '',
        'bien_thes' => $sp->bienThes->map(function($bt) {
            return [
                'id' => $bt->id,
                'sku' => $bt->sku,
                'gia' => $bt->gia,
                'so_luong_ton' => $bt->so_luong_ton
            ];
        })->toArray()
    ];
})->toArray());

let chiTietIndex = 0;

function addChiTiet() {
    const container = document.getElementById('chiTietContainer');
    const item = document.createElement('div');
    item.className = 'card mb-3 chi-tiet-item';
    item.innerHTML = `
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <strong>Sản phẩm ${chiTietIndex + 1}</strong>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeChiTiet(this)">
                    <i class="bi bi-trash"></i> Xóa
                </button>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                    <select class="form-select sanpham-select" name="chi_tiet[${chiTietIndex}][sanpham_id]" onchange="updateBienTheOptions(this, ${chiTietIndex})" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        ${sanPhams.map(sp => 
                            `<option value="${sp.id}">${sp.ten} (${sp.danh_muc})</option>`
                        ).join('')}
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Biến thể (SKU) <span class="text-danger">*</span></label>
                    <select class="form-select bienthe-select" name="chi_tiet[${chiTietIndex}][bien_the_id]" id="bienthe_${chiTietIndex}" required>
                        <option value="">-- Chọn sản phẩm trước --</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Số lượng nhập <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="chi_tiet[${chiTietIndex}][so_luong_nhap]" min="1" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Giá vốn nhập (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="chi_tiet[${chiTietIndex}][gia_von_nhap]" min="0" step="1000" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tồn kho hiện tại</label>
                    <input type="text" class="form-control" id="tonkho_${chiTietIndex}" readonly style="background-color: #f8f9fa;">
                </div>
            </div>
        </div>
    `;
    container.appendChild(item);
    chiTietIndex++;
}

function updateBienTheOptions(select, index) {
    const sanphamId = select.value;
    const bientheSelect = document.getElementById(`bienthe_${index}`);
    const tonkhoInput = document.getElementById(`tonkho_${index}`);
    
    bientheSelect.innerHTML = '<option value="">-- Chọn biến thể --</option>';
    tonkhoInput.value = '';
    
    if (sanphamId) {
        const sanpham = sanPhams.find(sp => sp.id == parseInt(sanphamId));
        if (sanpham && sanpham.bien_thes && sanpham.bien_thes.length > 0) {
            sanpham.bien_thes.forEach(bt => {
                const option = document.createElement('option');
                option.value = bt.id;
                option.textContent = `${bt.sku} (Tồn: ${bt.so_luong_ton})`;
                option.dataset.tonkho = bt.so_luong_ton;
                bientheSelect.appendChild(option);
            });
        } else {
            bientheSelect.innerHTML = '<option value="">Sản phẩm này chưa có biến thể</option>';
        }
    }
    
    // Update tồn kho khi chọn biến thể
    bientheSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.tonkho) {
            tonkhoInput.value = selectedOption.dataset.tonkho;
        } else {
            tonkhoInput.value = '';
        }
    });
}

function removeChiTiet(btn) {
    if (document.querySelectorAll('.chi-tiet-item').length > 0) {
        btn.closest('.chi-tiet-item').remove();
    }
}

// Thêm nhà cung cấp
document.getElementById('addNhaCungCapForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route('admin.nhacungcap.store') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload để load nhà cung cấp mới
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra!');
    });
});

// Thêm chi tiết đầu tiên
addChiTiet();
</script>
@endpush
@endsection

