@extends('admin.layouts.admin')

@section('title', 'Trash - Loại Sản phẩm')

@section('content')
<h2 class="mb-3">DANH SÁCH LOẠI SẢN PHẨM - THÙNG RÁC</h2>

<div class="mb-3">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> Quay lại danh sách
    </a>
</div>

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
        @forelse($list as $index => $item)
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
                    {{-- Khôi phục --}}
                    <form action="{{ route('admin.categories.restore', $item->cateid) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="bi bi-arrow-counterclockwise"></i> Khôi phục
                        </button>
                    </form>

                    {{-- Xóa vĩnh viễn --}}
                    <form action="{{ route('admin.categories.forceDelete', $item->cateid) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn loại sản phẩm này? Thao tác này không thể hoàn tác!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Xóa vĩnh viễn
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center text-muted">Thùng rác trống.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    {{ $list->links() }}
</div>
@endsection
