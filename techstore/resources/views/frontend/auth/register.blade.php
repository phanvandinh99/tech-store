@extends('frontend.layout')

@section('title', 'Đăng ký - Tech Store')

@push('styles')
<style>
    .auth-container {
        min-height: 60vh;
        display: flex;
        align-items: center;
        padding: 3rem 0;
    }
    .auth-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 2.5rem;
        max-width: 450px;
        margin: 0 auto;
    }
    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    .auth-header h2 {
        margin-bottom: 0.5rem;
    }
    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
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
                        <li>Đăng ký</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--register area start-->
<div class="register_area auth-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                <div class="auth-card">
                    <div class="auth-header">
                        <h2>Đăng ký tài khoản</h2>
                        <p>Tạo tài khoản mới để mua sắm dễ dàng hơn</p>
                    </div>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Tối thiểu 8 ký tự</small>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">
                            Đăng ký
                        </button>
                    </form>

                    <div class="auth-footer">
                        <p class="mb-2">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
                        <p class="mb-0"><a href="{{ route('home') }}">Quay lại trang chủ</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--register area end-->
@endsection

