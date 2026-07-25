@extends('admin.layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><i class="bi bi-cart-check-fill text-primary me-2"></i>Quản lý Đơn hàng</h1>
    </div>

    {{-- Thống kê đơn hàng --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card border-0 rounded-4 shadow-sm h-100 p-3" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 text-uppercase fw-bold small">Tổng Số Đơn Hàng</span>
                        <h3 class="fw-extrabold mb-0 mt-1">{{ number_format($totalOrders) }} đơn</h3>
                        <small class="text-white-50 fs-7">Toàn bộ lịch sử đặt hàng</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-cart-check-fill fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 rounded-4 shadow-sm h-100 p-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 text-uppercase fw-bold small">Doanh Thu Đã Hoàn Thành</span>
                        <h3 class="fw-extrabold mb-0 mt-1">{{ number_format($totalRevenue) }} đ</h3>
                        <small class="text-white-50 fs-7">Tiền mặt thực tế thu về</small>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-cash-stack fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tìm kiếm & Lọc --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control" placeholder="Tìm theo mã đơn, tên hoặc số điện thoại..." value="{{ $query }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">-- Tất cả trạng thái đơn --</option>
                        <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>Chờ xử lý (Pending)</option>
                        <option value="confirmed" {{ $statusFilter === 'confirmed' ? 'selected' : '' }}>Đã xác nhận (Confirmed)</option>
                        <option value="shipping" {{ $statusFilter === 'shipping' ? 'selected' : '' }}>Đang giao hàng (Shipping)</option>
                        <option value="completed" {{ $statusFilter === 'completed' ? 'selected' : '' }}>Đã hoàn thành (Completed)</option>
                        <option value="cancelled" {{ $statusFilter === 'cancelled' ? 'selected' : '' }}>Đã hủy đơn (Cancelled)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                        <i class="bi bi-filter me-1"></i> Lọc đơn
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-light w-100 rounded-pill fw-semibold">
                        Đặt lại
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Bảng danh sách đơn hàng & Form Duyệt Hàng Loạt --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden">
        <div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold"><i class="bi bi-list-stars me-2"></i>Danh sách đơn đặt hàng</h6>
            <span class="badge bg-secondary rounded-pill px-3">Tổng {{ $orders->total() }} đơn</span>
        </div>

        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
                    <strong>Thành công!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- FORM DUYỆT HÀNG LOẠT BẰNG CHECKBOX --}}
            <form action="{{ route('admin.orders.bulkStatus') }}" method="POST" id="bulkOrderForm">
                @csrf

                {{-- Thanh công cụ Duyệt Hàng Loạt (Hiện ra khi tích chọn ít nhất 1 checkbox) --}}
                <div class="alert alert-primary border-primary rounded-4 mb-4 p-3 d-flex flex-wrap align-items-center justify-content-between gap-3" 
                     id="bulkActionBar" 
                     style="display: none !important;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check2-square fs-4 text-primary"></i>
                        <span class="fw-bold text-dark fs-6">
                            Đã tích chọn <span id="selectedCount" class="badge bg-primary fs-6 px-3 py-1 rounded-pill">0</span> đơn hàng:
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-grow-1 flex-md-grow-0">
                        <select name="status" class="form-select form-select-sm w-auto fw-bold" required>
                            <option value="">-- Chọn trạng thái cập nhật --</option>
                            <option value="confirmed">1. Đã xác nhận (Confirmed)</option>
                            <option value="shipping">2. Đang giao hàng (Shipping)</option>
                            <option value="completed">3. Đã hoàn thành (Completed)</option>
                            <option value="cancelled">4. Đã hủy đơn (Cancelled)</option>
                        </select>

                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold shadow-sm" onclick="return confirm('Bạn có chắc chắn muốn cập nhật hàng loạt các đơn hàng đã tích chọn?')">
                            <i class="bi bi-check-circle-fill me-1"></i> Duyệt Các Đơn Đã Chọn
                        </button>
                    </div>
                </div>

                {{-- Bảng dữ liệu --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th width="40" class="text-center">
                                    <input type="checkbox" id="checkAll" class="form-check-input" title="Chọn tất cả đơn hàng">
                                </th>
                                <th width="50" class="text-center">STT</th>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Số điện thoại</th>
                                <th class="text-end">Tổng tiền</th>
                                <th class="text-center">Thanh toán</th>
                                <th class="text-center">Trạng thái đơn</th>
                                <th>Ngày đặt</th>
                                <th width="120" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="form-check-input order-checkbox">
                                    </td>
                                    <td class="text-center text-muted">{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                                    <td class="fw-bold text-primary">{{ $order->order_code }}</td>
                                    <td>{{ $order->customer ? $order->customer->fullname : 'Khách vãng lai' }}</td>
                                    <td>{{ $order->customer ? $order->customer->phone : 'N/A' }}</td>
                                    <td class="text-end fw-bold text-danger">{{ number_format($order->total_amount) }} đ</td>
                                    <td class="text-center">
                                        @if($order->payment_status === 'paid')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Đã thanh toán</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Chưa thanh toán</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($order->status === 'pending')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Chờ xử lý</span>
                                        @elseif($order->status === 'confirmed')
                                            <span class="badge bg-info px-3 py-2 rounded-pill">Đã xác nhận</span>
                                        @elseif($order->status === 'shipping')
                                            <span class="badge bg-primary px-3 py-2 rounded-pill">Đang giao</span>
                                        @elseif($order->status === 'completed')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Đã hoàn thành</span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="badge bg-danger px-3 py-2 rounded-pill">Đã hủy</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="bi bi-eye"></i> Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">Không tìm thấy đơn hàng nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="d-flex justify-content-center mt-4">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Script xử lý Checkbox Chọn tất cả & Hiện thanh công cụ Duyệt Hàng Loạt --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkAll = document.getElementById("checkAll");
        const orderCheckboxes = document.querySelectorAll(".order-checkbox");
        const bulkActionBar = document.getElementById("bulkActionBar");
        const selectedCount = document.getElementById("selectedCount");

        function updateBulkBar() {
            const checkedBoxes = document.querySelectorAll(".order-checkbox:checked");
            const count = checkedBoxes.length;

            selectedCount.innerText = count;

            if (count > 0) {
                bulkActionBar.style.setProperty("display", "flex", "important");
            } else {
                bulkActionBar.style.setProperty("display", "none", "important");
            }
        }

        if (checkAll) {
            checkAll.addEventListener("change", function () {
                orderCheckboxes.forEach(cb => cb.checked = this.checked);
                updateBulkBar();
            });
        }

        orderCheckboxes.forEach(cb => {
            cb.addEventListener("change", function () {
                if (!this.checked && checkAll) {
                    checkAll.checked = false;
                } else if (document.querySelectorAll(".order-checkbox:checked").length === orderCheckboxes.length) {
                    checkAll.checked = true;
                }
                updateBulkBar();
            });
        });
    });
</script>
@endsection
