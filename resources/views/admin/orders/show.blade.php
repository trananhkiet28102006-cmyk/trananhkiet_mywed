@extends('admin.layouts.admin')

@section('title', 'Chi tiết đơn hàng: ' . $order->order_code)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết đơn hàng: {{ $order->order_code }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Cột trái: Thông tin khách hàng & Cập nhật trạng thái -->
        <div class="col-md-5 mb-4">
            {{-- Thông tin khách hàng --}}
            <div class="card shadow mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <h6 class="m-0 font-weight-bold">Thông tin khách hàng mua</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td width="150" class="fw-bold text-muted">Họ và tên:</td>
                            <td>{{ $order->customer ? $order->customer->fullname : 'Khách vãng lai' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Số điện thoại:</td>
                            <td>{{ $order->customer ? $order->customer->phone : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Email:</td>
                            <td>{{ $order->customer && $order->customer->email ? $order->customer->email : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Địa chỉ nhận:</td>
                            <td>{{ $order->customer ? $order->customer->address : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Ghi chú đặt:</td>
                            <td><span class="text-danger italic">{{ $order->note ?: 'Không có ghi chú.' }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Form cập nhật trạng thái đơn --}}
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 font-weight-bold"><i class="bi bi-gear-fill me-1"></i>Xử lý Đơn hàng</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Trạng thái đơn hàng</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý (Pending)</option>
                                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận (Confirmed)</option>
                                <option value="shipping" {{ $order->status === 'shipping' ? 'selected' : '' }}>Đang giao hàng (Shipping)</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Đã hoàn thành (Completed)</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy đơn (Cancelled)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Trạng thái thanh toán</label>
                            <select name="payment_status" class="form-select">
                                <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Chưa thanh toán (Unpaid)</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Đã thanh toán (Paid)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            <i class="bi bi-save"></i> Cập nhật trạng thái
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Cột phải: Sản phẩm đã mua -->
        <div class="col-md-7 mb-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white py-3">
                    <h6 class="m-0 font-weight-bold">Sản phẩm đã đặt mua</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0" style="border: none;">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="text-center">STT</th>
                                    <th width="80">Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th width="100" class="text-end">Đơn giá</th>
                                    <th width="70" class="text-center">SL</th>
                                    <th width="120" class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalQty = 0;
                                @endphp
                                @foreach($order->items as $item)
                                    @php
                                        $sub = $item->price * $item->quantity;
                                        $totalQty += $item->quantity;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset(str_starts_with($item->product->image, 'http') ? $item->product->image : (str_contains($item->product->image, 'storage') ? $item->product->image : 'storage/products/' . $item->product->image)) }}" 
                                                 width="60" class="img-thumbnail">
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $item->product->productname }}</span>
                                        </td>
                                        <td class="text-end">{{ number_format($item->price) }} đ</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold text-danger">{{ number_format($sub) }} đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Tổng số lượng mua:</td>
                                    <td class="text-center fw-bold">{{ $totalQty }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold text-primary">Tổng tiền thanh toán:</td>
                                    <td class="text-end fw-bold text-danger fs-5">{{ number_format($order->total_amount) }} đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
