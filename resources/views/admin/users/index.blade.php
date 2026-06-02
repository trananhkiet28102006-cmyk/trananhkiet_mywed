{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Người dùng')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">DANH SÁCH NGƯỜI DÙNG</h2>

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Mã ND</th>
            <th>Họ và tên</th>
            <th>Tên đăng nhập</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Ảnh đại diện</th>
            <th>Vai trò</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->fullname }}</td>
            <td>{{ $item->username }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->phone }}</td>
            <td>
                {{-- Users table has no image field, so we display the default avatar --}}
                <img src="{{ asset('images/default.png') }}" alt="Default Avatar" width="40" class="rounded-circle">
            </td>
            <td>
                @if($item->role == 1)
                    <span class="badge bg-primary">Admin</span>
                @else
                    <span class="badge bg-secondary">User</span>
                @endif
            </td>
            <td>
                @if($item->status == 1)
                    <span class="badge bg-success">Hoạt động</span>
                @else
                    <span class="badge bg-danger">Khóa</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
