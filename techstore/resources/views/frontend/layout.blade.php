<!doctype html>
<html class="no-js" lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Tech Store - Cửa hàng công nghệ hàng đầu')</title>
    <meta name="description" content="@yield('description', 'Tech Store - Cửa hàng công nghệ hàng đầu Việt Nam')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

    <!-- CSS -->
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    @stack('styles')
</head>

<body>
    <!--Offcanvas menu area start-->
    @include('frontend.partials.offcanvas')
    <!--Offcanvas menu area end-->

    <!--header area start-->
    @include('frontend.partials.header')
    <!--header area end-->

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

