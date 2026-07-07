{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Loại Sản phẩm')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">DANH SÁCH LOẠI SẢN PHẨM</h2>

<a href="{{ route('admin.categories.create') }}" class="btn btn-success mb-3">
    <i class="bi bi-plus-lg"></i> Thêm mới
</a>

<x-admin.alert />

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Mã loại</th>
            <th>Tên loại</th>
            <th>Slug</th>
            <th>Ảnh đại diện</th>
            <th>Trạng thái</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $index => $item)
        <tr>
            <td>{{ ($list->currentPage() - 1) * $list->perPage() + $index + 1 }}</td>
            <td>{{ $item->cateid }}</td>
            <td>{{ $item->catename }}</td>
            <td>{{ $item->slug }}</td>
            <td>
                @if($item->image)
                    <img src="{{ asset('storage/categories/' . $item->image) }}" alt="{{ $item->catename }}" width="60" class="img-thumbnail">
                @else
                    <img src="{{ asset('images/default.png') }}" alt="Default" width="60" class="img-thumbnail">
                @endif
            </td>
            <td>
                @if($item->status == 1)
                    <span class="badge bg-success">Hiển thị</span>
                @else
                    <span class="badge bg-danger">Ẩn</span>
                @endif
            </td>
            <td>
                <div class="d-flex gap-1">
                    <a href="{{ route('admin.categories.edit', $item->cateid) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i> Sửa
                    </a>
                    <form action="{{ route('admin.categories.destroy', $item->cateid) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa loại sản phẩm này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Xóa
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    {{ $list->links() }}
</div>
@endsection
