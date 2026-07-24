@extends('client.layouts.app') 
@section('title', 'Trang chủ - Mini Shop Công nghệ đỉnh cao') 
 
@section('content') 
<div class="container">
    {{-- Hero Banner Section --}}
    <div class="hero-banner">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-primary px-3 py-2 rounded-pill mb-3 fw-bold" style="letter-spacing: 0.5px;">
                    <i class="bi bi-stars me-1"></i> SIÊU THỊ CÔNG NGHỆ CHÍNH HÃNG
                </span>
                <h1 class="hero-title">Trải nghiệm Thiết bị Đỉnh cao & Ưu đãi Bất tận</h1>
                <p class="hero-subtitle">Khám phá hàng trăm sản phẩm Điện thoại, Laptop, Tablet & Phụ kiện cao cấp chính hãng với mức giá hấp dẫn nhất hôm nay.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('products.search') }}" class="btn-hero">
                        <i class="bi bi-bag-fill me-2"></i> Khám phá Ngay
                    </a>
                    <a href="#sale-products" class="btn-hero-secondary">
                        <i class="bi bi-lightning-charge-fill me-1 text-warning"></i> Săn Deal HOT
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center position-relative">
                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=600&auto=format&fit=crop" 
                     alt="Tech Devices" class="img-fluid rounded-4 shadow-lg border border-secondary" style="transform: rotate(2deg); max-height: 320px; object-fit: cover;">
            </div>
        </div>
    </div>

    {{-- Feature Boxes Section --}}
    <div class="row g-3 mb-5">
        <div class="col-6 col-md-3">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">Giao Hàng Hỏa Tốc</h6>
                    <span class="text-muted" style="font-size: 0.8rem;">Miễn phí đơn từ 500k</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">Bảo Hành 12 Tháng</h6>
                    <span class="text-muted" style="font-size: 0.8rem;">Chính hãng 100%</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">1 Đổi 1 Trong 30 Ngày</h6>
                    <span class="text-muted" style="font-size: 0.8rem;">Nếu có lỗi phần cứng</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-headset"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1" style="font-size: 0.95rem;">Hỗ Trợ 24/7</h6>
                    <span class="text-muted" style="font-size: 0.8rem;">Tư vấn nhiệt tình</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Sản phẩm mới --}} 
    <div class="d-flex justify-content-between align-items-end mb-3">
        <div>
            <h3 class="section-title">
                <i class="bi bi-fire text-danger"></i> Sản phẩm Mới Nhất
            </h3>
            <div class="section-subtitle">Những thiết bị công nghệ tiên phong vừa cập bến Mini Shop</div>
        </div>
        <a href="{{ route('products.search') }}" class="btn btn-link text-primary fw-bold text-decoration-none pb-4">
            Xem tất cả <i class="bi bi-arrow-right me-1"></i>
        </a>
    </div>

    <div class="row g-4 mb-5"> 
        @foreach ($newProducts as $product) 
            <div class="col-6 col-md-4 col-lg-3"> 
                <x-client.product :product="$product" /> 
            </div> 
        @endforeach 
    </div> 
 
    {{-- Sản phẩm giảm giá --}} 
    <div id="sale-products" class="pt-3">
        <div class="d-flex justify-content-between align-items-end mb-3">
            <div>
                <h3 class="section-title">
                    <i class="bi bi-lightning-charge-fill text-warning"></i> Giảm Giá Cực HOT
                </h3>
                <div class="section-subtitle">Cơ hội sở hữu siêu phẩm công nghệ với chi phí ưu đãi nhất</div>
            </div>
            <a href="{{ route('products.search') }}" class="btn btn-link text-primary fw-bold text-decoration-none pb-4">
                Xem tất cả deal <i class="bi bi-arrow-right me-1"></i>
            </a>
        </div>

        <div class="row g-4 mb-4"> 
            @foreach ($saleProducts as $product) 
                <div class="col-6 col-md-4 col-lg-3"> 
                    <x-client.product :product="$product" /> 
                </div> 
            @endforeach 
        </div> 
    </div>
</div>
@endsection 
