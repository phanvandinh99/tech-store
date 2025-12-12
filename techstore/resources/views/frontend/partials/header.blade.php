<!--header area start-->
@php
    $categories = \App\Models\DanhMuc::all();
    $cartCount = session('cart', []) ? count(session('cart', [])) : 0;
    $cartTotal = 0;
    if (session('cart')) {
        foreach (session('cart') as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }
    }
@endphp

<header>
    <div class="main_header">
        <div class="container">
            <!--header top start-->
            <div class="header_top">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-5">
                        <div class="antomi_message">
                            <p>Miễn phí vận chuyển – Bảo hành 30 ngày đổi trả</p>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="header_top_settings text-right">
                            <ul>
                                <li><a href="#">Vị trí cửa hàng</a></li>
                                <li><a href="#">Theo dõi đơn hàng</a></li>
                                <li>Hotline: <a href="tel:+0123456789">0123456789</a></li>
                                <li>Cam kết chất lượng sản phẩm</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--header top end-->

            <!--header middle start-->
            <div class="header_middle sticky-header">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-3 col-4">
                        <div class="logo">
                            <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo/logo.png') }}" alt="Tech Store"></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12">
                        <div class="main_menu menu_position text-center">
                            <nav>
                                <ul>
                                    <li><a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a></li>
                                    <li class="mega_items"><a class="{{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                        <div class="mega_menu">
                                            <ul class="mega_menu_inner">
                                                <li><a href="#">Danh mục</a>
                                                    <ul>
                                                        @foreach($categories->take(6) as $category)
                                                            <li><a href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->ten }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                <li><a href="#">Trang khác</a>
                                                    <ul>
                                                        <li><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                                                        <li><a href="{{ route('checkout.index') }}">Thanh toán</a></li>
                                                        @auth
                                                            <li><a href="#">Tài khoản của tôi</a></li>
                                                            <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                @csrf
                                                            </form>
                                                        @else
                                                            <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                                                        @endauth
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="#">Liên hệ</a></li>
                                    <li><a href="#">Về chúng tôi</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-7 col-6">
                        <div class="header_configure_area">
                            <div class="header_wishlist">
                                <a href="#"><i class="ion-android-favorite-outline"></i>
                                    <span class="wishlist_count">0</span>
                                </a>
                            </div>
                            <div class="mini_cart_wrapper">
                                <a href="javascript:void(0)">
                                    <i class="fa fa-shopping-bag"></i>
                                    <span class="cart_price">{{ number_format($cartTotal) }} đ <i class="ion-ios-arrow-down"></i></span>
                                    <span class="cart_count">{{ $cartCount }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header middle end-->

            <!--mini cart-->
            <div class="mini_cart">
                <div class="cart_close">
                    <div class="cart_text">
                        <h3>Giỏ hàng</h3>
                    </div>
                    <div class="mini_cart_close">
                        <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                    </div>
                </div>
                <div id="miniCartItems">
                    @if(session('cart') && count(session('cart')) > 0)
                        @foreach(session('cart') as $item)
                            <div class="cart_item">
                                <div class="cart_img">
                                    <a href="#"><img src="{{ asset('assets/img/s-product/product.jpg') }}" alt=""></a>
                                </div>
                                <div class="cart_info">
                                    <a href="#">{{ $item['name'] }}</a>
                                    <p>Số lượng: {{ $item['quantity'] }} X <span>{{ number_format($item['price']) }} đ</span></p>
                                </div>
                                <div class="cart_remove">
                                    <a href="#"><i class="ion-android-close"></i></a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="cart_item">
                            <p class="text-center">Giỏ hàng trống</p>
                        </div>
                    @endif
                </div>
                <div class="mini_cart_table">
                    <div class="cart_total">
                        <span>Tạm tính:</span>
                        <span class="price" id="miniCartSubtotal">{{ number_format($cartTotal) }} đ</span>
                    </div>
                    <div class="cart_total mt-10">
                        <span>Tổng cộng:</span>
                        <span class="price" id="miniCartTotal">{{ number_format($cartTotal) }} đ</span>
                    </div>
                </div>
                <div class="mini_cart_footer">
                    <div class="cart_button">
                        <a href="{{ route('cart.index') }}">Xem giỏ hàng</a>
                    </div>
                    <div class="cart_button">
                        <a class="active" href="{{ route('checkout.index') }}">Thanh toán</a>
                    </div>
                </div>
            </div>
            <!--mini cart end-->

            <!--header bottom start-->
            <div class="header_bottom">
                <div class="row align-items-center">
                    <div class="column1 col-lg-3 col-md-6">
                        <div class="categories_menu">
                            <div class="categories_title">
                                <h2 class="categori_toggle">TẤT CẢ DANH MỤC</h2>
                            </div>
                            <div class="categories_menu_toggle">
                                <ul>
                                    @foreach($categories as $category)
                                        <li><a href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->ten }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="column2 col-lg-6">
                        <div class="search_container">
                            <form action="{{ route('products.index') }}" method="GET">
                                <div class="hover_category">
                                    <select class="select_option" name="category" id="categori2">
                                        <option selected value="">Tất cả danh mục</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->ten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="search_box">
                                    <input placeholder="Tìm kiếm sản phẩm..." type="text" name="search" value="{{ request('search') }}">
                                    <button type="submit">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="column3 col-lg-3 col-md-6">
                        <div class="header_bigsale">
                            <a href="{{ route('products.index') }}">KHUYẾN MÃI LỚN</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--header bottom end-->
        </div>
    </div>
</header>
<!--header area end-->

