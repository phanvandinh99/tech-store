@php
    $images = $product->anhSanPhams;
    $primaryImage = $images->where('la_anh_chinh', 1)->first() ?? $images->first();
    $secondaryImage = $images->where('la_anh_chinh', 0)->first();
    $primaryUrl = $primaryImage ? asset('storage/' . $primaryImage->duong_dan) : asset('assets/img/product/product' . (($loop->index % 5) + 1) . '.jpg');
    $secondaryUrl = $secondaryImage ? asset('storage/' . $secondaryImage->duong_dan) : asset('assets/img/product/product' . ((($loop->index % 5) + 2) > 5 ? 1 : ($loop->index % 5) + 2) . '.jpg');
    
    $availableVariants = $product->bienThes->where('so_luong_ton', '>', 0);
    $allVariants = $product->bienThes;
    $minPrice = $allVariants->count() > 0 ? $allVariants->min('gia') : null;
    $maxPrice = $allVariants->count() > 0 ? $allVariants->max('gia') : null;
    $hasDiscount = $minPrice && $maxPrice && $minPrice < $maxPrice;
    
    // Calculate average rating
    $avgRating = $product->danhGias->where('trang_thai', 'approved')->avg('so_sao') ?? 0;
    $reviewCount = $product->danhGias->where('trang_thai', 'approved')->count();
@endphp

<article class="single_product">
    <figure>
        <div class="product_thumb">
            <a class="primary_img" href="{{ route('products.show', $product->id) }}">
                <img src="{{ $primaryUrl }}" alt="{{ $product->ten }}">
            </a>
            @if($secondaryUrl && $secondaryImage)
            <a class="secondary_img" href="{{ route('products.show', $product->id) }}">
                <img src="{{ $secondaryUrl }}" alt="{{ $product->ten }}">
            </a>
            @endif
            
            @if($availableVariants->count() == 0)
            <div class="label_product">
                <span class="label_new" style="background: #6c757d;">Hết hàng</span>
            </div>
            @elseif($hasDiscount)
            <div class="label_product">
                <span class="label_sale">Giảm giá</span>
            </div>
            @endif
            
            <div class="action_links">
                <ul>
                    <li class="wishlist">
                        <a href="#" 
                           class="add-to-wishlist" 
                           data-product-id="{{ $product->id }}"
                           data-tippy-placement="top" 
                           data-tippy-arrow="true" 
                           data-tippy-inertia="true" 
                           data-tippy="Thêm vào yêu thích">
                            <i class="fa fa-heart-o"></i>
                        </a>
                    </li>
                    <li class="compare">
                        <a href="#" 
                           class="add-to-compare" 
                           data-product-id="{{ $product->id }}"
                           data-tippy-placement="top" 
                           data-tippy-arrow="true" 
                           data-tippy-inertia="true" 
                           data-tippy="So sánh">
                            <i class="fa fa-exchange"></i>
                        </a>
                    </li>
                    <li class="quick_button">
                        <a href="{{ route('products.show', $product->id) }}" 
                           data-tippy-placement="top" 
                           data-tippy-arrow="true" 
                           data-tippy-inertia="true" 
                           data-tippy="Xem chi tiết">
                            <i class="fa fa-eye"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="product_content">
            <div class="product_content_inner">
                <h4 class="product_name">
                    <a href="{{ route('products.show', $product->id) }}">{{ $product->ten }}</a>
                </h4>
                
                <!-- Rating -->
                <div class="product_rating">
                    @if($reviewCount > 0)
                        <ul>
                            @for($i = 1; $i <= 5; $i++)
                                <li><a href="#"><i class="fa{{ $i <= $avgRating ? '' : 'r' }} fa-star"></i></a></li>
                            @endfor
                        </ul>
                    @else
                        <ul>
                            @for($i = 1; $i <= 5; $i++)
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            @endfor
                        </ul>
                    @endif
                </div>
                
                <div class="price_box">
                    @if($minPrice)
                        @if($minPrice == $maxPrice)
                            <span class="current_price">{{ number_format($minPrice) }} đ</span>
                        @else
                            <span class="old_price">{{ number_format($maxPrice) }} đ</span>
                            <span class="current_price">{{ number_format($minPrice) }} đ</span>
                        @endif
                    @else
                        <span class="current_price">Liên hệ</span>
                    @endif
                </div>
            </div>
            <div class="add_to_cart">
                @if($availableVariants->count() > 0)
                    <a href="{{ route('products.show', $product->id) }}" 
                       title="Xem chi tiết">
                        Xem chi tiết
                    </a>
                @else
                    <a href="#" class="disabled" title="Hết hàng" style="opacity: 0.5; cursor: not-allowed; background: #6c757d;">
                        Hết hàng
                    </a>
                @endif
            </div>
        </div>
    </figure>
</article>

