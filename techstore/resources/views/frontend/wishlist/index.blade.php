@extends('frontend.layout')

@section('title', 'Sản phẩm yêu thích')

@section('content')
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li>Sản phẩm yêu thích</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--wishlist area start-->
<div class="wishlist_area mt-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page_title">
                    <h2>Sản phẩm yêu thích</h2>
                </div>
            </div>
        </div>
        
        @if($wishlists->count() > 0)
            <div class="row">
                @foreach($wishlists as $wishlist)
                    @php
                        $product = $wishlist->sanPham;
                        $primaryImage = $product->anhSanPhams->where('la_anh_chinh', 1)->first();
                        $minPrice = $product->bienThes->min('gia_ban');
                        $maxPrice = $product->bienThes->max('gia_ban');
                        $stock = $product->bienThes->sum('so_luong_ton');
                    @endphp
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="single_product">
                            <div class="product_thumb">
                                <a class="primary_img" href="{{ route('products.show', $product->id) }}">
                                    <img src="{{ $primaryImage ? asset('storage/' . $primaryImage->duong_dan) : asset('assets/img/product/product1.jpg') }}" alt="{{ $product->ten }}">
                                </a>
                                <div class="label_product">
                                    @if($stock == 0)
                                        <span class="label_sale">Hết hàng</span>
                                    @endif
                                </div>
                                <div class="action_links">
                                    <ul>
                                        <li class="wishlist">
                                            <a href="javascript:void(0)" 
                                               onclick="removeFromWishlist({{ $product->id }})" 
                                               title="Xóa khỏi yêu thích">
                                                <i class="fa fa-heart" style="color: #e74c3c;"></i>
                                            </a>
                                        </li>
                                        <li class="compare"><a href="#" title="So sánh"><i class="fa fa-random"></i></a></li>
                                        <li class="quick_button">
                                            <a href="{{ route('products.show', $product->id) }}" title="Xem chi tiết">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_content">
                                <div class="product_content_inner">
                                    <h4 class="product_name">
                                        <a href="{{ route('products.show', $product->id) }}">{{ $product->ten }}</a>
                                    </h4>
                                    <div class="price_box">
                                        @if($minPrice == $maxPrice)
                                            <span class="current_price">{{ number_format($minPrice) }} đ</span>
                                        @else
                                            <span class="current_price">{{ number_format($minPrice) }} đ - {{ number_format($maxPrice) }} đ</span>
                                        @endif
                                    </div>
                                    <div class="product_rating">
                                        @php
                                            $avgRating = $product->danhGias->where('trang_thai', 'approved')->avg('so_sao') ?? 0;
                                            $reviewCount = $product->danhGias->where('trang_thai', 'approved')->count();
                                        @endphp
                                        <ul>
                                            @for($i = 1; $i <= 5; $i++)
                                                <li><a href="#"><i class="fa fa-star{{ $i <= $avgRating ? '' : '-o' }}"></i></a></li>
                                            @endfor
                                        </ul>
                                        <span>({{ $reviewCount }} đánh giá)</span>
                                    </div>
                                </div>
                                <div class="add_to_cart">
                                    @if($stock > 0)
                                        <a href="{{ route('products.show', $product->id) }}" title="Xem chi tiết">Xem chi tiết</a>
                                    @else
                                        <a href="#" class="disabled" title="Hết hàng">Hết hàng</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($wishlists->hasPages())
                <div class="row">
                    <div class="col-12">
                        <div class="pagination_style shop_pagination">
                            {{ $wishlists->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="row">
                <div class="col-12">
                    <div class="empty_wishlist text-center">
                        <div class="empty_wishlist_icon">
                            <i class="fa fa-heart-o" style="font-size: 80px; color: #ddd; margin-bottom: 20px;"></i>
                        </div>
                        <h3>Danh sách yêu thích trống</h3>
                        <p>Bạn chưa có sản phẩm nào trong danh sách yêu thích.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Khám phá sản phẩm</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!--wishlist area end-->

<style>
.empty_wishlist {
    padding: 60px 0;
}

.empty_wishlist h3 {
    color: #333;
    margin-bottom: 15px;
}

.empty_wishlist p {
    color: #666;
    margin-bottom: 30px;
}

.btn-primary {
    background-color: #e74c3c;
    border-color: #e74c3c;
    padding: 12px 30px;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    display: inline-block;
    transition: all 0.3s;
}

.btn-primary:hover {
    background-color: #c0392b;
    border-color: #c0392b;
    color: white;
    text-decoration: none;
}

.single_product {
    margin-bottom: 30px;
    border: 1px solid #f0f0f0;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.single_product:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.action_links .wishlist a {
    transition: all 0.3s;
}

.action_links .wishlist a:hover {
    transform: scale(1.1);
}

.disabled {
    background-color: #ccc !important;
    cursor: not-allowed !important;
    pointer-events: none;
}

.page_title {
    text-align: center;
    margin-bottom: 40px;
}

.page_title h2 {
    color: #333;
    font-size: 2.5rem;
    font-weight: 600;
    position: relative;
    display: inline-block;
}

.page_title h2:after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background-color: #e74c3c;
}
</style>

<script>
function removeFromWishlist(productId) {
    if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi danh sách yêu thích?')) {
        return;
    }

    fetch('{{ route("wishlist.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload trang để cập nhật danh sách
            location.reload();
        } else {
            alert(data.message || 'Có lỗi xảy ra');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi xóa sản phẩm');
    });
}
</script>
@endsection