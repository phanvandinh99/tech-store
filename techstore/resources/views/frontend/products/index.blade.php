@extends('frontend.layout')

@section('title', 'Sản phẩm - Tech Store')

@push('styles')
<style>
    .product-filter-bar {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .filter-row {
        display: flex;
        gap: 1rem;
        align-items: end;
        flex-wrap: wrap;
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
        min-width: 150px;
        flex: 1;
    }
    
    .filter-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #555;
        margin-bottom: 0.5rem;
        white-space: nowrap;
    }
    
    .filter-group select,
    .filter-group input {
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 0.9rem;
        height: 45px;
        background: white;
    }
    
    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: #e74c3c;
        box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.1);
    }
    
    .price-range {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .price-range input {
        width: 80px;
        flex: 1;
    }
    
    .price-range span {
        color: #666;
        font-weight: 600;
        padding: 0 0.25rem;
    }
    
    .filter-actions {
        display: flex;
        gap: 0.5rem;
        align-items: end;
        flex-shrink: 0;
    }
    
    .btn-filter {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 4px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        height: 45px;
        white-space: nowrap;
    }
    
    .btn-primary {
        background: #e74c3c;
        color: white;
    }
    
    .btn-primary:hover {
        background: #c0392b;
        color: white;
        text-decoration: none;
    }
    
    .btn-secondary {
        background: #6c757d;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #545b62;
        color: white;
        text-decoration: none;
    }
    
    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .products-count {
        color: #666;
        font-size: 0.9rem;
    }
    
    .show-all-toggle {
        font-size: 0.85rem;
    }
    
    .show-all-toggle a {
        color: #e74c3c;
        text-decoration: none;
    }
    
    .show-all-toggle a:hover {
        text-decoration: underline;
    }
    
    @media (max-width: 768px) {
        .filter-row {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-group {
            min-width: auto;
            flex: none;
        }
        
        .price-range {
            justify-content: space-between;
        }
        
        .price-range input {
            max-width: 120px;
        }
        
        .filter-actions {
            justify-content: center;
            margin-top: 1rem;
        }
        
        .products-header {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
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
                        <li>Sản phẩm</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--product area start-->
<div class="product_area mb-60">
    <div class="container">
        <!-- Filter Bar -->
        <div class="product-filter-bar">
            <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="category">Danh mục</label>
                        <select name="category" id="category">
                            <option value="">Tất cả</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->ten }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="sort">Sắp xếp</label>
                        <select name="sort" id="sort">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Giá thấp</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Giá cao</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label>Khoảng giá (VNĐ)</label>
                        <div class="price-range">
                            <input type="number" name="min_price" placeholder="Từ" value="{{ request('min_price') }}" min="0">
                            <span>-</span>
                            <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}" min="0">
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label for="per_page">Hiển thị</label>
                        <select name="per_page" id="per_page">
                            <option value="12" {{ request('per_page') == '12' ? 'selected' : '' }}>12</option>
                            <option value="24" {{ request('per_page') == '24' ? 'selected' : '' }}>24</option>
                            <option value="36" {{ request('per_page') == '36' ? 'selected' : '' }}>36</option>
                        </select>
                    </div>
                    
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter btn-primary">
                            <i class="fa fa-search"></i> Lọc
                        </button>
                        @if(request()->hasAny(['category', 'sort', 'min_price', 'max_price']) && 
                            (request('category') || request('sort') != 'newest' || request('min_price') || request('max_price')))
                            <a href="{{ route('products.index') }}" class="btn-filter btn-secondary">
                                <i class="fa fa-refresh"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
                
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('show_all'))
                    <input type="hidden" name="show_all" value="1">
                @endif
            </form>
        </div>

        <!-- Products Header -->
        <div class="products-header">
            <div>
                <h2>
                    @if(request('search'))
                        Kết quả: "{{ request('search') }}"
                    @elseif(request('category'))
                        {{ $categories->find(request('category'))->ten ?? 'Sản phẩm' }}
                    @else
                        Sản phẩm
                    @endif
                </h2>
                <p class="products-count">
                    {{ $products->total() }} sản phẩm
                    @if(!request('show_all'))
                        (chỉ còn hàng)
                    @endif
                </p>
            </div>
            <div class="show-all-toggle">
                @if(request('show_all'))
                    <a href="{{ request()->fullUrlWithQuery(['show_all' => null]) }}">
                        <i class="fa fa-eye-slash"></i> Chỉ hiện còn hàng
                    </a>
                @else
                    <a href="{{ request()->fullUrlWithQuery(['show_all' => '1']) }}">
                        <i class="fa fa-eye"></i> Hiện tất cả
                    </a>
                @endif
            </div>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                @include('frontend.partials.product-item', ['product' => $product])
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="pagination_area text-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fa fa-search" style="font-size: 3rem; color: #ddd; margin-bottom: 20px;"></i>
                    <h3>Không tìm thấy sản phẩm</h3>
                    <p class="text-muted">Thử điều chỉnh bộ lọc hoặc từ khóa tìm kiếm</p>
                    <a href="{{ route('products.index') }}" class="btn-filter btn-primary">
                        Xem tất cả sản phẩm
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!--product area end-->

@push('scripts')
<script>
// Auto-submit form when filter changes
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const filterSelects = filterForm.querySelectorAll('select');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            filterForm.submit();
        });
    });
    
    // Handle price inputs with debounce
    const priceInputs = filterForm.querySelectorAll('input[type="number"]');
    let priceTimeout;
    
    priceInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(priceTimeout);
            priceTimeout = setTimeout(() => {
                filterForm.submit();
            }, 1000);
        });
    });

    // Handle wishlist button clicks
    document.querySelectorAll('.add-to-wishlist').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            toggleWishlistFromListing(productId, this);
        });
    });

    // Check wishlist status for all products
    @auth('customer')
    checkWishlistStatus();
    @endauth
});

function toggleWishlistFromListing(productId, button) {
    @guest('customer')
        alert('Vui lòng đăng nhập để sử dụng tính năng yêu thích');
        window.location.href = '{{ route("login") }}';
        return;
    @endguest

    const icon = button.querySelector('i');

    fetch('{{ route("wishlist.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.action === 'added') {
                icon.className = 'fa fa-heart';
                icon.style.color = '#e74c3c';
            } else {
                icon.className = 'fa fa-heart-o';
                icon.style.color = '';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

@auth('customer')
function checkWishlistStatus() {
    const productIds = Array.from(document.querySelectorAll('.add-to-wishlist')).map(btn => 
        btn.getAttribute('data-product-id')
    );

    if (productIds.length === 0) return;

    productIds.forEach(productId => {
        fetch('{{ route("wishlist.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.inWishlist) {
                const button = document.querySelector(`[data-product-id="${productId}"]`);
                if (button) {
                    const icon = button.querySelector('i');
                    icon.className = 'fa fa-heart';
                    icon.style.color = '#e74c3c';
                }
            }
        })
        .catch(error => {
            console.error('Error checking wishlist status:', error);
        });
    });
}
@endauth
</script>
@endpush
@endsection

