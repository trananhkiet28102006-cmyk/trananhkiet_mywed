{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Thêm bài viết')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> THÊM BÀI VIẾT MỚI</h4>
    </div>
    <div class="card-body">
        
        {{-- Hiển thị thông báo lỗi từ Session Flash --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.posts.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="title" class="form-label fw-bold">Tiêu đề bài viết</label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       class="form-control" 
                       value="{{ old('title') }}" 
                       placeholder="Nhập tiêu đề bài viết..." 
                       required>
            </div>
            
            <div class="mb-3">
                <label for="slug" class="form-label fw-bold">Slug (Đường dẫn thân thiện)</label>
                <input type="text" 
                       name="slug" 
                       id="slug" 
                       class="form-control" 
                       value="{{ old('slug') }}" 
                       placeholder="Nhập slug..." 
                       required>
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label fw-bold">Tác giả (Người đăng)</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">-- Chọn tác giả --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->fullname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold d-block">Trạng thái</label>
                <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                <label class="btn btn-outline-success me-2" for="active">
                    <i class="bi bi-eye"></i> Hiển thị
                </label>
                
                <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', 1) == 0 ? 'checked' : '' }}>
                <label class="btn btn-outline-danger" for="inactive">
                    <i class="bi bi-eye-slash"></i> Ẩn
                </label>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label fw-bold">Nội dung bài viết</label>
                <textarea name="content" 
                          id="content" 
                          class="form-control" 
                          rows="6" 
                          placeholder="Nhập nội dung bài viết..." 
                          required>{{ old('content') }}</textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success px-4 me-2">
                    <i class="bi bi-save"></i> Lưu lại
                </button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Script tự động sinh slug từ tiêu đề --}}
<script>
    document.getElementById('title').addEventListener('input', function() {
        let title = this.value;
        let slug = title.toLowerCase();
        
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        slug = slug.replace(/ /gi, "-");
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        
        document.getElementById('slug').value = slug;
    });
</script>
@endsection
