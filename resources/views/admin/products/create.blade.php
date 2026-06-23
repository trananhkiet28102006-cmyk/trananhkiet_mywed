{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Thêm sản phẩm')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> THÊM SẢN PHẨM MỚI</h4>
    </div>
    <div class="card-body">
        
        {{-- Hiển thị thông báo lỗi từ Session Flash --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="productname" class="form-label fw-bold">Tên sản phẩm</label>
                <input type="text" 
                       name="productname" 
                       id="productname" 
                       class="form-control" 
                       value="{{ old('productname') }}" 
                       placeholder="Nhập tên sản phẩm (Ví dụ: iPhone 15 Pro Max, Dell XPS...)" 
                       required>
            </div>
            
            <div class="mb-3">
                <label for="slug" class="form-label fw-bold">Slug (Đường dẫn thân thiện)</label>
                <input type="text" 
                       name="slug" 
                       id="slug" 
                       class="form-control" 
                       value="{{ old('slug') }}" 
                       placeholder="Nhập slug (Ví dụ: iphone-15-pro-max)" 
                       required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label fw-bold">Đơn giá (VNĐ)</label>
                    <input type="number" 
                           name="price" 
                           id="price" 
                           class="form-control" 
                           value="{{ old('price') }}" 
                           placeholder="Nhập giá bán" 
                           min="0" 
                           required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pricediscount" class="form-label fw-bold">Giá khuyến mãi (VNĐ)</label>
                    <input type="number" 
                           name="pricediscount" 
                           id="pricediscount" 
                           class="form-control" 
                           value="{{ old('pricediscount', 0) }}" 
                           placeholder="Nhập giá khuyến mãi (nếu có)" 
                           min="0">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="cateid" class="form-label fw-bold">Danh mục loại sản phẩm</label>
                    <select name="cateid" id="cateid" class="form-select">
                        <option value="">-- Chọn loại sản phẩm --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->cateid }}" {{ old('cateid') == $category->cateid ? 'selected' : '' }}>
                                {{ $category->catename }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="brandid" class="form-label fw-bold">Thương hiệu</label>
                    <select name="brandid" id="brandid" class="form-select">
                        <option value="">-- Chọn thương hiệu --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brandid') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->brandname }}
                            </option>
                        @endforeach
                    </select>
                </div>
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
                <label for="description" class="form-label fw-bold">Mô tả sản phẩm</label>
                <textarea name="description" 
                          id="description" 
                          class="form-control" 
                          rows="4" 
                          placeholder="Mô tả chi tiết sản phẩm...">{{ old('description') }}</textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success px-4 me-2">
                    <i class="bi bi-save"></i> Lưu lại
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Script tự động sinh slug từ tên sản phẩm --}}
<script>
    document.getElementById('productname').addEventListener('input', function() {
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
