@extends('admin.layout')

@section('title', 'Sửa Sản phẩm')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Sửa Sản phẩm: {{ $sanPham->ten }}</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                            <i class="bi bi-info-circle"></i> Thông tin cơ bản
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab">
                            <i class="bi bi-images"></i> Quản lý ảnh
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="variants-tab" data-bs-toggle="tab" data-bs-target="#variants" type="button" role="tab">
                            <i class="bi bi-box-seam"></i> Biến thể
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="productTabsContent">
                    <!-- Tab Thông tin cơ bản -->
                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
                        <form action="{{ route('admin.sanpham.update', $sanPham->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ten" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('ten') is-invalid @enderror" 
                                           id="ten" name="ten" value="{{ old('ten', $sanPham->ten) }}" required>
                                    @error('ten')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="danhmuc_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select class="form-select @error('danhmuc_id') is-invalid @enderror" 
                                            id="danhmuc_id" name="danhmuc_id" required>
                                        @foreach($danhMucs as $danhMuc)
                                            <option value="{{ $danhMuc->id }}" 
                                                {{ old('danhmuc_id', $sanPham->danhmuc_id) == $danhMuc->id ? 'selected' : '' }}>
                                                {{ $danhMuc->ten }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('danhmuc_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="mota" class="form-label">Mô tả</label>
                                <textarea class="form-control @error('mota') is-invalid @enderror" 
                                          id="mota" name="mota" rows="4">{{ old('mota', $sanPham->mo_ta_chi_tiet) }}</textarea>
                                @error('mota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Thuộc tính -->
                            <div class="mb-3">
                                <label class="form-label">Thuộc tính sản phẩm</label>
                                <div class="row">
                                    @foreach($thuocTinhs as $thuocTinh)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="thuoc_tinh_ids[]" 
                                                   value="{{ $thuocTinh->id }}"
                                                   id="thuoc_tinh_{{ $thuocTinh->id }}"
                                                   {{ in_array($thuocTinh->id, $sanPham->thuocTinhs->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="thuoc_tinh_{{ $thuocTinh->id }}">
                                                <strong>{{ $thuocTinh->ten }}</strong>
                                            </label>
                                        </div>
                                        <div class="ms-4">
                                            @foreach($thuocTinh->giaTriThuocTinhs as $giaTri)
                                                <small class="d-block text-muted">- {{ $giaTri->giatri }}</small>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.sanpham.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Cập nhật
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab Quản lý ảnh -->
                    <div class="tab-pane fade" id="images" role="tabpanel">
                        <div class="mb-3">
                            <h5>Thêm ảnh mới</h5>
                            <form action="{{ route('admin.sanpham.addImages', $sanPham->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Chọn ảnh</label>
                                        <input type="file" class="form-control" name="images[]" multiple accept="image/*" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Gán cho biến thể (tùy chọn)</label>
                                        <select class="form-select" name="bien_the_id">
                                            <option value="">Ảnh chung của sản phẩm</option>
                                            @foreach($sanPham->bienThes as $bienThe)
                                                <option value="{{ $bienThe->id }}">SKU: {{ $bienThe->sku }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-upload"></i> Upload
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <hr>

                        <h5>Ảnh hiện có</h5>
                        <div class="row">
                            @foreach($sanPham->anhSanPhams as $anh)
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <img src="{{ asset('storage/' . $anh->duong_dan) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if($anh->la_anh_chinh)
                                                <span class="badge bg-primary">Ảnh chính</span>
                                            @else
                                                <button class="btn btn-sm btn-outline-primary" onclick="setPrimaryImage({{ $anh->id }})">
                                                    <i class="bi bi-star"></i> Đặt làm ảnh chính
                                                </button>
                                            @endif
                                            <button class="btn btn-sm btn-danger" onclick="deleteImage({{ $anh->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        @if($anh->bienThe)
                                            <small class="text-muted d-block mt-2">Biến thể: {{ $anh->bienThe->sku }}</small>
                                        @else
                                            <small class="text-muted d-block mt-2">Ảnh chung</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tab Biến thể -->
                    <div class="tab-pane fade" id="variants" role="tabpanel">
                        <div class="mb-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                                <i class="bi bi-plus-circle"></i> Thêm biến thể mới
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Giá trị thuộc tính</th>
                                        <th>Giá bán</th>
                                        <th>Giá vốn</th>
                                        <th>Số lượng tồn</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sanPham->bienThes as $bienThe)
                                    <tr id="variant-row-{{ $bienThe->id }}">
                                        <td><strong>{{ $bienThe->sku }}</strong></td>
                                        <td>
                                            @if($bienThe->giaTriThuocTinhs->count() > 0)
                                                @foreach($bienThe->giaTriThuocTinhs as $giaTri)
                                                    <span class="badge bg-secondary">{{ $giaTri->thuocTinh->ten }}: {{ $giaTri->giatri }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">Không có</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($bienThe->gia) }} đ</td>
                                        <td>{{ number_format($bienThe->gia_von) }} đ</td>
                                        <td>{{ $bienThe->so_luong_ton }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="editVariant({{ $bienThe->id }}, {{ json_encode([
                                                'sku' => $bienThe->sku,
                                                'gia' => $bienThe->gia,
                                                'gia_von' => $bienThe->gia_von,
                                                'so_luong_ton' => $bienThe->so_luong_ton,
                                                'giatri_ids' => $bienThe->giaTriThuocTinhs->pluck('id')->toArray()
                                            ]) }})">
                                                <i class="bi bi-pencil"></i> Sửa
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteVariant({{ $sanPham->id }}, {{ $bienThe->id }})">
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm biến thể -->
<div class="modal fade" id="addVariantModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm biến thể mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.sanpham.addVariant', $sanPham->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="sku" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="gia" min="0" step="1000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá vốn (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="gia_von" min="0" step="1000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số lượng tồn</label>
                            <input type="number" class="form-control" value="0" readonly>
                            <small class="text-muted">Số lượng tồn sẽ được cập nhật thông qua phiếu nhập hàng</small>
                            <input type="hidden" name="so_luong_ton" value="0">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Giá trị thuộc tính</label>
                            <div class="row">
                                @foreach($thuocTinhs as $thuocTinh)
                                    @if(!($isDienThoai && $kichThuocManHinhId && $thuocTinh->id == $kichThuocManHinhId))
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label small"><strong>{{ $thuocTinh->ten }}</strong></label>
                                        <select class="form-select form-select-sm" name="giatri_thuoctinh_ids[]">
                                            <option value="">-- Chọn --</option>
                                            @foreach($thuocTinh->giaTriThuocTinhs as $giaTri)
                                                <option value="{{ $giaTri->id }}">{{ $giaTri->giatri }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Ảnh cho biến thể (tùy chọn)</label>
                            <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                        </div>
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

<!-- Modal Sửa biến thể -->
<div class="modal fade" id="editVariantModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa biến thể</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editVariantForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="sku" id="edit_sku" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="gia" id="edit_gia" min="0" step="1000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá vốn (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="gia_von" id="edit_gia_von" min="0" step="1000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số lượng tồn</label>
                            <input type="number" class="form-control" id="edit_so_luong_ton_display" readonly>
                            <small class="text-muted">Số lượng tồn chỉ được cập nhật thông qua phiếu nhập hàng</small>
                            <input type="hidden" name="so_luong_ton" id="edit_so_luong_ton" value="">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Giá trị thuộc tính</label>
                            <div class="row" id="edit_giatri_container">
                                <!-- Sẽ được populate bằng JavaScript -->
                            </div>
                        </div>
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
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteImage(id) {
    if (!confirm('Bạn có chắc chắn muốn xóa ảnh này?')) return;
    
    fetch(`/admin/sanpham/images/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Có lỗi xảy ra!');
        }
    });
}

function setPrimaryImage(id) {
    fetch(`/admin/sanpham/images/${id}/primary`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Có lỗi xảy ra!');
        }
    });
}

const thuocTinhs = @json($thuocTinhs->mapWithKeys(function($tt) {
    return [$tt->id => [
        'ten' => $tt->ten,
        'giatri' => $tt->giaTriThuocTinhs->mapWithKeys(function($gt) {
            return [$gt->id => $gt->giatri];
        })
    ]];
}));
const kichThuocManHinhId = {{ $kichThuocManHinhId ?? 'null' }};
const isDienThoai = {{ $isDienThoai ? 'true' : 'false' }};

function editVariant(id, variant) {
    const modal = new bootstrap.Modal(document.getElementById('editVariantModal'));
    const form = document.getElementById('editVariantForm');
    const variantData = typeof variant === 'string' ? JSON.parse(variant) : variant;
    
    // Set form action
    form.action = `/admin/sanpham/{{ $sanPham->id }}/variants/${id}`;
    
    // Fill form data
    document.getElementById('edit_sku').value = variantData.sku;
    document.getElementById('edit_gia').value = variantData.gia;
    document.getElementById('edit_gia_von').value = variantData.gia_von;
    document.getElementById('edit_so_luong_ton_display').value = variantData.so_luong_ton;
    document.getElementById('edit_so_luong_ton').value = variantData.so_luong_ton;
    
    // Populate giá trị thuộc tính
    const container = document.getElementById('edit_giatri_container');
    container.innerHTML = '';
    const selectedGiatriIds = variantData.giatri_ids || [];
    
    Object.entries(thuocTinhs).forEach(([ttId, ttData]) => {
        const thuocTinhIdNum = parseInt(ttId);
        
        // Bỏ qua thuộc tính "Kích thước màn hình" nếu là điện thoại
        if (isDienThoai && kichThuocManHinhId && thuocTinhIdNum === kichThuocManHinhId) {
            return;
        }
        
        const col = document.createElement('div');
        col.className = 'col-md-6 mb-2';
        col.innerHTML = `
            <label class="form-label small"><strong>${ttData.ten}</strong></label>
            <select class="form-select form-select-sm" name="giatri_thuoctinh_ids[]">
                <option value="">-- Chọn --</option>
                ${Object.entries(ttData.giatri).map(([gtId, gtValue]) => 
                    `<option value="${gtId}" ${selectedGiatriIds.includes(parseInt(gtId)) ? 'selected' : ''}>${gtValue}</option>`
                ).join('')}
            </select>
        `;
        container.appendChild(col);
    });
    
    modal.show();
}

function deleteVariant(sanphamId, variantId) {
    if (!confirm('Bạn có chắc chắn muốn xóa biến thể này? Hành động này không thể hoàn tác!')) return;
    
    fetch(`/admin/sanpham/${sanphamId}/variants/${variantId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json().catch(() => ({ success: true }));
        }
        throw new Error('Network response was not ok');
    })
    .then(data => {
        if (data.success) {
            document.getElementById(`variant-row-${variantId}`)?.remove();
            location.reload();
        } else {
            alert('Có lỗi xảy ra!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        location.reload();
    });
}
</script>
@endpush
@endsection
