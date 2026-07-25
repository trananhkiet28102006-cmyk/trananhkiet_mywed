@extends('admin.layouts.admin')

@section('title', 'Đổi Mật Khẩu Admin')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h4 class="mb-1 fw-bold"><i class="bi bi-shield-lock-fill me-2"></i> ĐỔI MẬT KHẨU QUẢN TRỊ</h4>
                    <p class="mb-0 small text-white-50">Cập nhật mật khẩu mới và gửi thông báo xác nhận tự động về Gmail</p>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
                            <strong>Thành công!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
                            <strong>Có lỗi xảy ra:</strong> Vui lòng kiểm tra các trường bên dưới!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.change-password.update') }}" method="POST">
                        @csrf

                        {{-- Email tài khoản đang đăng nhập --}}
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small">TÀI KHOẢN GỬI THÔNG BÁO GMAIL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope-at-fill text-primary"></i></span>
                                <input type="text" class="form-control bg-light" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="form-text small">Thông báo bảo mật sẽ được tự động gửi tới địa chỉ Gmail này sau khi đổi thành công.</div>
                        </div>

                        <hr class="my-4 text-muted">

                        {{-- Mật khẩu hiện tại --}}
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                <input type="password" 
                                       name="current_password" 
                                       id="current_password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       placeholder="Nhập mật khẩu hiện tại..." 
                                       required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Mật khẩu mới --}}
                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold">Mật khẩu mới <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" 
                                       name="new_password" 
                                       id="new_password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)..." 
                                       required>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Xác nhận mật khẩu mới --}}
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label fw-bold">Nhập lại mật khẩu mới <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                <input type="password" 
                                       name="new_password_confirmation" 
                                       id="new_password_confirmation" 
                                       class="form-control" 
                                       placeholder="Nhập lại mật khẩu mới lần 2..." 
                                       required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light px-4 rounded-pill fw-semibold">
                                <i class="bi bi-arrow-left me-1"></i> Trở về
                            </a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold">
                                <i class="bi bi-send-check-fill me-1"></i> Lưu & Gửi Email Thông Báo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
