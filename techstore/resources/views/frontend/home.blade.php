@extends('frontend.layout')

@section('title', 'Trang chủ - Tech Store')

@push('styles')
<style>
    .slider_section {
        margin-bottom: 60px;
        margin-top: 20px;
    }
    .shipping_area {
        margin-bottom: 60px;
    }
    .product_area {
        margin-bottom: 55px;
    }
    .categories_product_area {
        margin-bottom: 55px;
    }
    .banner_area {
        margin-bottom: 55px;
    }
    
    /* Categories product uniform sizing */
    .categories_product_inner {
        max-width: 750px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .single_categories_product {
        width: 230px;
        height: 80px;
        display: flex;
        align-items: center;
        background: #fff;
        border-radius: 6px;
        padding: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }
    
    .single_categories_product:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.12);
    }
    
    .categories_product_content {
        flex: 1;
        padding-right: 12px;
    }
    
    .categories_product_content h4 {
        font-size: 14px;
        font-weight: 600;
        margin: 0 0 3px 0;
        line-height: 1.2;
        color: #333;
    }
    
    .categories_product_content h4 a {
        color: #333;
        text-decoration: none;
    }
    
    .categories_product_content h4 a:hover {
        color: #007bff;
    }
    
    .categories_product_content p {
        font-size: 11px;
        color: #666;
        margin: 0;
    }
    
    .categories_product_thumb {
        width: 56px;
        height: 56px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .categories_product_thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .categories_product_thumb:hover img {
        transform: scale(1.05);
    }
    
    @media (max-width: 768px) {
        .categories_product_inner {
            max-width: 100%;
            gap: 12px;
        }
        
        .single_categories_product {
            width: 210px;
            height: 70px;
            padding: 10px;
        }
        
        .categories_product_content h4 {
            font-size: 13px;
        }
        
        .categories_product_content p {
            font-size: 10px;
        }
        
        .categories_product_thumb {
            width: 50px;
            height: 50px;
        }
    }
    
    @media (max-width: 480px) {
        .single_categories_product {
            width: 100%;
            max-width: 280px;
        }
    }
</style>
@endpush

@section('content')
<!--slider area start-->
<section class="slider_section slider_s_one mb-60 mt-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-12">
                <div class="swiper-container gallery-top">
                    <div class="slider_area swiper-wrapper">
                        <div class="single_slider swiper-slide d-flex align-items-center" data-bgimg="{{ asset('assets/img/banner/banner11.webp') }}">
                            <div class="slider_content">
                                <h3>Tech Store</h3>
                                <h1>
                                    CÔNG NGHỆ<br />
                                    MỚI NHẤT 2025
                                </h1>
                                <p>Giảm <span> -30%</span> cho lễ hội giáng sinh</p>
                                <a class="button" href="{{ route('products.index') }}">Mua Ngay</a>
                            </div>
                        </div>
                        <div class="single_slider swiper-slide d-flex align-items-center" data-bgimg="{{ asset('assets/img/banner/banner12.webp') }}">
                            <div class="slider_content">
                                <h3>Khuyến mãi</h3>
                                <h1>
                                    Hệ Sinh Thái<br />
                                    Công Nghệ 2025
                                </h1>
                                <p>Giảm tới<span> -50%</span> tuần lễ vàng</p>
                                <a class="button" href="{{ route('products.index') }}">Xem Ngay</a>
                            </div>
                        </div>
                        <div class="single_slider swiper-slide d-flex align-items-center" data-bgimg="{{ asset('assets/img/banner/banner13.webp') }}">
                            <div class="slider_content color_white">
                                <h3>Sản phẩm mới</h3>
                                <h1>
                                    Thiết Bị<br />
                                    Thông Minh
                                </h1>
                                <p>Giảm giá <span> -20%</span> Tuần Lễ vàng</p>
                                <a class="button" href="{{ route('products.index') }}">Mua Ngay</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="swiper-container gallery-thumbs">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">Công nghệ mới nhất 2025</div>
                        <div class="swiper-slide">Hệ sinh thái công nghệ</div>
                        <div class="swiper-slide">Thiết bị thông minh</div>
                    </div>
                </div>
            </div>
            <div class="s_banner col-lg-3 col-md-12">
                <div class="sidebar_banner_area">
                    <figure class="single_banner mb-20">
                        <div class="banner_thumb">
                            <a href="{{ route('products.index') }}">
                                <img src="{{ asset('assets/img/banner/banner3.png') }}" alt="Banner 1">
                            </a>
                        </div>
                    </figure>
                    <figure class="single_banner mb-20">
                        <div class="banner_thumb">
                            <a href="{{ route('products.index') }}">
                                <img src="{{ asset('assets/img/banner/banner4.png') }}" alt="Banner 2">
                            </a>
                        </div>
                    </figure>
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="{{ route('products.index') }}">
                                <img src="{{ asset('assets/img/banner/banner1.png') }}" alt="Banner 3">
                            </a>
                        </div>
                    </figure>
                </div>
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
                @foreach($categories as $category)
                <div class="single_categories_product">
                    <div class="categories_product_content">
                        <h4><a href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->ten }}</a></h4>
                        <p>{{ $category->sanphams_count }} Sản phẩm</p>
                    </div>
                    <div class="categories_product_thumb">
                        <a href="{{ route('products.index', ['category' => $category->id]) }}">
                            @php
                                $categoryImage = $category->sanPhams()->with('anhSanPhams')->first();
                                $imageUrl = $categoryImage && $categoryImage->anhSanPhams->first() 
                                    ? asset('storage/' . $categoryImage->anhSanPhams->first()->url)
                                    : asset('assets/img/product/product' . (($loop->index % 5) + 1) . '.jpg');
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $category->ten }}">
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!--Categories product area end-->

    <!--Featured Products area start-->
    @if($featuredProducts->count() > 0)
    <div class="product_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_header">
                        <div class="section_title">
                            <h2>Sản phẩm nổi bật</h2>
                        </div>
                        <div class="product_tab_btn">
                            <a href="{{ route('products.index') }}" class="view_all">Xem tất cả <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product_carousel product_style product_column4 owl-carousel">
                        @foreach($featuredProducts as $product)
                        @include('frontend.partials.product-item', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--Featured Products area end-->

    <!--banner area start-->
    <div class="banner_area mb-55">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="{{ route('products.index') }}">
                                <img src="{{ asset('assets/img/banner/banner1.png') }}" alt="Banner 1">
                            </a>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-6 col-md-6">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="{{ route('products.index') }}">
                                <img src="{{ asset('assets/img/banner/banner2.png') }}" alt="Banner 2">
                            </a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!--banner area end-->

    <!--New Products area start-->
    @if($newProducts->count() > 0)
    <div class="product_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_header">
                        <div class="section_title">
                            <h2>Sản phẩm mới nhất</h2>
                        </div>
                        <div class="product_tab_btn">
                            <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="view_all">Xem tất cả <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product_carousel product_style product_column4 owl-carousel">
                        @foreach($newProducts as $product)
                        @include('frontend.partials.product-item', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--New Products area end-->

    <!--Best Selling Products area start-->
    @if($bestSellingProductsData->count() > 0)
    <div class="product_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_header">
                        <div class="section_title">
                            <h2>Sản phẩm bán chạy</h2>
                        </div>
                        <div class="product_tab_btn">
                            <a href="{{ route('products.index', ['sort' => 'bestselling']) }}" class="view_all">Xem tất cả <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product_carousel product_style product_column4 owl-carousel">
                        @foreach($bestSellingProductsData as $product)
                        @include('frontend.partials.product-item', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--Best Selling Products area end-->

    <!--Cheap Products area start-->
    @if($cheapProducts->count() > 0)
    <div class="product_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_header">
                        <div class="section_title">
                            <h2>Sản phẩm giá tốt</h2>
                        </div>
                        <div class="product_tab_btn">
                            <a href="{{ route('products.index', ['sort' => 'price_low']) }}" class="view_all">Xem tất cả <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product_carousel product_style product_column4 owl-carousel">
                        @foreach($cheapProducts as $product)
                        @include('frontend.partials.product-item', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--Cheap Products area end-->
</div>
<!--home section bg area end-->
@endsection

@push('scripts')
<script>
    // Initialize Swiper for slider
    if (document.querySelector('.gallery-top')) {
        var galleryTop = new Swiper('.gallery-top', {
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 3,
            loop: true,
            freeMode: true,
            loopedSlides: 3,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
        });

        galleryTop.controller.control = galleryThumbs;
        galleryThumbs.controller.control = galleryTop;
    }

    // Initialize Owl Carousel for products
    if (jQuery().owlCarousel) {
        jQuery('.product_carousel').each(function() {
            var $carousel = jQuery(this);
            $carousel.owlCarousel({
                loop: true,
                margin: 30,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsive: {
                    0: { items: 1 },
                    480: { items: 2 },
                    768: { items: 3 },
                    992: { items: 4 },
                    1200: { items: 4 }
                }
            });
        });
    }
</script>
@endpush
