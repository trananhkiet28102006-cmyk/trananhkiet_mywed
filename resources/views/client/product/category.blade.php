@extends('client.layouts.app')

@section('title', 'Danh mục: ' . $category->catename)

@section('content')
<div class="container py-3">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted"><i class="bi bi-house-door me-1"></i>Trang chủ</a></li>
            <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">{{ $category->catename }}</li>
        </ol>
    </nav>

    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="bi bi-grid-fill text-primary me-2"></i>Danh mục: {{ $category->catename }}
            </h3>
            <p class="text-muted mb-0 small">{{ $category->description ?: 'Các sản phẩm chất lượng thuộc danh mục ' . $category->catename }}</p>
        </div>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-bold">
            {{ $products->total() }} sản phẩm
        </span>
    </div>

    @if ($products->count() > 0)
        <div class="row g-4 mb-4">
            @foreach ($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <x-client.product :product="$product" />
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
            <i class="bi bi-folder-x text-muted mb-3" style="font-size: 3.5rem;"></i>
            <h5 class="fw-bold text-dark">Danh mục này hiện chưa có sản phẩm!</h5>
            <p class="text-muted">Vui lòng quay lại sau hoặc khám phá các danh mục khác.</p>
            <div>
                <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-2">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại trang chủ
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
