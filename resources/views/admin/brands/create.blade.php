{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Thêm thương hiệu')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> THÊM THƯƠNG HIỆU MỚI</h4>
    </div>
    <div class="card-body">
        
        {{-- Hiển thị thông báo lỗi từ Session Flash --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.brands.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="brandname" class="form-label fw-bold">Tên thương hiệu</label>
                <input type="text" 
                       name="brandname" 
                       id="brandname" 
                       class="form-control" 
                       value="{{ old('brandname') }}" 
                       placeholder="Nhập tên thương hiệu (Ví dụ: Apple, Samsung...)" 
                       required>
            </div>
            
            <div class="mb-3">
                <label for="slug" class="form-label fw-bold">Slug (Đường dẫn thân thiện)</label>
                <input type="text" 
                       name="slug" 
                       id="slug" 
                       class="form-control" 
                       value="{{ old('slug') }}" 
                       placeholder="Nhập slug (Ví dụ: apple, samsung)" 
                       required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success px-4 me-2">
                    <i class="bi bi-save"></i> Lưu lại
                </button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Script tự động sinh slug từ tên thương hiệu --}}
<script>
    document.getElementById('brandname').addEventListener('input', function() {
        let title = this.value;
        let slug = title.toLowerCase();
        
        // Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        
        // Xóa các ký tự đặc biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        
        // Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        
        // Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        
        // Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        
        document.getElementById('slug').value = slug;
    });
</script>
@endsection
