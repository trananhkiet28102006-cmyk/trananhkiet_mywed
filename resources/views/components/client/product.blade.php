<div class="product-card"> 
    {{-- Tag giảm giá --}}
    @if ($product->pricediscount > 0 && $product->price > $product->pricediscount)
        @php
            $percent = round((($product->price - $product->pricediscount) / $product->price) * 100);
        @endphp
        <div class="product-badge-sale">
            <i class="bi bi-lightning-fill me-1"></i>GIẢM {{ $percent }}%
        </div>
    @endif

    {{-- Hình ảnh --}} 
    <div class="product-img-wrapper">
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ asset(str_starts_with($product->image, 'http') ? $product->image : (str_contains($product->image, 'storage') ? $product->image : 'storage/products/' . $product->image)) }}" alt="{{ $product->productname }}"> 
        </a>
    </div>

    <div class="product-details"> 
        {{-- Tên danh mục --}}
        <div class="product-category-name">
            {{ $product->category ? $product->category->catename : 'Công nghệ' }}
        </div>

        {{-- Tên sản phẩm --}} 
        <h6 class="product-title"> 
            <a href="{{ route('products.show', $product->slug) }}" title="{{ $product->productname }}">
                {{ $product->productname }} 
            </a>
        </h6> 

        {{-- Đánh giá sao --}}
        <div class="d-flex align-items-center mb-2" style="font-size: 0.8rem;">
            <div class="text-warning me-2">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
            </div>
            <span class="text-muted">(5.0)</span>
        </div>

        {{-- Giá --}} 
        <div class="product-price-box">
            @if ($product->pricediscount > 0) 
                <span class="product-price-current"> 
                    {{ number_format($product->pricediscount) }} đ 
                </span> 
                <span class="product-price-old"> 
                    {{ number_format($product->price) }} đ 
                </span> 
            @else 
                <span class="product-price-current"> 
                    {{ number_format($product->price) }} đ 
                </span> 
            @endif 
        </div>

        {{-- Nút mua & xem chi tiết --}} 
        <div class="row g-2"> 
            <div class="col-5"> 
                <a href="{{ route('products.show', $product->slug) }}" class="btn-view-detail-card"> 
                    <i class="bi bi-eye me-1"></i> Xem 
                </a> 
            </div> 
            <div class="col-7"> 
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="form-add-cart"> 
                    @csrf 
                    <button type="submit" class="btn-add-cart-card"> 
                        <i class="bi bi-cart-plus-fill"></i> Thêm giỏ
                    </button> 
                </form> 
            </div> 
        </div> 
    </div> 
</div> 
