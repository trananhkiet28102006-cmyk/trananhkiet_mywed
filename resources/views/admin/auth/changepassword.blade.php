@extends('admin.layouts.admin')

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="bi bi-key-fill me-2"></i>ĐỔI MẬT KHẨU</h5>
                </div>
                <div class="card-body p-4">
                    
                    <x-admin.alert />

                    <form action="{{ route('admin.change-password.post') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="old_password" class="form-label fw-bold">Mật khẩu cũ <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                                <input type="password" 
                                       name="old_password" 
                                       id="old_password" 
                                       class="form-control @error('old_password') is-invalid @enderror" 
                                       placeholder="Nhập mật khẩu hiện tại...">
                                @error('old_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold">Mật khẩu mới <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" 
                                       name="new_password" 
                                       id="new_password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)...">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label fw-bold">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-fill-check"></i></span>
                                <input type="password" 
                                       name="new_password_confirmation" 
                                       id="new_password_confirmation" 
                                       class="form-control" 
                                       placeholder="Nhập lại mật khẩu mới...">
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle-fill me-1"></i> Xác nhận đổi mật khẩu
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary px-4">
                                <i class="bi bi-x-circle-fill me-1"></i> Hủy bỏ
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
