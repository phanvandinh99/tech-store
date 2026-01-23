@extends('frontend.layout')

@section('title', 'Chỉnh sửa đánh giá')

@section('content')
<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-edit"></i> Chỉnh sửa đánh giá</h4>
                </div>
                <div class="card-body">
                    <!-- Thông tin sản phẩm -->
                    <div class="product-info mb-4 p-3 bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                @if($danhGia->sanPham->anhSanPhams->first())
                                    <img src="{{ asset('storage/' . $danhGia->sanPham->anhSanPhams->first()->duong_dan) }}" 
                                         class="img-fluid rounded" alt="Product">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" 
                                         style="height: 100px;">
                                        <i class="fas fa-image fa-2x"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h5>{{ $danhGia->sanPham->ten }}</h5>
                                <p class="text-muted mb-1">
                                    <strong>Đơn hàng:</strong> {{ $danhGia->donHang->ma_don_hang }}
                                </p>
                                <p class="text-muted mb-0">
                                    <strong>Ngày mua:</strong> {{ $danhGia->donHang->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form chỉnh sửa -->
                    <form action="{{ route('reviews.update', $danhGia->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Đánh giá sao -->
                        <div class="mb-4">
                            <label class="form-label">Đánh giá của bạn <span class="text-danger">*</span></label>
                            <div class="star-rating">
                                <input type="radio" name="so_sao" value="5" id="star5" {{ old('so_sao', $danhGia->so_sao) == 5 ? 'checked' : '' }}>
                                <label for="star5" title="5 sao">★</label>
                                <input type="radio" name="so_sao" value="4" id="star4" {{ old('so_sao', $danhGia->so_sao) == 4 ? 'checked' : '' }}>
                                <label for="star4" title="4 sao">★</label>
                                <input type="radio" name="so_sao" value="3" id="star3" {{ old('so_sao', $danhGia->so_sao) == 3 ? 'checked' : '' }}>
                                <label for="star3" title="3 sao">★</label>
                                <input type="radio" name="so_sao" value="2" id="star2" {{ old('so_sao', $danhGia->so_sao) == 2 ? 'checked' : '' }}>
                                <label for="star2" title="2 sao">★</label>
                                <input type="radio" name="so_sao" value="1" id="star1" {{ old('so_sao', $danhGia->so_sao) == 1 ? 'checked' : '' }}>
                                <label for="star1" title="1 sao">★</label>
                            </div>
                            @error('so_sao')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nội dung đánh giá -->
                        <div class="mb-4">
                            <label for="noi_dung" class="form-label">Nhận xét của bạn <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('noi_dung') is-invalid @enderror" 
                                      id="noi_dung" name="noi_dung" rows="5" 
                                      placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này...">{{ old('noi_dung', $danhGia->noi_dung) }}</textarea>
                            @error('noi_dung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Tối thiểu 10 ký tự, tối đa 1000 ký tự</div>
                        </div>

                        <!-- Ảnh hiện tại -->
                        @if($danhGia->anhDanhGia->count() > 0)
                            <div class="mb-4">
                                <label class="form-label">Ảnh hiện tại</label>
                                <div class="row" id="currentImages">
                                    @foreach($danhGia->anhDanhGia as $anh)
                                        <div class="col-md-3 mb-3" id="image-{{ $anh->id }}">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $anh->duong_dan) }}" 
                                                     class="img-fluid rounded" alt="Review Image">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" 
                                                        onclick="deleteImage({{ $anh->id }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Upload ảnh mới -->
                        <div class="mb-4">
                            <label for="images" class="form-label">Thêm ảnh mới (tùy chọn)</label>
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                                   id="images" name="images[]" multiple accept="image/*">
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Có thể tải lên nhiều ảnh. Định dạng: JPG, PNG. Tối đa 2MB/ảnh</div>
                            
                            <!-- Preview ảnh mới -->
                            <div id="imagePreview" class="mt-3 d-flex flex-wrap gap-2"></div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('reviews.show', $danhGia->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật đánh giá
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 5px;
}

.star-rating input {
    display: none;
}

.star-rating label {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    color: #ffc107;
}

.image-preview {
    position: relative;
    display: inline-block;
}

.image-preview img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
}

.image-preview .remove-image {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    cursor: pointer;
}
</style>

<script>
// Preview ảnh mới
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    Array.from(e.target.files).forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'image-preview';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-image" onclick="removeNewImage(${index})">×</button>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
    });
});

// Xóa ảnh mới
function removeNewImage(index) {
    const input = document.getElementById('images');
    const dt = new DataTransfer();
    
    Array.from(input.files).forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    input.files = dt.files;
    input.dispatchEvent(new Event('change'));
}

// Xóa ảnh hiện tại
function deleteImage(imageId) {
    if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
        fetch(`/reviews/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`image-${imageId}`).remove();
            } else {
                alert('Có lỗi xảy ra khi xóa ảnh');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa ảnh');
        });
    }
}
</script>
@endsection