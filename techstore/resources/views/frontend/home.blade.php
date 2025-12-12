@extends('frontend.layout')

@section('title', 'Trang chủ - Tech Store')

@section('content')
<!--slider area start-->
<section class="slider_section slider_s_one mb-60 mt-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-12">
                <div class="swiper-container gallery-top">
                    <div class="slider_area swiper-wrapper">
                        <div class="single_slider swiper-slide d-flex align-items-center" data-bgimg="{{ asset('assets/img/slider/slider9.jpg') }}">
                            <div class="slider_content">
                                <h3>Sản phẩm phổ biến</h3>
                                <h1>Bộ sưu tập <br> công nghệ 2024</h1>
                                <p>Giảm giá <span> -30%</span> tuần này</p>
                                <a class="button" href="{{ route('products.index') }}">KHÁM PHÁ NGAY</a>
                            </div>
                        </div>
                        <div class="single_slider swiper-slide d-flex align-items-center" data-bgimg="{{ asset('assets/img/slider/slider10.jpg') }}">
                            <div class="slider_content">
                                <h3>Sản phẩm bán chạy</h3>
                                <h1>Laptop Gaming <br> 2024</h1>
                                <p>Giảm giá <span> -50%</span> tuần này</p>
                                <a class="button" href="{{ route('products.index') }}">KHÁM PHÁ NGAY</a>
                            </div>
                        </div>
                        <div class="single_slider swiper-slide d-flex align-items-center" data-bgimg="{{ asset('assets/img/slider/slider11.jpg') }}">
                            <div class="slider_content color_white">
                                <h3>Sản phẩm mới</h3>
                                <h1>Điện thoại <br> thông minh</h1>
                                <p>Giảm giá <span> -20%</span> tuần này</p>
                                <a class="button" href="{{ route('products.index') }}">KHÁM PHÁ NGAY</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="swiper-container gallery-thumbs">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            Bộ sưu tập công nghệ 2024
                        </div>
                        <div class="swiper-slide">
                            <a href="#"></a>
                            Laptop Gaming 2024
                        </div>
                        <div class="swiper-slide">
                            Điện thoại thông minh mới nhất
                        </div>
                    </div>
                </div>
            </div>
            <div class="s_banner col-lg-3 col-md-12">
                <!--banner area start-->
                <div class="sidebar_banner_area">
                    <figure class="single_banner mb-20">
                        <div class="banner_thumb">
                            <a href="{{ route('products.index') }}"><img src="{{ asset('assets/img/product/product1.jpg') }}" alt="Banner 1"></a>
                        </div>
                    </figure>
                    <figure class="single_banner mb-20">
                        <div class="banner_thumb">
                            <a href="{{ route('products.index') }}"><img src="{{ asset('assets/img/product/product2.jpg') }}" alt="Banner 2"></a>
                        </div>
                    </figure>
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="{{ route('products.index') }}"><img src="{{ asset('assets/img/product/product3.jpg') }}" alt="Banner 3"></a>
                        </div>
                    </figure>
                </div>
                <!--banner area end-->
            </div>
        </div>
    </div>
</section>
<!--slider area end-->

<!--shipping area start-->
<div class="shipping_area mb-60">
    <div class="container">
        <div class="shipping_inner">
            <div class="single_shipping">
                <div class="shipping_icone">
                    <img src="{{ asset('assets/img/about/shipping1.png') }}" alt="">
                </div>
                <div class="shipping_content">
                    <h4>Miễn phí vận chuyển</h4>
                    <p>Cho đơn hàng trên 1.000.000đ</p>
                </div>
            </div>
            <div class="single_shipping">
                <div class="shipping_icone">
                    <img src="{{ asset('assets/img/about/shipping2.png') }}" alt="">
                </div>
                <div class="shipping_content">
                    <h4>Bảo hành chính hãng</h4>
                    <p>Bảo hành chính hãng từ nhà sản xuất</p>
                </div>
            </div>
            <div class="single_shipping">
                <div class="shipping_icone">
                    <img src="{{ asset('assets/img/about/shipping3.png') }}" alt="">
                </div>
                <div class="shipping_content">
                    <h4>Đổi trả miễn phí</h4>
                    <p>Đổi trả trong vòng 30 ngày</p>
                </div>
            </div>
            <div class="single_shipping">
                <div class="shipping_icone">
                    <img src="{{ asset('assets/img/about/shipping4.png') }}" alt="">
                </div>
                <div class="shipping_content">
                    <h4>Hỗ trợ 24/7</h4>
                    <p>Hỗ trợ khách hàng 24/7</p>
                </div>
            </div>
            <div class="single_shipping">
                <div class="shipping_icone">
                    <img src="{{ asset('assets/img/about/shipping5.png') }}" alt="">
                </div>
                <div class="shipping_content">
                    <h4>Thanh toán an toàn</h4>
                    <p>Thanh toán an toàn và bảo mật</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--shipping area end-->

<!--home section bg area start-->
<div class="home_section_bg">
    <!--Categories product area start-->
    @if($categories->count() > 0)
    <div class="categories_product_area mb-55">
        <div class="container">
            <div class="categories_product_inner">
                @foreach($categories->take(6) as $category)
                <div class="single_categories_product">
                    <div class="categories_product_content">
                        <h4><a href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->ten }}</a></h4>
                        <p>{{ $category->sanPhams()->count() }} Sản phẩm</p>
                    </div>
                    <div class="categories_product_thumb">
                        <a href="{{ route('products.index', ['category' => $category->id]) }}">
                            <img src="{{ asset('assets/img/product/product' . (($loop->index % 5) + 1) . '.jpg') }}" alt="{{ $category->ten }}">
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!--Categories product area end-->

    <!--product area start-->
    @if($featuredProducts->count() > 0)
    <div class="product_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_header">
                        <div class="section_title">
                            <h2>Sản phẩm nổi bật</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product_carousel product_style product_column4 owl-carousel">
                        @foreach($featuredProducts as $product)
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    @php
                                        $images = $product->anhSanPhams;
                                        $primaryImage = $images->first();
                                        $secondaryImage = $images->skip(1)->first();
                                        $primaryUrl = $primaryImage ? asset('storage/' . $primaryImage->url) : asset('assets/img/product/product' . (($loop->index % 5) + 1) . '.jpg');
                                        $secondaryUrl = $secondaryImage ? asset('storage/' . $secondaryImage->url) : asset('assets/img/product/product' . ((($loop->index % 5) + 2) > 5 ? 1 : ($loop->index % 5) + 2) . '.jpg');
                                    @endphp
                                    <a class="primary_img" href="{{ route('products.show', $product->id) }}">
                                        <img src="{{ $primaryUrl }}" alt="{{ $product->ten }}">
                                    </a>
                                    <a class="secondary_img" href="{{ route('products.show', $product->id) }}">
                                        <img src="{{ $secondaryUrl }}" alt="{{ $product->ten }}">
                                    </a>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--product area end-->

    <!--banner area start-->
    <div class="banner_area mb-55">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="{{ route('products.index') }}"><img src="{{ asset('assets/img/product/product4.jpg') }}" alt="Banner 4"></a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-6 col-md-6">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="{{ route('products.index') }}"><img src="{{ asset('assets/img/product/product5.jpg') }}" alt="Banner 5"></a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!--banner area end-->
</div>
<!--home section bg area end-->
@endsection

