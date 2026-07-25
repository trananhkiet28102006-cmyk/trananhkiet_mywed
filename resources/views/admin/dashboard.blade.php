@extends('admin.layouts.admin')

@section('title', 'Bảng điều khiển Quản trị')

@section('content')
<div class="container-fluid px-4 py-3">

    {{-- Welcome Hero Banner --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden" 
         style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);">
        <div class="card-body p-4 p-lg-5 position-relative">
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm">
                        <i class="bi bi-shield-check me-1"></i> Quản trị viên Chuyên nghiệp
                    </span>
                    <h1 class="display-6 fw-extrabold mb-2 text-white">
                        Chào mừng quay trở lại, {{ Auth::user()->fullname ?? 'Admin' }}! 👋
                    </h1>
                    <p class="fs-6 opacity-90 mb-4" style="max-width: 600px;">
                        Hệ thống MiniShop hiện đang vận hành ổn định. Dưới đây là báo cáo số liệu tổng quan và lối tắt điều hướng quản lý tài nguyên.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-light rounded-pill px-4 py-2 fw-bold text-primary shadow-sm">
                            <i class="bi bi-plus-circle-fill me-1"></i> Thêm sản phẩm
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold">
                            <i class="bi bi-cart-fill me-1"></i> Xem Đơn hàng
                        </a>
                        <a href="{{ route('admin.change-password.form') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold">
                            <i class="bi bi-key-fill me-1"></i> Đổi mật khẩu
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <i class="bi bi-speedometer2 text-white opacity-25" style="font-size: 10rem; line-height: 1;"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Row 1: 4 Khối Chỉ số chính --}}
    <div class="row g-3 mb-4">
        <!-- Doanh thu -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm h-100 p-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 text-uppercase fw-bold small">Doanh Thu Thực Tế</span>
                        <h3 class="fw-extrabold mb-0 mt-1">{{ number_format($totalRevenue) }} đ</h3>
                        <small class="text-white-50 fs-7">Đơn hàng hoàn thành</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-currency-dollar fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Đơn hàng -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm h-100 p-3" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 text-uppercase fw-bold small">Tổng Đơn Hàng</span>
                        <h3 class="fw-extrabold mb-0 mt-1">{{ number_format($countOrders) }}</h3>
                        <small class="text-white-50 fs-7">Đơn hàng hệ thống</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-cart-check-fill fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sản phẩm -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm h-100 p-3" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 text-uppercase fw-bold small">Tổng Sản Phẩm</span>
                        <h3 class="fw-extrabold mb-0 mt-1">{{ number_format($countProducts) }}</h3>
                        <small class="text-white-50 fs-7">Thiết bị công nghệ</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-box-seam-fill fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Người dùng -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-4 shadow-sm h-100 p-3" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 text-uppercase fw-bold small">Tài Khoản Hệ Thống</span>
                        <h3 class="fw-extrabold mb-0 mt-1">{{ number_format($countUsers) }}</h3>
                        <small class="text-white-50 fs-7">Quản trị & Nhân viên</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-people-fill fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Row 2: 3 Khối Chỉ số phụ --}}
    <div class="row g-3 mb-4">
        <!-- Danh mục -->
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 rounded-4 bg-primary bg-opacity-10 text-primary fs-3">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="text-muted small fw-bold text-uppercase">Danh mục loại sản phẩm</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ $countCategories }} Loại</h4>
                    </div>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-light rounded-circle">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Thương hiệu -->
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 rounded-4 bg-success bg-opacity-10 text-success fs-3">
                        <i class="bi bi-award-fill"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="text-muted small fw-bold text-uppercase">Thương hiệu đối tác</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ $countBrands }} Nhãn hiệu</h4>
                    </div>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-sm btn-light rounded-circle">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bài viết -->
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 rounded-4 bg-info bg-opacity-10 text-info fs-3">
                        <i class="bi bi-journal-richtext"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="text-muted small fw-bold text-uppercase">Tin tức & Bài viết</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ $countPosts }} Bài viết</h4>
                    </div>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-light rounded-circle">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Layout: Trạng thái & Thao tác nhanh --}}
    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white h-100">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-lightning-charge-fill text-warning me-2"></i> Lối Tắt Thao Tác Nhanh</h5>
                <div class="row g-2">
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary w-100 py-3 rounded-3 text-start">
                            <i class="bi bi-plus-square fs-4 d-block mb-1"></i>
                            <span class="fw-semibold">Thêm Sản phẩm</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-success w-100 py-3 rounded-3 text-start">
                            <i class="bi bi-receipt fs-4 d-block mb-1"></i>
                            <span class="fw-semibold">Quản lý Đơn hàng</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('admin.products.trash') }}" class="btn btn-outline-secondary w-100 py-3 rounded-3 text-start">
                            <i class="bi bi-trash3 fs-4 d-block mb-1"></i>
                            <span class="fw-semibold">Thùng rác Sản phẩm</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-warning w-100 py-3 rounded-3 text-start">
                            <i class="bi bi-person-gear fs-4 d-block mb-1"></i>
                            <span class="fw-semibold">Quản lý Người dùng</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('admin.change-password.form') }}" class="btn btn-outline-danger w-100 py-3 rounded-3 text-start">
                            <i class="bi bi-key fs-4 d-block mb-1"></i>
                            <span class="fw-semibold">Đổi mật khẩu</span>
                        </a>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-dark w-100 py-3 rounded-3 text-start">
                            <i class="bi bi-globe fs-4 d-block mb-1"></i>
                            <span class="fw-semibold">Xem trang Client</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white h-100">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-cpu-fill text-primary me-2"></i> Trạng Thái Hệ Thống</h5>
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0 border-bottom">
                        <span><i class="bi bi-database-check text-success me-2 fs-6"></i> Cơ sở dữ liệu MySQL</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">Hoạt động tốt</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0 border-bottom">
                        <span><i class="bi bi-shield-lock text-primary me-2 fs-6"></i> Phân quyền Admin / Staff</span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill">Đã kích hoạt</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0 border-bottom">
                        <span><i class="bi bi-envelope-check text-info me-2 fs-6"></i> Dịch vụ Gmail SMTP</span>
                        <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-1 rounded-pill">Đã kết nối</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0">
                        <span><i class="bi bi-trash text-warning me-2 fs-6"></i> Xóa mềm & Thùng rác</span>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill">Toàn diện 5 bảng</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection
