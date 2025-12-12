@extends('frontend.layout')

@section('title', 'Giỏ hàng - Tech Store')

@push('styles')
<style>
    .cart-table {
        width: 100%;
    }
    .cart-table th {
        background: #f8f9fa;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
    }
    .cart-table td {
        padding: 1rem;
        vertical-align: middle;
    }
    .cart-item-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 0.25rem;
    }
    .quantity-input-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .quantity-input-group input {
        width: 60px;
        text-align: center;
    }
    .cart-summary {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 0.5rem;
    }
    @media (max-width: 768px) {
        .cart-table {
            font-size: 0.875rem;
        }
        .cart-item-image {
            width: 60px;
            height: 60px;
        }
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
                        <li>Giỏ hàng</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--shopping cart area start-->
<div class="shopping_cart_area mb-60">
    <div class="container">
        @if(count($cart) > 0)
        <div class="row">
            <div class="col-12">
                <div class="table_desc">
                    <div class="cart_page table-responsive">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th class="product_remove">Xóa</th>
                                    <th class="product_thumb">Hình ảnh</th>
                                    <th class="product_name">Sản phẩm</th>
                                    <th class="product-price">Giá</th>
                                    <th class="product_quantity">Số lượng</th>
                                    <th class="product_total">Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $key => $item)
                                <tr>
                                    <td class="product_remove">
                                        <form action="{{ route('cart.remove', $key) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="product_thumb">
                                        <a href="{{ route('products.show', $item['product_id']) }}">
                                            <img src="{{ $item['image'] ?? asset('assets/img/product/product1.jpg') }}" alt="{{ $item['name'] }}" class="cart-item-image">
                                        </a>
                                    </td>
                                    <td class="product_name">
                                        <a href="{{ route('products.show', $item['product_id']) }}">{{ $item['name'] }}</a>
                                    </td>
                                    <td class="product-price">
                                        <span class="price">{{ number_format($item['price']) }} đ</span>
                                    </td>
                                    <td class="product_quantity">
                                        <form action="{{ route('cart.update', $key) }}" method="POST" class="quantity-input-group">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="this.parentElement.querySelector('input').stepDown(); this.parentElement.submit();">-</button>
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" onchange="this.form.submit()">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="this.parentElement.querySelector('input').stepUp(); this.parentElement.submit();">+</button>
                                        </form>
                                    </td>
                                    <td class="product_total">
                                        <span class="price">{{ number_format($item['price'] * $item['quantity']) }} đ</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="cart_page_button d-flex justify-content-between align-items-center">
                    <div class="cart_page_button_left">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Tiếp tục mua sắm</a>
                    </div>
                    <div class="cart_page_button_right">
                        <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">Xóa tất cả</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 offset-lg-6">
                <div class="cart_summary">
                    <div class="cart-summary">
                        <h3 class="mb-3">Tóm tắt đơn hàng</h3>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Tạm tính:</td>
                                    <td class="text-end">{{ number_format($total) }} đ</td>
                                </tr>
                                <tr>
                                    <td>Phí vận chuyển:</td>
                                    <td class="text-end">Miễn phí</td>
                                </tr>
                                <tr>
                                    <td><strong>Tổng cộng:</strong></td>
                                    <td class="text-end"><strong style="font-size: 1.25rem; color: #e74c3c;">{{ number_format($total) }} đ</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="checkout_btn mt-3">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100">Thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-cart-x" style="font-size: 4rem; color: #ccc;"></i>
                    <h3 class="mt-3">Giỏ hàng trống</h3>
                    <p class="text-muted">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!--shopping cart area end-->
@endsection

