{{-- Thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Sản phẩm')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')
<h2 class="mb-3">DANH SÁCH SẢN PHẨM</h2>

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
        </tr>
    </thead>
    <tbody>
        @foreach($list as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->productname }}</td>
            <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
            <td>{{ number_format($item->pricediscount, 0, ',', '.') }}đ</td>
            <td>{{ $item->catename }}</td>
            <td>{{ $item->brandname ?? 'N/A' }}</td>
            <td>
                @if($item->image)
                    <img src="{{ asset('images/' . $item->image) }}" alt="Image" width="50">
                @else
                    <img src="{{ asset('images/default.png') }}" alt="Default" width="50">
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
