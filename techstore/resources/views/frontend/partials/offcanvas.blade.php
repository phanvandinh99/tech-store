<!--Offcanvas menu area start-->
<div class="off_canvars_overlay"></div>
<div class="Offcanvas_menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="canvas_open">
                    <a href="javascript:void(0)"><i class="fa fa-list-ul"></i></a>
                </div>
                <div class="Offcanvas_menu_wrapper">
                    <div class="canvas_close">
                        <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                    </div>
                    <div class="antomi_message">
                        <p>Miễn phí vận chuyển – Bảo hành 30 ngày đổi trả</p>
                    </div>
                    <div class="header_top_settings text-right">
                        <ul>
                            <li><a href="#">Vị trí cửa hàng</a></li>
                            <li><a href="#">Theo dõi đơn hàng</a></li>
                            <li>Hotline: <a href="tel:+0329555345">0329555345</a></li>
                            <li>Cam kết chất lượng sản phẩm</li>
                        </ul>
                    </div>
                    <div class="search_container">
                        <form action="{{ route('products.index') }}" method="GET">
                            <div class="hover_category">
                                <select class="select_option" name="category" id="categori1">
                                    <option selected value="">Tất cả danh mục</option>
                                    @foreach(\App\Models\DanhMuc::all() as $category)
                                        <option value="{{ $category->id }}">{{ $category->ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="search_box">
                                <input placeholder="Tìm kiếm sản phẩm..." type="text" name="search" value="{{ request('search') }}">
                                <button type="submit">Tìm kiếm</button>
                            </div>
                        </form>
                    </div>
                    <div id="menu" class="text-left">
                        <ul class="offcanvas_main_menu">
                            <li class="menu-item-has-children {{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="{{ route('home') }}">Trang chủ</a>
                            </li>
                            <li class="menu-item-has-children {{ request()->routeIs('products.*') ? 'active' : '' }}">
                                <a href="{{ route('products.index') }}">Sản phẩm</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('products.index') }}">Tất cả sản phẩm</a></li>
                                    @foreach(\App\Models\DanhMuc::take(5)->get() as $category)
                                        <li><a href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->ten }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Tài khoản</a>
                                <ul class="sub-menu">
                                    @auth('customer')
                                        <li><a href="#">Tài khoản của tôi</a></li>
                                        <li><a href="{{ route('orders.index') }}">Đơn hàng</a></li>
                                        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    @else
                                        <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                                        <li><a href="{{ route('register') }}">Đăng ký</a></li>
                                    @endauth
                                </ul>
                            </li>
                            <li><a href="{{ route('products.index') }}">Giỏ hàng</a></li>
                            <li><a href="#">Liên hệ</a></li>
                        </ul>
                    </div>
                    <div class="Offcanvas_footer">
                        <span><a href="mailto:contact@techstore.com"><i class="fa fa-envelope-o"></i> contact@techstore.com</a></span>
                        <ul>
                            <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Offcanvas menu area end-->

