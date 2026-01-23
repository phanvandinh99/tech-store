<!doctype html>
<html class="no-js" lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Tech Store - Cửa hàng công nghệ hàng đầu')</title>
    <meta name="description" content="@yield('description', 'Tech Store - Cửa hàng công nghệ hàng đầu Việt Nam')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

    <!-- CSS -->
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    <!-- Icon Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.6.3/css/ionicons.min.css">
    
    <!-- Icon Compatibility CSS -->
    <style>
        /* Ensure icons display properly */
        .fa, .fas, .far, .fal, .fab {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands" !important;
        }
        
        .ion, [class^="ion-"], [class*=" ion-"] {
            font-family: "Ionicons" !important;
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Fix for missing icons - show text fallback */
        .fa:before, .fas:before, .far:before, .fal:before, .fab:before,
        .ion:before, [class^="ion-"]:before, [class*=" ion-"]:before {
            display: inline-block;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
        }
    </style>
    
    <!-- Custom Product Image Styles -->
    <style>
        /* Đảm bảo tất cả ảnh sản phẩm có cùng chiều cao container */
        .product_thumb {
            position: relative;
            width: 100%;
            height: 280px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }
        
        .product_thumb a {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
        }
        
        .product_thumb a.primary_img,
        .product_thumb a.secondary_img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .product_thumb a img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }
        
        .product_thumb a.secondary_img {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .single_product:hover .product_thumb a.secondary_img {
            opacity: 1;
            visibility: visible;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .product_thumb {
                height: 220px;
            }
        }
        
        @media (max-width: 576px) {
            .product_thumb {
                height: 200px;
            }
        }
    </style>
    
    @stack('styles')
</head>

<body>
    <!--Offcanvas menu area start-->
    @include('frontend.partials.offcanvas')
    <!--Offcanvas menu area end-->

    <!--header area start-->
    @include('frontend.partials.header')
    <!--header area end-->

    <!-- Flash Messages -->
    @if(session('success') || session('error') || session('warning') || session('info'))
    <div class="container mt-3">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>
    @endif

    <!-- Content Area -->
    @yield('content')

    <!--footer area start-->
    @include('frontend.partials.footer')
    <!--footer area end-->

    <!-- JS -->
    <!-- Plugins JS -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    @stack('scripts')
</body>
</html>

