{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Bài viết')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">DANH SÁCH BÀI VIẾT</h2>

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Mã BV</th>
            <th>Tiêu đề bài viết</th>
            <th>Tác giả</th>
            <th>Ảnh đại diện</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->fullname }}</td>
            <td>
                @if($item->image && file_exists(public_path('images/' . $item->image)))
                    <img src="{{ asset('images/' . $item->image) }}" alt="Image" width="60">
                @else
                    <img src="{{ asset('images/default.png') }}" alt="Default" width="60">
                @endif
            </td>
            <td>
                @if($item->status == 1)
                    <span class="badge bg-success">Hiển thị</span>
                @else
                    <span class="badge bg-danger">Ẩn</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
