@extends('frontend.layout')

@section('title', 'Đăng nhập - Tech Store')

@section('content')
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li>Đăng nhập</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!-- customer login start -->
<div class="login_page_bg">
    <div class="container">
        <div class="customer_login">
            <div class="row">
                <!--login area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form login">
                        <h2>Đăng nhập</h2>
                        
                        @if(session('success'))
                        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <p>
                                <label>Email <span>*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                            </p>
                            <p>
                                <label>Mật khẩu <span>*</span></label>
                                <input type="password" name="password" required>
                            </p>
                            <div class="login_submit">
                                <a href="{{ route('customer.password.request') }}">Quên mật khẩu?</a>
                                <label for="remember">
                                    <input id="remember" type="checkbox" name="remember">
                                    Ghi nhớ đăng nhập
                                </label>
                                <button type="submit">Đăng nhập</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--login area end-->

                <!--register area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form register">
                        <h2>Đăng ký</h2>
                        <p>Nếu bạn chưa có tài khoản, vui lòng đăng ký để có thể:</p>
                        <ul style="list-style: disc; padding-left: 20px; margin-bottom: 20px;">
                            <li>Theo dõi đơn hàng của bạn</li>
                            <li>Lưu địa chỉ giao hàng</li>
                            <li>Nhận thông tin khuyến mãi</li>
                            <li>Tích điểm và nhận ưu đãi</li>
                        </ul>
                        <div class="login_submit">
                            <a href="{{ route('register') }}" style="display: inline-block; padding: 12px 30px; background: #333; color: #fff; text-decoration: none; border-radius: 4px; text-align: center;">
                                Tạo tài khoản mới
                            </a>
                        </div>
                    </div>
                </div>
                <!--register area end-->
            </div>
        </div>
    </div>
</div>
<!-- customer login end -->
@endsection

