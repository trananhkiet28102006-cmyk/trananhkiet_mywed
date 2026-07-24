@extends('admin.layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Đơn hàng</h1>
    </div>

    {{-- Thống kê đơn hàng --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card border-start border-primary border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng số đơn hàng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalOrders }} đơn hàng
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cart-check fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-start border-success border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tổng doanh thu (Đã hoàn thành)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalRevenue) }} đ
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cash-stack fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tìm kiếm & Lọc --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="q" class="form-control" placeholder="Tìm theo mã đơn, tên, sđt khách..." value="{{ $query }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">-- Trạng thái đơn hàng --</option>
                        <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>Chờ xử lý (Pending)</option>
                        <option value="confirmed" {{ $statusFilter === 'confirmed' ? 'selected' : '' }}>Đã xác nhận (Confirmed)</option>
                        <option value="shipping" {{ $statusFilter === 'shipping' ? 'selected' : '' }}>Đang giao hàng (Shipping)</option>
                        <option value="completed" {{ $statusFilter === 'completed' ? 'selected' : '' }}>Đã hoàn thành (Completed)</option>
                        <option value="cancelled" {{ $statusFilter === 'cancelled' ? 'selected' : '' }}>Đã hủy đơn (Cancelled)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Lọc đơn
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100">
                        Đặt lại
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Bảng danh sách đơn hàng --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white py-3">
            <h6 class="m-0 font-weight-bold">Danh sách đơn đặt hàng</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái đơn</th>
                            <th>Ngày đặt</th>
                            <th width="120">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                                <td class="fw-bold text-primary">{{ $order->order_code }}</td>
                                <td>{{ $order->customer ? $order->customer->fullname : 'Khách vãng lai' }}</td>
                                <td>{{ $order->customer ? $order->customer->phone : 'N/A' }}</td>
                                <td class="text-end fw-bold text-danger">{{ number_format($order->total_amount) }} đ</td>
                                <td>
                                    @if($order->payment_status === 'paid')
                                        <span class="badge bg-success">Đã thanh toán</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->status === 'pending')
                                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                    @elseif($order->status === 'confirmed')
                                        <span class="badge bg-info">Đã xác nhận</span>
                                    @elseif($order->status === 'shipping')
                                        <span class="badge bg-primary">Đang giao</span>
                                    @elseif($order->status === 'completed')
                                        <span class="badge bg-success">Đã hoàn thành</span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">Không tìm thấy đơn hàng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
