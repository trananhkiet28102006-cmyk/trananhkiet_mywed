@extends('client.layouts.app')

@section('title', 'Tin Tức & Công Nghệ - MiniShop')

@section('content')
<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0 py-2 px-3 bg-white rounded-pill border shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i class="bi bi-house-door-fill"></i> Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tin Tức Công Nghệ</li>
        </ol>
    </nav>

    {{-- Header Banner --}}
    <div class="card border-0 rounded-4 shadow-sm mb-5 text-white overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #311042 100%);">
        <div class="card-body p-4 p-md-5 text-center">
            <span class="badge bg-primary px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm">
                <i class="bi bi-journal-text me-1"></i> BLOG & CHUYÊN MỤC TIN TỨC
            </span>
            <h1 class="display-6 fw-extrabold mb-3 text-white">Tin Tức Công Nghệ & Đánh Giá Đỉnh Cao</h1>
            <p class="text-white-50 mx-auto" style="max-width: 650px;">
                Cập nhật liên tục các xu hướng công nghệ mới nhất, đánh giá chi tiết thiết bị và mẹo vặt sử dụng sản phẩm hữu ích dành cho bạn.
            </p>
        </div>
    </div>

    {{-- Danh sách bài viết --}}
    @if ($posts->count() > 0)
        <div class="row g-4 mb-5">
            @foreach ($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 rounded-4 shadow-sm product-card overflow-hidden">
                        {{-- Thumbnail Ảnh --}}
                        <div class="product-img-wrapper" style="padding-top: 56.25%;">
                            <img src="{{ str_starts_with($post->image, 'http') ? $post->image : (str_contains($post->image, 'storage') ? asset($post->image) : asset('uploads/posts/' . $post->image)) }}" 
                                 alt="{{ $post->title }}">
                        </div>

                        {{-- Thẻ Nội dung --}}
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-3 text-muted small mb-2">
                                    <span><i class="bi bi-calendar3 me-1 text-primary"></i> {{ $post->created_at->format('d/m/Y') }}</span>
                                    <span><i class="bi bi-person-circle me-1 text-primary"></i> {{ $post->user->fullname ?? 'Admin' }}</span>
                                </div>

                                <h5 class="fw-bold text-dark mb-3 line-clamp-2" style="line-height: 1.4;">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark hover-text-primary">
                                        {{ $post->title }}
                                    </a>
                                </h5>

                                <p class="text-muted small line-clamp-3 mb-4">
                                    {{ Str::limit(strip_tags($post->content), 120) }}
                                </p>
                            </div>

                            <div>
                                <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-primary rounded-pill w-100 fw-bold">
                                    Đọc bài viết <i class="bi bi-arrow-right me-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Phân trang --}}
        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-journal-x text-muted opacity-50 display-1"></i>
            <h4 class="text-muted fw-bold mt-3">Chưa có bài viết tin tức nào!</h4>
            <p class="text-muted">Vui lòng quay lại sau để cập nhật bài viết mới nhất.</p>
        </div>
    @endif

</div>
@endsection
