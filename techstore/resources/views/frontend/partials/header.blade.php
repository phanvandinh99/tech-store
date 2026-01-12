<!--header area start-->
<style>
.header_user_account {
    position: relative;
}
/* Tạo vùng bridge để không bị mất hover khi di chuyển từ icon sang dropdown */
.header_user_account::after {
    content: '';
    position: absolute;
    top: 100%;
    right: 0;
    width: 100%;
    height: 10px;
    background: transparent;
    z-index: 999;
}
.header_user_account #Sub {
    display: none;
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    min-width: 220px;
    z-index: 1000;
    list-style: none;
    padding: 0;
    margin: 0;
}
.header_user_account:hover #Sub,
.header_user_account:hover::after,
.header_user_account #Sub:hover {
    display: block !important;
}
.header_user_account #Sub li {
    list-style: none;
    margin: 0;
    padding: 0;
}
.header_user_account #Sub li.user-info {
    padding: 15px;
    border-bottom: 1px solid #eee;
}
.header_user_account #Sub li.user-info .user-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.header_user_account #Sub li.user-info .user-email {
    font-size: 12px;
    color: #666;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.header_user_account #Sub li a {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #f5f5f5;
    transition: background 0.3s;
    white-space: nowrap;
}
.header_user_account #Sub li a i {
    margin-right: 10px;
    width: 18px;
    text-align: center;
    flex-shrink: 0;
}
.header_user_account #Sub li:last-child a {
    border-bottom: none;
}
.header_user_account #Sub li a:hover {
    background-color: #f8f9fa;
}
.header_user_account #Sub li a.logout-link {
    color: #e74c3c;
}
.header_user_account #Sub li a.logout-link:hover {
    background-color: #fee;
    color: #c0392b;
}
</style>
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
                                                                <li><a href="#">{{ Auth::user()->ten }}</a></li>
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
                            <div class="header_wishlist header_user_account" style="position: relative;">
                                @auth
                                    <a href="javascript:void(0)" class="user_dropdown_toggle">
                                        <i class="fa fa-user-circle" id="IconUser"></i>
                                        <span class="user_name" style="display: none;">{{ Auth::user()->ten }}</span>
                                    </a>
                                    <ul id="Sub">
                                        <li class="user-info">
                                            <div class="user-name">{{ Auth::user()->ten }}</div>
                                            <div class="user-email">{{ Auth::user()->email }}</div>
                                        </li>
                                        <li><a href="#">
                                            <i class="fa fa-user"></i>Tài khoản của tôi</a></li>
                                        <li><a href="{{ route('orders.index') }}">
                                            <i class="fa fa-shopping-bag"></i>Đơn hàng của tôi</a></li>
                                        <li><a href="#">
                                            <i class="fa fa-heart"></i>Sản phẩm yêu thích</a></li>
                                        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">
                                            <i class="fa fa-sign-out"></i>Đăng xuất</a></li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <a href="{{ route('login') }}">
                                        <i class="fa fa-user-circle" id="IconUser"></i>
                                    </a>
                                @endauth
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
                        <div class="categories_menu" style="position: relative;">
                            <div class="categories_title">
                                <h2 class="categori_toggle" onclick="toggleCategoriesMenu()" style="cursor: pointer; position: relative;">
                                    TẤT CẢ DANH MỤC
                                    <i class="fa fa-angle-down" id="categoriesToggleIcon" style="float: right; margin-top: 5px; transition: transform 0.3s;"></i>
                                </h2>
                            </div>
                            <div class="categories_menu_toggle" id="categoriesMenuToggle" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-top: 2px solid #e74c3c; z-index: 999; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    @foreach($categories as $category)
                                        <li style="border-bottom: 1px solid #eee;"><a href="{{ route('products.index', ['category' => $category->id]) }}" style="display: block; padding: 0.75rem 1rem; color: #333; text-decoration: none; transition: all 0.3s;">{{ $category->ten }}</a></li>
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

<script>
function toggleCategoriesMenu() {
    const menu = document.getElementById('categoriesMenuToggle');
    const icon = document.getElementById('categoriesToggleIcon');
    
    if (!menu || !icon) return;
    
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
        icon.classList.remove('fa-angle-down');
        icon.classList.add('fa-angle-up');
        icon.style.transform = 'rotate(180deg)';
    } else {
        menu.style.display = 'none';
        icon.classList.remove('fa-angle-up');
        icon.classList.add('fa-angle-down');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Close menu when clicking outside
document.addEventListener('click', function(event) {
    const categoriesMenu = document.querySelector('.categories_menu');
    const menu = document.getElementById('categoriesMenuToggle');
    const icon = document.getElementById('categoriesToggleIcon');
    
    if (categoriesMenu && menu && icon) {
        if (!categoriesMenu.contains(event.target)) {
            if (menu.style.display === 'block') {
                menu.style.display = 'none';
                icon.classList.remove('fa-angle-up');
                icon.classList.add('fa-angle-down');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    }
});

// Hover effect for menu items
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('#categoriesMenuToggle li a');
    menuItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
            this.style.color = '#e74c3c';
        });
        item.addEventListener('mouseleave', function() {
            this.style.backgroundColor = 'transparent';
            this.style.color = '#333';
        });
    });
    
    // Hover effect for user dropdown items
    document.addEventListener('DOMContentLoaded', function() {
        const userDropdown = document.querySelector('.header_user_account #Sub');
        if (userDropdown) {
            const dropdownItems = userDropdown.querySelectorAll('a');
            dropdownItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                });
                item.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = 'transparent';
                });
            });
        }
    });
});
</script>

