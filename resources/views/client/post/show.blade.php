@extends('client.layouts.app')

@section('title', $post->title . ' - Tin Tức MiniShop')

@section('content')
<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0 py-2 px-3 bg-white rounded-pill border shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i class="bi bi-house-door-fill"></i> Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('posts.index') }}" class="text-decoration-none">Tin Tức</a></li>
            <li class="breadcrumb-item active text-truncate" style="max-width: 300px;" aria-current="page">{{ $post->title }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Nội dung bài viết chính --}}
        <div class="col-lg-8">
            <article class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold align-self-start mb-3" style="width: fit-content;">
                    <i class="bi bi-tag-fill me-1"></i> TIN TỨC BẢO HÀNH & CÔNG NGHỆ
                </span>

                <h1 class="fw-extrabold text-dark mb-4" style="line-height: 1.3;">{{ $post->title }}</h1>

                {{-- Thông tin tác giả & Ngày tạo --}}
                <div class="d-flex align-items-center gap-3 border-top border-bottom py-3 mb-4 text-muted small">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle fs-4 me-2 text-primary"></i>
                        <span class="fw-bold text-dark">{{ $post->user->fullname ?? 'Ban Biên Tập MiniShop' }}</span>
                    </div>
                    <span>•</span>
                    <div>
                        <i class="bi bi-calendar3 me-1"></i> {{ $post->created_at->format('H:i - d/m/Y') }}
                    </div>
                </div>

                {{-- Ảnh minh họa lớn --}}
                @if ($post->image)
                    <div class="mb-4 text-center overflow-hidden rounded-4">
                        <img src="{{ str_starts_with($post->image, 'http') ? $post->image : (str_contains($post->image, 'storage') ? asset($post->image) : asset('uploads/posts/' . $post->image)) }}" 
                             alt="{{ $post->title }}" 
                             class="img-fluid w-100 rounded-4" 
                             style="max-height: 480px; object-fit: cover;">
                    </div>
                @endif

                {{-- Nội dung chi tiết --}}
                <div class="post-content text-dark fs-5 mb-5" style="line-height: 1.8;">
                    {!! nl2br(e($post->content)) !!}
                </div>

                {{-- Footer bài viết / Thẻ Chia sẻ --}}
                <div class="border-top pt-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách tin
                    </a>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-semibold text-muted small me-2">Chia sẻ:</span>
                        <button class="btn btn-sm btn-primary rounded-circle" title="Facebook"><i class="bi bi-facebook"></i></button>
                        <button class="btn btn-sm btn-info text-white rounded-circle" title="Twitter"><i class="bi bi-twitter"></i></button>
                        <button class="btn btn-sm btn-success rounded-circle" title="Zalo"><i class="bi bi-chat-dots-fill"></i></button>
                    </div>
                </div>
            </article>
        </div>

        {{-- Cột bên phải: Bài viết liên quan --}}
        <div class="col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm p-4 bg-white position-sticky" style="top: 100px;">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-4">
                    <i class="bi bi-fire me-2 text-danger"></i> Bài Viết Mới Nhất
                </h5>

                <div class="d-flex flex-column gap-3">
                    @foreach ($relatedPosts as $rel)
                        <div class="d-flex gap-3 align-items-center pb-3 border-bottom">
                            <img src="{{ str_starts_with($rel->image, 'http') ? $rel->image : (str_contains($rel->image, 'storage') ? asset($rel->image) : asset('uploads/posts/' . $rel->image)) }}" 
                                 alt="{{ $rel->title }}" 
                                 width="80" height="60" 
                                 class="rounded-3 object-fit-cover flex-shrink-0 border">
                            <div>
                                <h6 class="fw-bold mb-1 line-clamp-2" style="font-size: 0.9rem;">
                                    <a href="{{ route('posts.show', $rel->slug) }}" class="text-decoration-none text-dark hover-text-primary">
                                        {{ $rel->title }}
                                    </a>
                                </h6>
                                <span class="text-muted small fs-7"><i class="bi bi-clock me-1"></i> {{ $rel->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
