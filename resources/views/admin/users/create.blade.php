{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Thêm người dùng')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> THÊM NGƯỜI DÙNG MỚI</h4>
    </div>
    <div class="card-body">
        <x-admin.alert />

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="fullname" class="form-label fw-bold">Họ và tên</label>
                <input type="text" 
                       name="fullname" 
                       id="fullname" 
                       class="form-control @error('fullname') is-invalid @enderror" 
                       value="{{ old('fullname') }}"
                       placeholder="Nhập họ và tên (Ví dụ: Nguyễn Văn A)">
                @error('fullname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="username" class="form-label fw-bold">Tên đăng nhập</label>
                <input type="text" 
                       name="username" 
                       id="username" 
                       class="form-control @error('username') is-invalid @enderror" 
                       value="{{ old('username') }}"
                       placeholder="Nhập tên đăng nhập (Ví dụ: anguyen)">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Địa chỉ Email</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}"
                       placeholder="Nhập email (Ví dụ: anguyen@example.com)">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Mật khẩu</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       placeholder="Nhập mật khẩu truy cập">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label fw-bold">Số điện thoại</label>
                <input type="text" 
                       name="phone" 
                       id="phone" 
                       class="form-control @error('phone') is-invalid @enderror" 
                       value="{{ old('phone') }}"
                       placeholder="Nhập số điện thoại (Ví dụ: 0901234567)">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label fw-bold">Địa chỉ</label>
                <input type="text" 
                       name="address" 
                       id="address" 
                       class="form-control @error('address') is-invalid @enderror" 
                       value="{{ old('address') }}"
                       placeholder="Nhập địa chỉ cư trú">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="role" class="form-label fw-bold">Vai trò hệ thống</label>
                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                    <option value="2" {{ old('role', 2) == 2 ? 'selected' : '' }}>User (Khách hàng)</option>
                    <option value="1" {{ old('role', 2) == 1 ? 'selected' : '' }}>Admin (Quản trị viên)</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold d-block">Trạng thái</label>
                <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                <label class="btn btn-outline-success me-2" for="active">
                    <i class="bi bi-check-circle"></i> Hoạt động
                </label>
                
                <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', 1) == 0 ? 'checked' : '' }}>
                <label class="btn btn-outline-danger" for="inactive">
                    <i class="bi bi-slash-circle"></i> Khóa
                </label>
                @error('status')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success px-4 me-2">
                    <i class="bi bi-save"></i> Lưu lại
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
