@php
    $images = $product->anhSanPhams;
    $primaryImage = $images->first();
    $secondaryImage = $images->skip(1)->first();
    $primaryUrl = $primaryImage ? asset('storage/' . $primaryImage->url) : asset('assets/img/product/product' . (($loop->index % 5) + 1) . '.jpg');
    $secondaryUrl = $secondaryImage ? asset('storage/' . $secondaryImage->url) : asset('assets/img/product/product' . ((($loop->index % 5) + 2) > 5 ? 1 : ($loop->index % 5) + 2) . '.jpg');
    
    $availableVariants = $product->bienThes->where('so_luong_ton', '>', 0);
    $minPrice = $availableVariants->count() > 0 ? $availableVariants->min('gia') : null;
    $maxPrice = $availableVariants->count() > 0 ? $availableVariants->max('gia') : null;
    $hasDiscount = $minPrice && $maxPrice && $minPrice < $maxPrice;
@endphp

<article class="single_product">
    <figure>
        <div class="product_thumb">
            <a class="primary_img" href="{{ route('products.show', $product->id) }}">
                <img src="{{ $primaryUrl }}" alt="{{ $product->ten }}">
            </a>
            @if($secondaryUrl)
            <a class="secondary_img" href="{{ route('products.show', $product->id) }}">
                <img src="{{ $secondaryUrl }}" alt="{{ $product->ten }}">
            </a>
            @endif
            @if($hasDiscount)
            <div class="label_product">
                <span class="label_sale">Giảm giá</span>
            </div>
            @endif
            @if($availableVariants->count() == 0)
            <div class="label_product">
                <span class="label_new">Hết hàng</span>
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
                           data-tippy="Xem nhanh">
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
                       class="add-to-cart-btn" 
                       title="Thêm vào giỏ hàng">
                        Thêm vào giỏ hàng
                    </a>
                @else
                    <a href="#" class="disabled" title="Hết hàng" style="opacity: 0.5; cursor: not-allowed;">
                        Hết hàng
                    </a>
                @endif
            </div>
        </div>
    </figure>
</article>

