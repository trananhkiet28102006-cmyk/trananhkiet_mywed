@extends('client.layouts.app')

@section('title', $product->productname . ' - Chi tiết sản phẩm')

@section('content')
<div class="container py-4">
    <x-admin.alert />

    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
        <div class="row">
            {{-- Hình ảnh sản phẩm --}}
            <div class="col-md-5 mb-3 mb-md-0 text-center">
                <div class="p-3 bg-light rounded-4 d-flex align-items-center justify-content-center" style="min-height: 400px;">
                    @if($product->image)
                        <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid rounded-4" alt="{{ $product->productname }}" style="max-height: 350px; object-fit: contain;">
                    @else
                        <img src="{{ asset('images/default.png') }}" class="img-fluid rounded-4" alt="Default" style="max-height: 350px; object-fit: contain;">
                    @endif
                </div>
            </div>

            {{-- Thông tin sản phẩm --}}
            <div class="col-md-7 d-flex flex-column">
                <h1 class="fw-bold text-dark mb-3">{{ $product->productname }}</h1>
                
                {{-- Đánh giá sao giả lập & Trạng thái --}}
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="text-warning">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </span>
                    <span class="text-muted small">| Đã bán: 99+</span>
                    @if($product->status == 1)
                        <span class="badge bg-success">Còn hàng</span>
                    @else
                        <span class="badge bg-danger">Hết hàng</span>
                    @endif
                </div>

                {{-- Giá bán --}}
                <div class="p-3 bg-light rounded-3 mb-4">
                    @if($product->pricediscount > 0)
                        <span class="text-danger fw-bold fs-2 me-3">{{ number_format($product->pricediscount) }}đ</span>
                        <span class="text-muted text-decoration-line-through fs-5">{{ number_format($product->price) }}đ</span>
                    @else
                        <span class="text-primary fw-bold fs-2">{{ number_format($product->price) }}đ</span>
                    @endif
                </div>

                {{-- Nút Thêm vào giỏ hàng --}}
                <div class="d-flex align-items-center gap-3 mb-4">
                    <button class="btn btn-primary btn-lg px-4" disabled>
                        <i class="bi bi-cart-plus me-2"></i> Thêm vào giỏ hàng (Chưa kích hoạt)
                    </button>
                </div>

                {{-- Mô tả --}}
                <div class="mt-4">
                    <h5 class="fw-bold text-dark border-bottom pb-2">Mô tả sản phẩm</h5>
                    <p class="text-muted" style="line-height: 1.8;">
                        {!! nl2br(e($product->description)) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
