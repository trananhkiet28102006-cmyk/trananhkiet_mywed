@extends('admin.layouts.admin')

@section('title', 'Bảng điều khiển Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bảng điều khiển Admin</h1>
    </div>

    {{-- Stats Row 1 --}}
    <div class="row">
        <!-- Doanh thu -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Doanh thu (Đã hoàn thành)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalRevenue) }} đ
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cash-stack fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Đơn hàng -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng số đơn hàng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $countOrders }} đơn hàng
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cart-check fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sản phẩm -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-info border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Quản lý Sản phẩm
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $countProducts }} sản phẩm
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Người dùng -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Người dùng hệ thống
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $countUsers }} tài khoản
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Row 2 --}}
    <div class="row">
        <!-- Danh mục -->
        <div class="col-md-4 mb-4">
            <div class="card shadow py-2">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Danh mục loại sản phẩm</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $countCategories }} loại sản phẩm</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-tags fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thương hiệu -->
        <div class="col-md-4 mb-4">
            <div class="card shadow py-2">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Thương hiệu đối tác</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $countBrands }} thương hiệu</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-award fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bài viết -->
        <div class="col-md-4 mb-4">
            <div class="card shadow py-2">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Tin tức & Bài viết</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $countPosts }} bài viết</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-journal-text fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Welcome block --}}
    <div class="card shadow mb-4">
        <div class="card-body py-5 text-center">
            <h2 class="text-primary fw-bold">Chào mừng bạn quay trở lại, Admin!</h2>
            <p class="text-muted">Hệ thống của bạn đang hoạt động bình thường. Sử dụng thanh menu bên trái để điều hướng quản lý các tài nguyên.</p>
        </div>
    </div>
</div>
@endsection
