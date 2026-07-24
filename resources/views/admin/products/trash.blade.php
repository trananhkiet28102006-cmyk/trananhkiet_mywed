@extends('admin.layouts.admin')

@section('title', 'Thùng rác Sản phẩm')

@section('content')
<h2 class="mb-3">THÙNG RÁC SẢN PHẨM</h2>

<div class="mb-3">
    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> Quay lại danh sách
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
            <th>Danh mục</th>
            <th>Thương hiệu</th>
            <th>Ngày xóa</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        @forelse($list as $index => $item)
        <tr>
            <td>{{ ($list->currentPage() - 1) * $list->perPage() + $index + 1 }}</td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->productname }}</td>
            <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
            <td>{{ $item->category?->catename }}</td>
            <td>{{ $item->brand?->brandname ?? 'N/A' }}</td>
            <td>{{ $item->deleted_at ? $item->deleted_at->format('d/m/Y H:i') : '' }}</td>
            <td>
                <div class="d-flex gap-1">
                    <form action="{{ route('admin.products.restore', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-info btn-sm text-white">
                            <i class="bi bi-arrow-counterclockwise"></i> Khôi phục
                        </button>
                    </form>
                    <form action="{{ route('admin.products.forceDelete', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn sản phẩm này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-x-circle"></i> Xóa vĩnh viễn
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center text-muted py-4">Thùng rác trống.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    {{ $list->links() }}
</div>
@endsection
