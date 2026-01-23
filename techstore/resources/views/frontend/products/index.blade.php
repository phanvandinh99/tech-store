@extends('frontend.layout')

@section('title', 'Sản phẩm - Tech Store')

@push('styles')
<style>
    .product-filter-bar {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
    }
    .filter-group {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }
    .filter-group select {
        min-width: 200px;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
    }
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }
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
                        <li>Sản phẩm</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--product area start-->
<div class="product_area mb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product_header">
                    <div class="section_title">
                        <h2>Tất cả sản phẩm</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="product-filter-bar">
            <form method="GET" action="{{ route('products.index') }}" class="filter-group">
                <select name="category" class="form-select">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->ten }}
                        </option>
                    @endforeach
                </select>
                <select name="sort" class="form-select">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                </select>
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <button type="submit" class="btn btn-primary">Lọc</button>
                @if(request('category') || request('sort') || request('search'))
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Xóa bộ lọc</a>
                @endif
            </form>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <article class="single_product">
                    <figure>
                        <div class="product_thumb">
                            @php
                                $images = $product->anhSanPhams;
                                $primaryImage = $images->where('la_anh_chinh', true)->first() ?? $images->first();
                                $secondaryImage = $images->where('la_anh_chinh', false)->first();
                                $primaryUrl = $primaryImage ? asset('storage/' . $primaryImage->url) : asset('assets/img/product/product1.jpg');
                                $secondaryUrl = $secondaryImage ? asset('storage/' . $secondaryImage->url) : $primaryUrl;
                            @endphp
                            <a class="primary_img" href="{{ route('products.show', $product->id) }}">
                                <img src="{{ $primaryUrl }}" alt="{{ $product->ten }}">
                            </a>
                            @if($secondaryImage)
                            <a class="secondary_img" href="{{ route('products.show', $product->id) }}">
                                <img src="{{ $secondaryUrl }}" alt="{{ $product->ten }}">
                            </a>
                            @endif
                            @if($product->bienThes->count() > 0)
                                @php
                                    $minPrice = $product->bienThes->min('gia');
                                    $maxPrice = $product->bienThes->max('gia');
                                @endphp
                                @if($minPrice < $maxPrice)
                                <div class="label_product">
                                    <span class="label_sale">Giảm giá</span>
                                </div>
                                @endif
                            @endif
                            <div class="action_links">
                                <ul>
                                    <li class="wishlist"><a href="#" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-tippy="Thêm vào yêu thích"><i class="fa fa-heart-o"></i></a></li>
                                    <li class="compare"><a href="#" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-tippy="So sánh"><i class="fa fa-exchange"></i></a></li>
                                    <li class="quick_button"><a href="{{ route('products.show', $product->id) }}" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-tippy="Xem nhanh"><i class="fa fa-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product_content">
                            <div class="product_content_inner">
                                <h4 class="product_name"><a href="{{ route('products.show', $product->id) }}">{{ $product->ten }}</a></h4>
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
                            </div>
                            <div class="add_to_cart">
                                <a href="{{ route('products.show', $product->id) }}" title="Thêm vào giỏ hàng">Thêm vào giỏ hàng</a>
                            </div>
                        </div>
                    </figure>
                </article>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                <div class="pagination_area">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                    <p class="mt-3 text-muted">Không tìm thấy sản phẩm nào</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Xem tất cả sản phẩm</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!--product area end-->

@push('scripts')
<script>
// Wishlist functionality for product listing
document.addEventListener('DOMContentLoaded', function() {
    // Handle wishlist button clicks
    document.querySelectorAll('.add-to-wishlist').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            toggleWishlistFromListing(productId, this);
        });
    });

    // Check wishlist status for all products
    @auth('customer')
    checkWishlistStatus();
    @endauth
});

function toggleWishlistFromListing(productId, button) {
    @guest('customer')
        alert('Vui lòng đăng nhập để sử dụng tính năng yêu thích');
        window.location.href = '{{ route("login") }}';
        return;
    @endguest

    const icon = button.querySelector('i');
    const originalClass = icon.className;

    fetch('{{ route("wishlist.toggle") }}', {
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
            if (data.action === 'added') {
                icon.className = 'fa fa-heart';
                icon.style.color = '#e74c3c';
                button.setAttribute('data-tippy', 'Xóa khỏi yêu thích');
            } else {
                icon.className = 'fa fa-heart-o';
                icon.style.color = '';
                button.setAttribute('data-tippy', 'Thêm vào yêu thích');
            }
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message || 'Có lỗi xảy ra', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi thực hiện thao tác', 'error');
    });
}

@auth('customer')
function checkWishlistStatus() {
    const productIds = Array.from(document.querySelectorAll('.add-to-wishlist')).map(btn => 
        btn.getAttribute('data-product-id')
    );

    if (productIds.length === 0) return;

    // Check each product individually
    productIds.forEach(productId => {
        fetch('{{ route("wishlist.check") }}', {
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
            if (data.inWishlist) {
                const button = document.querySelector(`[data-product-id="${productId}"]`);
                if (button) {
                    const icon = button.querySelector('i');
                    icon.className = 'fa fa-heart';
                    icon.style.color = '#e74c3c';
                    button.setAttribute('data-tippy', 'Xóa khỏi yêu thích');
                }
            }
        })
        .catch(error => {
            console.error('Error checking wishlist status:', error);
        });
    });
}
@endauth

// Simple notification function
function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} notification-popup`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        padding: 15px;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        animation: slideInRight 0.3s ease-out;
    `;
    notification.textContent = message;
    
    // Add animation styles if not already added
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Add to page
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>
@endpush
@endsection

