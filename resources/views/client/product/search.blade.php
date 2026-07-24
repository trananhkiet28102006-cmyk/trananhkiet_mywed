@extends('client.layouts.app')

@section('title', 'Tìm kiếm sản phẩm - Mini Shop')

@section('content')
<div class="container py-3">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted"><i class="bi bi-house-door me-1"></i>Trang chủ</a></li>
            <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Tìm kiếm & Lọc sản phẩm</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Bộ lọc bên trái --}}
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white p-3">
                    <h5 class="card-title mb-0 fs-6 fw-bold"><i class="bi bi-funnel-fill me-2 text-primary"></i>Bộ lọc tìm kiếm</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('products.search') }}" method="GET">
                        {{-- Giữ từ khóa tìm kiếm chính --}}
                        <input type="hidden" name="q" value="{{ $query }}">

                        {{-- Sắp xếp theo --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Sắp xếp theo</label>
                            <select name="sort_by" class="form-select border-0 bg-light p-3 rounded-3">
                                <option value="" {{ $sortBy == '' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price_asc" {{ $sortBy == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                <option value="price_desc" {{ $sortBy == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                <option value="name_asc" {{ $sortBy == 'name_asc' ? 'selected' : '' }}>Tên A - Z</option>
                                <option value="name_desc" {{ $sortBy == 'name_desc' ? 'selected' : '' }}>Tên Z - A</option>
                            </select>
                        </div>

                        {{-- Lọc theo giá --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Khoảng giá (VNĐ)</label>
                            <div class="mb-2">
                                <input type="number" name="min_price" class="form-control border-0 bg-light p-3 rounded-3" placeholder="Giá tối thiểu" value="{{ $minPrice }}">
                            </div>
                            <div>
                                <input type="number" name="max_price" class="form-control border-0 bg-light p-3 rounded-3" placeholder="Giá tối đa" value="{{ $maxPrice }}">
                            </div>
                        </div>

                        {{-- Nút Áp dụng --}}
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none;">
                            <i class="bi bi-check-circle-fill me-1"></i> Áp dụng bộ lọc
                        </button>

                        <a href="{{ route('products.search') }}" class="btn btn-link w-100 text-muted text-decoration-none small text-center mt-2 d-block">
                            Xóa bộ lọc
                        </a>
                    </form>
                </div>
            </div>
        </div>

        {{-- Danh sách kết quả bên phải --}}
        <div class="col-lg-9">
            <div class="bg-white p-4 rounded-4 shadow-sm mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div>
                    <h4 class="fw-bold mb-1">
                        @if ($query)
                            Kết quả cho: <span class="text-primary">"{{ $query }}"</span>
                        @else
                            Tất cả sản phẩm công nghệ
                        @endif
                    </h4>
                    <span class="text-muted small">Tìm thấy <strong>{{ $products->total() }}</strong> sản phẩm phù hợp</span>
                </div>
            </div>

            @if ($products->count() > 0)
                <div class="row g-4 mb-4">
                    @foreach ($products as $product)
                        <div class="col-6 col-md-4">
                            <x-client.product :product="$product" />
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                    <i class="bi bi-search text-muted mb-3" style="font-size: 3.5rem;"></i>
                    <h5 class="fw-bold text-dark">Không tìm thấy sản phẩm nào!</h5>
                    <p class="text-muted">Rất tiếc, không tìm thấy sản phẩm khớp với điều kiện hoặc từ khóa của bạn.</p>
                    <div>
                        <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-2">
                            <i class="bi bi-arrow-left me-1"></i> Quay lại trang chủ
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
