@extends('frontend.layout')

@section('title', 'Tạo yêu cầu bảo hành - Tech Store')

@push('styles')
<style>
    .warranty-form-container {
        padding: 2rem 0;
        min-height: 60vh;
    }
    .form-section {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .form-section h4 {
        margin: 0 0 1rem 0;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e0e0e0;
        color: #333;
    }
    .order-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid #e0e0e0;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    .order-item:hover {
        border-color: #c40316;
        background: #f8f9fa;
    }
    .order-item.selected {
        border-color: #c40316;
        background: #fff3f3;
    }
    .order-item input[type="radio"] {
        margin-top: 0.5rem;
    }
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.25rem;
        border: 1px solid #e0e0e0;
    }
    .product-details {
        flex: 1;
    }
    .product-details h5 {
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
        color: #333;
    }
    .product-details small {
        color: #666;
    }
    .image-preview {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    .image-preview-item {
        position: relative;
        width: 100px;
        height: 100px;
    }
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0.25rem;
        border: 1px solid #e0e0e0;
    }
    .image-preview-item .remove-btn {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
    }
</style>
@endpush

@section('content')
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li><a href="{{ route('warranty.index') }}">Yêu cầu bảo hành</a></li>
                        <li>Tạo yêu cầu mới</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--warranty form area start-->
<div class="warranty-form-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="mb-4">Tạo yêu cầu bảo hành</h2>

                <form action="{{ route('warranty.store') }}" method="POST" enctype="multipart/form-data" id="warrantyForm">
                    @csrf

                    <!-- Chọn đơn hàng -->
                    <div class="form-section">
                        <h4><i class="fa fa-shopping-cart"></i> Chọn đơn hàng</h4>
                        @if($orders->count() > 0)
                            <div class="mb-3">
                                <label class="form-label">Chọn đơn hàng đã hoàn thành</label>
                                <select class="form-select" name="order_select" id="orderSelect" onchange="loadOrderItems(this.value)">
                                    <option value="">-- Chọn đơn hàng --</option>
                                    @foreach($orders as $order)
                                        <option value="{{ $order->id }}" {{ $selectedOrder && $selectedOrder->id == $order->id ? 'selected' : '' }}>
                                            Đơn hàng #{{ $order->ma_don_hang }} - {{ $order->created_at->format('d/m/Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @if($selectedOrder)
                                <div id="orderItemsContainer">
                                    <label class="form-label mb-3">Chọn sản phẩm cần bảo hành</label>
                                    @foreach($orderItems as $item)
                                        <div class="order-item">
                                            <input type="radio" name="bien_the_id" value="{{ $item->bien_the_id }}" 
                                                   id="item_{{ $item->bien_the_id }}" required>
                                            <label for="item_{{ $item->bien_the_id }}" style="flex: 1; cursor: pointer;">
                                                @php
                                                    $primaryImage = $item->bienThe->sanPham->anhSanPhams->where('la_anh_chinh', 1)->first() 
                                                        ?? $item->bienThe->sanPham->anhSanPhams->first();
                                                    $imagePath = $primaryImage 
                                                        ? asset('storage/' . $primaryImage->url) 
                                                        : asset('assets/img/s-product/product.jpg');
                                                @endphp
                                                <div style="display: flex; gap: 1rem; align-items: center;">
                                                    <img src="{{ $imagePath }}" alt="{{ $item->bienThe->sanPham->ten }}" class="product-image">
                                                    <div class="product-details">
                                                        <h5>{{ $item->bienThe->sanPham->ten }}</h5>
                                                        <small>SKU: {{ $item->bienThe->sku }} | Số lượng: {{ $item->so_luong }}</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div id="orderItemsContainer" class="text-muted text-center py-4">
                                    Vui lòng chọn đơn hàng để xem danh sách sản phẩm
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle"></i> 
                                Bạn chưa có đơn hàng nào đã hoàn thành. Vui lòng mua sản phẩm và đợi đơn hàng hoàn thành trước khi yêu cầu bảo hành.
                            </div>
                        @endif
                    </div>

                    @if($orders->count() > 0)
                    <!-- Thông tin bảo hành -->
                    <div class="form-section">
                        <h4><i class="fa fa-info-circle"></i> Thông tin bảo hành</h4>
                        
                        <input type="hidden" name="donhang_id" id="donhang_id" value="{{ $selectedOrder ? $selectedOrder->id : '' }}" required>

                        <div class="mb-3">
                            <label class="form-label">Mô tả lỗi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('mo_ta_loi') is-invalid @enderror" 
                                      name="mo_ta_loi" rows="5" 
                                      placeholder="Vui lòng mô tả chi tiết lỗi của sản phẩm..." required>{{ old('mo_ta_loi') }}</textarea>
                            @error('mo_ta_loi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tối thiểu 10 ký tự, tối đa 2000 ký tự</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hình thức bảo hành <span class="text-danger">*</span></label>
                            <select class="form-select @error('hinh_thuc_bao_hanh') is-invalid @enderror" 
                                    name="hinh_thuc_bao_hanh" required>
                                <option value="">-- Chọn hình thức --</option>
                                <option value="sua_chua" {{ old('hinh_thuc_bao_hanh') == 'sua_chua' ? 'selected' : '' }}>Sửa chữa</option>
                                <option value="thay_the" {{ old('hinh_thuc_bao_hanh') == 'thay_the' ? 'selected' : '' }}>Thay thế</option>
                                <option value="doi_moi" {{ old('hinh_thuc_bao_hanh') == 'doi_moi' ? 'selected' : '' }}>Đổi mới</option>
                            </select>
                            @error('hinh_thuc_bao_hanh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hình ảnh minh chứng (tùy chọn)</label>
                            <input type="file" class="form-control" name="images[]" multiple accept="image/*" id="imageInput">
                            <small class="text-muted">Có thể upload nhiều ảnh (tối đa 2MB/ảnh, định dạng: jpeg, png, jpg, gif, webp)</small>
                            <div class="image-preview" id="imagePreview"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('warranty.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-paper-plane"></i> Gửi yêu cầu
                        </button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
<!--warranty form area end-->
@endsection

@push('scripts')
<script>
function loadOrderItems(orderId) {
    if (!orderId) {
        document.getElementById('orderItemsContainer').innerHTML = 
            '<div class="text-muted text-center py-4">Vui lòng chọn đơn hàng để xem danh sách sản phẩm</div>';
        document.getElementById('donhang_id').value = '';
        return;
    }

    document.getElementById('donhang_id').value = orderId;
    
    // Redirect để load lại trang với order_id
    window.location.href = '{{ route("warranty.create") }}?order_id=' + orderId;
}

// Preview images
document.getElementById('imageInput')?.addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    Array.from(e.target.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const item = document.createElement('div');
            item.className = 'image-preview-item';
            item.innerHTML = `
                <img src="${e.target.result}" alt="Preview ${index + 1}">
                <button type="button" class="remove-btn" onclick="removeImage(${index})">×</button>
            `;
            preview.appendChild(item);
        };
        reader.readAsDataURL(file);
    });
});

function removeImage(index) {
    const input = document.getElementById('imageInput');
    const dt = new DataTransfer();
    const files = Array.from(input.files);
    
    files.forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    input.files = dt.files;
    input.dispatchEvent(new Event('change'));
}
</script>
@endpush
