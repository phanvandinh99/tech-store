@extends('frontend.layout')

@section('title', 'Thanh toán - Tech Store')

@push('styles')
<style>
    .checkout-form {
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 0.5rem;
    }
    .order-summary {
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        border: 1px solid #ddd;
    }
    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #eee;
    }
    .order-item:last-child {
        border-bottom: none;
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
                        <li><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                        <li>Thanh toán</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--checkout area start-->
<div class="checkout_area mb-60">
    <div class="container">
        <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <div class="checkout-form">
                        <h3 class="mb-4">Thông tin giao hàng</h3>
                        
                        @auth('customer')
                            @php
                                $user = Auth::guard('customer')->user();
                            @endphp
                            <div class="mb-3">
                                <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" 
                                       name="ho_ten" value="{{ old('ho_ten', $user->ten ?? '') }}" required>
                                @error('ho_ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" 
                                       name="ho_ten" value="{{ old('ho_ten') }}" required>
                                @error('ho_ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endauth

                        <div class="mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('dien_thoai') is-invalid @enderror" 
                                   name="dien_thoai" value="{{ old('dien_thoai') }}" required>
                            @error('dien_thoai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('dia_chi') is-invalid @enderror" 
                                      name="dia_chi" rows="3" required>{{ old('dia_chi') }}</textarea>
                            @error('dia_chi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú (tùy chọn)</label>
                            <textarea class="form-control" name="ghi_chu" rows="3">{{ old('ghi_chu') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5">
                    <div class="order-summary">
                        <h3 class="mb-4">Đơn hàng của bạn</h3>
                        
                        <div class="order-items mb-3">
                            @foreach($cart as $item)
                            <div class="order-item">
                                <div>
                                    <strong>{{ $item['name'] }}</strong>
                                    <br>
                                    <small class="text-muted">Số lượng: {{ $item['quantity'] }}</small>
                                </div>
                                <div class="text-end">
                                    <strong>{{ number_format($item['price'] * $item['quantity']) }} đ</strong>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <hr>
                        
                        <div class="order-totals">
                            <div class="order-item">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($total) }} đ</span>
                            </div>
                            <div class="order-item">
                                <span>Phí vận chuyển:</span>
                                <span>Miễn phí</span>
                            </div>
                            <div class="order-item">
                                <strong>Tổng cộng:</strong>
                                <strong style="font-size: 1.25rem; color: #e74c3c;">{{ number_format($total) }} đ</strong>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Đặt hàng</button>
                        </div>
                        
                        <div class="mt-3">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">Quay lại giỏ hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--checkout area end-->
@endsection

