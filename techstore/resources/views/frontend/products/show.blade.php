@extends('frontend.layout')

@section('title', $product->ten . ' - Tech Store')

@push('styles')
<style>
    .product-details-tab {
        margin-bottom: 2rem;
    }
    .zoomWrapper {
        margin-bottom: 1rem;
    }
    .zoomWrapper {
        max-width: 100%;
        margin: 0 auto;
    }
    .zoomWrapper img {
        width: 100%;
        max-width: 400px;
        height: auto;
        margin: 0 auto;
        display: block;
    }
    .single-zoom-thumb ul {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .single-zoom-thumb li {
        flex: 0 0 auto;
    }
    .single-zoom-thumb img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.3s;
    }
    .single-zoom-thumb img:hover,
    .single-zoom-thumb .active img {
        border-color: #007bff;
    }
    .product_d_right h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    .product_nav ul {
        list-style: none;
        padding: 0;
        margin: 0 0 1rem 0;
        display: flex;
        gap: 0.5rem;
    }
    .product_nav a {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        color: #333;
        text-decoration: none;
    }
    .product_nav a:hover {
        background: #f8f9fa;
    }
    .product_rating ul {
        list-style: none;
        padding: 0;
        margin: 0 0 1rem 0;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .product_rating li a {
        color: #ffc107;
    }
    .product_variant {
        margin-bottom: 1.5rem;
    }
    .product_variant h3 {
        font-size: 1rem;
        margin-bottom: 0.75rem;
    }
    .product_variant label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .product_variant.color ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 0.5rem;
    }
    .product_variant.color ul li {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid #ddd;
        cursor: pointer;
        transition: all 0.3s;
    }
    .product_variant.color ul li:hover,
    .product_variant.color ul li.active {
        border-color: #007bff;
        transform: scale(1.1);
    }
    .product_variant.quantity {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .product_variant.quantity input {
        width: 80px;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
    }
    .product_variant.quantity .button {
        padding: 0.75rem 2rem;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 0.25rem;
        cursor: pointer;
        font-weight: 600;
        text-transform: uppercase;
    }
    .product_variant.quantity .button:hover {
        background: #0056b3;
    }
    .product_variant.quantity .button:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    .product_d_action ul {
        list-style: none;
        padding: 0;
        margin: 1rem 0;
        display: flex;
        gap: 1rem;
    }
    .product_d_action a {
        color: #333;
        text-decoration: none;
    }
    .product_d_action a:hover {
        color: #007bff;
    }
    .product_meta {
        margin: 1rem 0;
        padding: 1rem 0;
        border-top: 1px solid #eee;
    }
    .priduct_social ul {
        list-style: none;
        padding: 0;
        margin: 1rem 0 0 0;
        display: flex;
        gap: 0.5rem;
    }
    .priduct_social a {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        text-decoration: none;
        font-size: 0.875rem;
    }
    .priduct_social .facebook { background: #3b5998; }
    .priduct_social .twitter { background: #1da1f2; }
    .priduct_social .pinterest { background: #bd081c; }
    .priduct_social .google-plus { background: #dd4b39; }
    .priduct_social .linkedin { background: #0077b5; }
    .variant-option {
        display: inline-block;
        margin: 0.25rem;
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    .variant-option:hover {
        border-color: #007bff;
    }
    .variant-option.selected {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }
    .variant-option.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .variant-info-box {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 0.25rem;
        margin: 1rem 0;
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
                        <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                        <li>{{ $product->ten }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<div class="product_page_bg">
    <div class="container">
        <div class="product_details_wrapper mb-55">
            <!--product details start-->
            <div class="product_details">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="product-details-tab">
                            @php
                                $images = $product->anhSanPhams;
                                $primaryImage = $images->where('la_anh_chinh', true)->first() ?? $images->first();
                                $primaryUrl = $primaryImage ? asset('storage/' . $primaryImage->url) : asset('assets/img/product/product1.jpg');
                            @endphp
                            <div id="img-1" class="zoomWrapper single-zoom">
                                <a href="#">
                                    <img id="zoom1" src="{{ $primaryUrl }}" alt="{{ $product->ten }}">
                                </a>
                            </div>
                            @if($images->count() > 1)
                            <div class="single-zoom-thumb">
                                <ul class="s-tab-zoom" id="gallery_01">
                                    @foreach($images as $image)
                                    <li>
                                        <a href="#" class="elevatezoom-gallery {{ $loop->first ? 'active' : '' }}" 
                                           data-image="{{ asset('storage/' . $image->url) }}" 
                                           onclick="changeMainImage('{{ asset('storage/' . $image->url) }}', this); return false;">
                                            <img src="{{ asset('storage/' . $image->url) }}" alt="{{ $product->ten }}" />
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6">
                        <div class="product_d_right">
                            <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="variant_id" id="selected_variant_id" required>
                                <input type="hidden" name="product_name" value="{{ $product->ten }}">
                                <input type="hidden" name="price" id="selected_price">
                                <input type="hidden" name="image" id="selected_image" value="{{ $primaryUrl }}">

                                <h3><a href="#">{{ $product->ten }}</a></h3>
                                
                                <div class="product_rating">
                                    <ul>
                                        <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                        <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                    </ul>
                                </div>

                                <div class="price_box">
                                    @if($product->bienThes->count() > 0)
                                        @php
                                            $minPrice = $product->bienThes->min('gia');
                                            $maxPrice = $product->bienThes->max('gia');
                                        @endphp
                                        @if($minPrice == $maxPrice)
                                            <span class="current_price">{{ number_format($minPrice) }} đ</span>
                                        @else
                                            <span class="old_price">{{ number_format($maxPrice) }} đ</span>
                                            <span class="current_price">{{ number_format($minPrice) }} đ</span>
                                        @endif
                                    @else
                                        <span class="current_price">Liên hệ</span>
                                    @endif
                                </div>

                                @if($product->mo_ta_ngan)
                                <div class="product_desc">
                                    <p>{{ $product->mo_ta_ngan }}</p>
                                </div>
                                @endif

                                <!-- Variant Selection -->
                                @if($product->bienThes->count() > 0)
                                    @if($product->thuocTinhs->count() > 0)
                                        <div class="product_variant">
                                            <h3>Tùy chọn có sẵn</h3>
                                            @foreach($product->thuocTinhs as $thuocTinh)
                                            <div class="mb-3">
                                                <label>{{ $thuocTinh->ten }}</label>
                                                <div class="variant-options">
                                                    @foreach($thuocTinh->giaTriThuocTinhs as $giaTri)
                                                        @php
                                                            $hasVariant = $product->bienThes->filter(function($bt) use ($giaTri) {
                                                                return $bt->giaTriThuocTinhs->contains($giaTri->id);
                                                            })->count() > 0;
                                                        @endphp
                                                        <span class="variant-option {{ !$hasVariant ? 'disabled' : '' }}" 
                                                              data-attribute="{{ $thuocTinh->id }}" 
                                                              data-value="{{ $giaTri->id }}"
                                                              onclick="selectVariantOption(this, {{ $thuocTinh->id }}, {{ $giaTri->id }})">
                                                            {{ $giaTri->giatri }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Variant Info Display -->
                                    <div id="variantInfo" class="variant-info-box" style="display: none;">
                                        <div>
                                            <strong>SKU:</strong> <span id="variant_sku"></span><br>
                                            <strong>Giá:</strong> <span id="variant_price"></span><br>
                                            <strong>Tồn kho:</strong> <span id="variant_stock"></span>
                                        </div>
                                    </div>

                                    <div class="product_variant quantity">
                                        <label>Số lượng</label>
                                        <input type="number" name="quantity" id="product_quantity" value="1" min="1" class="form-control" required>
                                        <button type="submit" class="button" id="addToCartBtn" disabled>Thêm vào giỏ hàng</button>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        Sản phẩm này hiện chưa có biến thể. Vui lòng liên hệ để đặt hàng.
                                    </div>
                                @endif

                                <div class="product_d_action">
                                    <ul>
                                        <li><a href="#" title="Thêm vào yêu thích">+ Thêm vào Yêu thích</a></li>
                                        <li><a href="#" title="So sánh">+ So sánh</a></li>
                                    </ul>
                                </div>

                                <div class="product_meta">
                                    <span>Danh mục: <a href="{{ route('products.index', ['category' => $product->danhmuc_id]) }}">{{ $product->danhMuc->ten }}</a></span>
                                </div>
                            </form>

                            <div class="priduct_social">
                                <ul>
                                    <li><a class="facebook" href="#" title="facebook"><i class="fa fa-facebook"></i> Like</a></li>
                                    <li><a class="twitter" href="#" title="twitter"><i class="fa fa-twitter"></i> tweet</a></li>
                                    <li><a class="pinterest" href="#" title="pinterest"><i class="fa fa-pinterest"></i> save</a></li>
                                    <li><a class="google-plus" href="#" title="google +"><i class="fa fa-google-plus"></i> share</a></li>
                                    <li><a class="linkedin" href="#" title="linkedin"><i class="fa fa-linkedin"></i> linked</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--product details end-->

            <!--product info start-->
            <div class="product_d_info">
                <div class="row">
                    <div class="col-12">
                        <div class="product_d_inner">
                            <div class="product_info_button">
                                <ul class="nav nav-tabs" role="tablist" id="nav-tab">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">Mô tả</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">Thông số kỹ thuật</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="info" role="tabpanel">
                                    <div class="product_info_content">
                                        @if($product->mo_ta_chi_tiet)
                                            <div style="white-space: pre-wrap; line-height: 1.8;">{{ $product->mo_ta_chi_tiet }}</div>
                                        @elseif($product->mo_ta_ngan)
                                            <p>{{ $product->mo_ta_ngan }}</p>
                                        @else
                                            <p>Không có mô tả cho sản phẩm này.</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sheet" role="tabpanel">
                                    <div class="product_d_table">
                                        <table class="table">
                                            <tbody>
                                                @if($product->thuocTinhs->count() > 0)
                                                    @foreach($product->thuocTinhs as $thuocTinh)
                                                    <tr>
                                                        <td class="first_child"><strong>{{ $thuocTinh->ten }}</strong></td>
                                                        <td>
                                                            @foreach($thuocTinh->giaTriThuocTinhs as $giaTri)
                                                                {{ $giaTri->giatri }}{{ !$loop->last ? ', ' : '' }}
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="2">Không có thông số kỹ thuật.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--product info end-->
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <section class="product_area related_products">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <h2>Sản phẩm liên quan</h2>
                    </div>
                </div>
            </div>
            <div class="product_carousel product_style product_column5 owl-carousel">
                @foreach($relatedProducts as $relatedProduct)
                <article class="single_product">
                    <figure>
                        <div class="product_thumb">
                            @php
                                $images = $relatedProduct->anhSanPhams;
                                $primaryImage = $images->where('la_anh_chinh', true)->first() ?? $images->first();
                                $secondaryImage = $images->where('la_anh_chinh', false)->first();
                                $primaryUrl = $primaryImage ? asset('storage/' . $primaryImage->url) : asset('assets/img/product/product1.jpg');
                                $secondaryUrl = $secondaryImage ? asset('storage/' . $secondaryImage->url) : $primaryUrl;
                            @endphp
                            <a class="primary_img" href="{{ route('products.show', $relatedProduct->id) }}">
                                <img src="{{ $primaryUrl }}" alt="{{ $relatedProduct->ten }}">
                            </a>
                            @if($secondaryImage)
                            <a class="secondary_img" href="{{ route('products.show', $relatedProduct->id) }}">
                                <img src="{{ $secondaryUrl }}" alt="{{ $relatedProduct->ten }}">
                            </a>
                            @endif
                            <div class="action_links">
                                <ul>
                                    <li class="wishlist"><a href="#" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-tippy="Thêm vào yêu thích"><i class="ion-android-favorite-outline"></i></a></li>
                                    <li class="compare"><a href="#" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-tippy="So sánh"><i class="ion-ios-settings-strong"></i></a></li>
                                    <li class="quick_button"><a href="{{ route('products.show', $relatedProduct->id) }}" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-tippy="Xem nhanh"><i class="ion-ios-search-strong"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product_content">
                            <div class="product_content_inner">
                                <h4 class="product_name"><a href="{{ route('products.show', $relatedProduct->id) }}">{{ $relatedProduct->ten }}</a></h4>
                                <div class="price_box">
                                    @if($relatedProduct->bienThes->count() > 0)
                                        @php
                                            $minPrice = $relatedProduct->bienThes->min('gia');
                                            $maxPrice = $relatedProduct->bienThes->max('gia');
                                        @endphp
                                        @if($minPrice == $maxPrice)
                                            <span class="current_price">{{ number_format($minPrice) }} đ</span>
                                        @else
                                            <span class="old_price">{{ number_format($maxPrice) }} đ</span>
                                            <span class="current_price">{{ number_format($minPrice) }} đ</span>
                                        @endif
                                    @else
                                        <span class="current_price">Liên hệ</span>
                                    @endif
                                </div>
                            </div>
                            <div class="add_to_cart">
                                <a href="{{ route('products.show', $relatedProduct->id) }}" title="Thêm vào giỏ hàng">Thêm vào giỏ hàng</a>
                            </div>
                        </div>
                    </figure>
                </article>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>

@push('scripts')
<script>
const variants = @json($variants);

let selectedAttributes = {};

function changeMainImage(url, element) {
    document.getElementById('zoom1').src = url;
    document.getElementById('selected_image').value = url;
    document.querySelectorAll('.elevatezoom-gallery').forEach(thumb => thumb.classList.remove('active'));
    element.classList.add('active');
}

function selectVariantOption(element, attributeId, valueId) {
    if (element.classList.contains('disabled')) return;
    
    // Toggle selection
    const siblings = element.parentElement.querySelectorAll('.variant-option');
    siblings.forEach(opt => {
        if (opt.dataset.attribute == attributeId) {
            opt.classList.remove('selected');
        }
    });
    element.classList.add('selected');
    
    selectedAttributes[attributeId] = valueId;
    updateVariantSelection();
}

function updateVariantSelection() {
    const selectedValues = Object.values(selectedAttributes).map(v => parseInt(v));
    
    // Find matching variant
    const matchingVariant = variants.find(variant => {
        const variantGiatriIds = variant.giatri_ids.map(id => parseInt(id));
        return selectedValues.length === variantGiatriIds.length &&
               selectedValues.every(valId => variantGiatriIds.includes(valId)) &&
               variantGiatriIds.every(vId => selectedValues.includes(vId));
    });
    
    if (matchingVariant) {
        document.getElementById('selected_variant_id').value = matchingVariant.id;
        document.getElementById('selected_price').value = matchingVariant.gia;
        document.getElementById('variant_sku').textContent = matchingVariant.sku;
        document.getElementById('variant_price').textContent = new Intl.NumberFormat('vi-VN').format(matchingVariant.gia) + ' đ';
        
        const stockText = matchingVariant.so_luong_ton > 0 
            ? matchingVariant.so_luong_ton 
            : '<span class="text-danger">Hết hàng</span>';
        document.getElementById('variant_stock').innerHTML = stockText;
        
        document.getElementById('variantInfo').style.display = 'block';
        document.getElementById('addToCartBtn').disabled = matchingVariant.so_luong_ton <= 0;
        document.getElementById('product_quantity').max = matchingVariant.so_luong_ton;
        
        // Reset quantity if it exceeds stock
        const quantityInput = document.getElementById('product_quantity');
        if (parseInt(quantityInput.value) > matchingVariant.so_luong_ton) {
            quantityInput.value = matchingVariant.so_luong_ton > 0 ? matchingVariant.so_luong_ton : 1;
        }
    } else {
        document.getElementById('variantInfo').style.display = 'none';
        document.getElementById('addToCartBtn').disabled = true;
    }
}

// Auto-select first variant when page loads
document.addEventListener('DOMContentLoaded', function() {
    if (variants.length > 0) {
        // Check if product has attributes
        const hasAttributes = document.querySelectorAll('.variant-options').length > 0;
        
        if (hasAttributes) {
            // Auto-select first available option for each attribute
            const attributeGroups = {};
            document.querySelectorAll('.variant-option:not(.disabled)').forEach(option => {
                const attrId = option.dataset.attribute;
                if (!attributeGroups[attrId]) {
                    attributeGroups[attrId] = option;
                    // Manually trigger selection
                    const attrIdNum = parseInt(attrId);
                    const valueIdNum = parseInt(option.dataset.value);
                    selectVariantOption(option, attrIdNum, valueIdNum);
                }
            });
        } else {
            // No attributes, just select first variant directly
            const firstVariant = variants[0];
            document.getElementById('selected_variant_id').value = firstVariant.id;
            document.getElementById('selected_price').value = firstVariant.gia;
            document.getElementById('variant_sku').textContent = firstVariant.sku;
            document.getElementById('variant_price').textContent = new Intl.NumberFormat('vi-VN').format(firstVariant.gia) + ' đ';
            document.getElementById('variant_stock').textContent = firstVariant.so_luong_ton;
            document.getElementById('variantInfo').style.display = 'block';
            document.getElementById('addToCartBtn').disabled = firstVariant.so_luong_ton <= 0;
            document.getElementById('product_quantity').max = firstVariant.so_luong_ton;
            
            if (firstVariant.so_luong_ton <= 0) {
                document.getElementById('variant_stock').innerHTML = '<span class="text-danger">Hết hàng</span>';
            }
        }
    }
});
</script>
@endpush
@endsection
