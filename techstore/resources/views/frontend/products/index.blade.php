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
                                    <li class="wishlist"><a href="#" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-tippy="Thêm vào yêu thích"><i class="ion-android-favorite-outline"></i></a></li>
                                    <li class="compare"><a href="#" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-tippy="So sánh"><i class="ion-ios-settings-strong"></i></a></li>
                                    <li class="quick_button"><a href="{{ route('products.show', $product->id) }}" data-tippy-placement="top" data-tippy-arrow="true" data-tippy-inertia="true" data-tippy="Xem nhanh"><i class="ion-ios-search-strong"></i></a></li>
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
@endsection

