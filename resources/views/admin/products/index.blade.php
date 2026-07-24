{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Sản phẩm')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">DANH SÁCH SẢN PHẨM</h2>

<div class="mb-3 d-flex gap-2">
    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Thêm mới
    </a>
    <a href="{{ route('admin.products.trash') }}" class="btn btn-secondary">
        <i class="bi bi-trash-fill"></i> Thùng rác
    </a>
</div>

<x-admin.alert />

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Mã SP</th>
            <th>Tên sản phẩm</th>
            <th>Đơn giá</th>
            <th>Giá khuyến mãi</th>
            <th>Danh mục</th>
            <th>Thương hiệu</th>
            <th>Ảnh đại diện</th>
            <th>Trạng thái</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $index => $item)
        <tr>
            <td>{{ ($list->currentPage() - 1) * $list->perPage() + $index + 1 }}</td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->productname }}</td>
            <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
            <td>{{ number_format($item->pricediscount, 0, ',', '.') }}đ</td>
            <td>{{ $item->category?->catename }}</td>
            <td>{{ $item->brand?->brandname ?? 'N/A' }}</td>
            <td>
                @if($item->image)
                    <img src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/products/' . $item->image) }}" alt="{{ $item->productname }}" width="60" class="img-thumbnail">
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
                    <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i> Sửa
                    </a>
                    <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
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
