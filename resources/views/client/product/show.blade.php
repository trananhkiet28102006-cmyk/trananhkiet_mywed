@extends('client.layouts.app')

@section('title', $product->productname . ' - Chi tiết sản phẩm')

@section('content')
<div class="container py-3">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted"><i class="bi bi-house-door me-1"></i>Trang chủ</a></li>
            @if ($product->category)
                <li class="breadcrumb-item"><a href="{{ url('category/' . $product->category->slug) }}" class="text-decoration-none text-muted">{{ $product->category->catename }}</a></li>
            @endif
            <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">{{ $product->productname }}</li>
        </ol>
    </nav>

    {{-- Product details row --}}
    <div class="row bg-white p-4 p-md-5 rounded-4 shadow-sm g-4 border border-light">
        {{-- Product Image --}}
        <div class="col-lg-5 text-center">
            <div class="p-3 bg-light rounded-4 border position-relative overflow-hidden mb-3">
                @if ($product->pricediscount > 0 && $product->price > $product->pricediscount)
                    <span class="position-absolute top-0 start-0 m-3 badge bg-danger fs-6 px-3 py-2 rounded-pill shadow">
                        <i class="bi bi-lightning-fill me-1"></i>GIẢM {{ round((($product->price - $product->pricediscount) / $product->price) * 100) }}%
                    </span>
                @endif
                <img id="mainProductImg" 
                     src="{{ asset(str_starts_with($product->image, 'http') ? $product->image : (str_contains($product->image, 'storage') ? $product->image : 'storage/products/' . $product->image)) }}" 
                     class="img-fluid rounded-3 transition" 
                     alt="{{ $product->productname }}" 
                     style="max-height: 420px; object-fit: contain; width: 100%; transition: opacity 0.2s ease;">
            </div>

            {{-- Thư viện Ảnh phụ (Product Gallery Thumbnails) --}}
            @php
                $mainImgUrl = asset(str_starts_with($product->image, 'http') ? $product->image : (str_contains($product->image, 'storage') ? $product->image : 'storage/products/' . $product->image));
            @endphp

            <div class="d-flex justify-content-center flex-wrap gap-2">
                {{-- Thumb Ảnh chính --}}
                <div class="gallery-thumb border rounded-3 p-1 cursor-pointer bg-white active-thumb" 
                     style="width: 70px; height: 70px; cursor: pointer; transition: all 0.2s ease;"
                     onclick="changeMainImg('{{ $mainImgUrl }}', this)">
                    <img src="{{ $mainImgUrl }}" class="w-100 h-100 object-fit-contain rounded-2">
                </div>

                {{-- List Thumb các Ảnh phụ --}}
                @if($product->images && $product->images->count() > 0)
                    @foreach($product->images as $galleryImg)
                        @php
                            $subImgUrl = asset(str_starts_with($galleryImg->image, 'http') ? $galleryImg->image : (str_contains($galleryImg->image, 'storage') ? $galleryImg->image : 'uploads/products/' . $galleryImg->image));
                        @endphp
                        <div class="gallery-thumb border rounded-3 p-1 cursor-pointer bg-white" 
                             style="width: 70px; height: 70px; cursor: pointer; transition: all 0.2s ease;"
                             onclick="changeMainImg('{{ $subImgUrl }}', this)">
                            <img src="{{ $subImgUrl }}" class="w-100 h-100 object-fit-contain rounded-2">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Product Info --}}
        <div class="col-lg-7 d-flex flex-column justify-content-between">
            <div>
                <h1 class="h2 text-dark fw-extrabold mb-3">{{ $product->productname }}</h1>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="text-warning me-2 fs-5">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <span class="text-muted fw-semibold me-3">5.0 (48 đánh giá)</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                        <i class="bi bi-check-circle-fill me-1"></i> Sẵn hàng chính hãng
                    </span>
                </div>

                {{-- Price block --}}
                <div class="product-detail-price-box mb-4 p-4 rounded-4">
                    @if ($product->pricediscount > 0)
                        <div class="d-flex align-items-baseline">
                            <span class="fs-1 text-danger fw-extrabold me-3">
                                {{ number_format($product->pricediscount) }} đ
                            </span>
                            <span class="fs-5 text-decoration-line-through text-muted">
                                {{ number_format($product->price) }} đ
                            </span>
                        </div>
                    @else
                        <div>
                            <span class="fs-1 text-danger fw-extrabold">
                                {{ number_format($product->price) }} đ
                            </span>
                        </div>
                    @endif
                    <div class="text-success small mt-2 fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> Đã bao gồm thuế VAT & Bảo hành chính hãng 12 tháng
                    </div>
                </div>

                {{-- Short info --}}
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted d-block">Danh mục</small>
                            <strong class="text-dark">{{ $product->category ? $product->category->catename : 'Đang cập nhật' }}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted d-block">Thương hiệu</small>
                            <strong class="text-dark">{{ $product->brand ? $product->brand->brandname : 'Đang cập nhật' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <h5 class="fw-bold text-dark border-bottom pb-2">Thông tin chi tiết</h5>
                    <div class="lh-lg text-secondary" style="font-size: 0.95rem;">
                        {!! $product->description ?: 'Chưa có mô tả chi tiết cho sản phẩm này.' !!}
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="mt-4 border-top pt-4">
                <div class="d-flex flex-wrap gap-3">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="form-add-cart flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-lg py-3" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none;">
                            <i class="bi bi-cart-plus-fill me-2 fs-5"></i> THÊM VÀO GIỎ HÀNG
                        </button>
                    </form>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4 fw-bold">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Related products --}}
    @if ($relatedProducts->count() > 0)
        <div class="mt-5 pt-3">
            <h3 class="section-title mb-4">
                <i class="bi bi-grid-3x3-gap-fill text-primary"></i> Sản phẩm cùng danh mục
            </h3>
            <div class="row g-4">
                @foreach ($relatedProducts as $related)
                    <div class="col-6 col-md-4 col-lg-3">
                        <x-client.product :product="$related" />
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    function changeMainImg(src, el) {
        const mainImg = document.getElementById('mainProductImg');
        if (!mainImg) return;

        mainImg.style.opacity = '0.3';
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
        }, 150);

        document.querySelectorAll('.gallery-thumb').forEach(thumb => {
            thumb.style.borderColor = '#e2e8f0';
            thumb.style.borderWidth = '1px';
        });
        if (el) {
            el.style.borderColor = '#6366f1';
            el.style.borderWidth = '2px';
        }
    }
</script>
@endsection
