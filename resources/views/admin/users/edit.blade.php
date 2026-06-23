{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Sửa người dùng')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark fw-bold">
        <h4 class="mb-0"><i class="bi bi-pencil-square"></i> CẬP NHẬT THÔNG TIN NGƯỜI DÙNG</h4>
    </div>
    <div class="card-body">
        
        {{-- Hiển thị thông báo lỗi từ Session Flash --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="fullname" class="form-label fw-bold">Họ và tên</label>
                <input type="text" 
                       name="fullname" 
                       id="fullname" 
                       class="form-control" 
                       value="{{ old('fullname', $user->fullname) }}"
                       placeholder="Nhập họ và tên (Ví dụ: Nguyễn Văn A)" 
                       required>
            </div>
            
            <div class="mb-3">
                <label for="username" class="form-label fw-bold">Tên đăng nhập</label>
                <input type="text" 
                       name="username" 
                       id="username" 
                       class="form-control" 
                       value="{{ old('username', $user->username) }}"
                       placeholder="Nhập tên đăng nhập (Ví dụ: anguyen)" 
                       required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Địa chỉ Email</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       class="form-control" 
                       value="{{ old('email', $user->email) }}"
                       placeholder="Nhập email (Ví dụ: anguyen@example.com)" 
                       required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Mật khẩu mới</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       class="form-control" 
                       placeholder="Nhập mật khẩu mới (Để trống nếu không muốn thay đổi)">
                <small class="text-muted">Chỉ nhập khi cần thay đổi mật khẩu của người dùng này.</small>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label fw-bold">Số điện thoại</label>
                <input type="text" 
                       name="phone" 
                       id="phone" 
                       class="form-control" 
                       value="{{ old('phone', $user->phone) }}"
                       placeholder="Nhập số điện thoại (Ví dụ: 0901234567)">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label fw-bold">Địa chỉ</label>
                <input type="text" 
                       name="address" 
                       id="address" 
                       class="form-control" 
                       value="{{ old('address', $user->address) }}"
                       placeholder="Nhập địa chỉ cư trú">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label fw-bold">Vai trò hệ thống</label>
                <select name="role" id="role" class="form-select">
                    <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>User (Khách hàng)</option>
                    <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Admin (Quản trị viên)</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold d-block">Trạng thái</label>
                <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', $user->status) == 1 ? 'checked' : '' }}>
                <label class="btn btn-outline-success me-2" for="active">
                    <i class="bi bi-check-circle"></i> Hoạt động
                </label>
                
                <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', $user->status) == 0 ? 'checked' : '' }}>
                <label class="btn btn-outline-danger" for="inactive">
                    <i class="bi bi-slash-circle"></i> Khóa
                </label>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success px-4 me-2">
                    <i class="bi bi-save"></i> Cập nhật
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
