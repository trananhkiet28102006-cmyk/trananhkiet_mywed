@extends('client.layouts.app')

@section('title', 'Tra Cứu & Lịch Sử Đơn Hàng Real-Time - MiniShop')

@section('content')
<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0 py-2 px-3 bg-white rounded-pill border shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i class="bi bi-house-door-fill"></i> Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tra cứu & Lịch sử đơn hàng</li>
        </ol>
    </nav>

    {{-- Header Banner --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);">
        <div class="card-body p-4 p-md-5 text-center">
            <span class="badge bg-white text-success px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm">
                <i class="bi bi-clock-history me-1"></i> THEO DÕI ĐƠN HÀNG THỜI GIAN THỰC (REAL-TIME)
            </span>
            <h1 class="display-6 fw-extrabold mb-3 text-white">Tra Cứu Lịch Sử & Tiến Trình Đơn Hàng</h1>
            <p class="text-white-50 mx-auto mb-4" style="max-width: 600px;">
                Nhập số điện thoại hoặc mã đơn hàng của bạn để theo dõi tiến trình giao hàng trực tiếp được cập nhật theo thời gian thực chuẩn giờ Việt Nam.
            </p>

            {{-- Form Tìm Kiếm Đơn Hàng --}}
            <form action="{{ route('orders.history') }}" method="GET" class="mx-auto" style="max-width: 550px;">
                <div class="input-group input-group-lg bg-white p-2 rounded-pill shadow-lg border-0">
                    <input type="text" 
                           name="search" 
                           class="form-control border-0 rounded-pill ps-4 text-dark fw-semibold" 
                           placeholder="Nhập số điện thoại hoặc Mã đơn (Ví dụ: DH178...)" 
                           value="{{ $search }}" 
                           required>
                    <button type="submit" class="btn btn-dark rounded-pill px-4 fw-bold">
                        <i class="bi bi-search me-1"></i> Tra Cứu
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Kết quả tra cứu --}}
    @if ($search)
        <div class="mb-4">
            <h4 class="fw-bold text-dark mb-1">Kết quả tra cứu cho: <span class="text-primary">"{{ $search }}"</span></h4>
            <p class="text-muted small">Trạng thái đơn hàng bên dưới sẽ tự động cập nhật thời gian thực khi Admin duyệt đơn.</p>
        </div>

        @if ($orders->count() > 0)
            <div class="d-flex flex-column gap-4 mb-5">
                @foreach ($orders as $order)
                    @php
                        $statusMap = [
                            'pending'   => ['label' => 'Chờ xử lý', 'color' => 'warning', 'step' => 1],
                            'confirmed' => ['label' => 'Đã xác nhận', 'color' => 'info', 'step' => 2],
                            'shipping'  => ['label' => 'Đang giao hàng', 'color' => 'primary', 'step' => 3],
                            'completed' => ['label' => 'Đã hoàn thành', 'color' => 'success', 'step' => 4],
                            'cancelled' => ['label' => 'Đã hủy đơn', 'color' => 'danger', 'step' => 0],
                        ];
                        $st = $statusMap[$order->status] ?? ['label' => $order->status, 'color' => 'secondary', 'step' => 1];
                    @endphp

                    <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden order-card-item" id="order-card-{{ $order->id }}" data-order-id="{{ $order->id }}">
                        {{-- Top Header Đơn Hàng --}}
                        <div class="card-header bg-light p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom">
                            <div>
                                <span class="text-muted small d-block mb-1">MÃ ĐƠN HÀNG</span>
                                <h5 class="fw-extrabold text-primary mb-0">{{ $order->order_code }}</h5>
                            </div>

                            <div class="text-end">
                                <span class="text-muted small d-block mb-1">NGÀY ĐẶT (GIỜ VIỆT NAM TRỰC TIẾP)</span>
                                <span class="fw-bold text-dark"><i class="bi bi-clock-fill text-success me-1"></i>{{ $order->created_at->format('H:i:s - d/m/Y') }}</span>
                            </div>

                            <div>
                                <span class="badge bg-{{ $st['color'] }} px-3 py-2 rounded-pill fs-6 fw-bold shadow-sm order-status-badge" id="badge-{{ $order->id }}">
                                    <i class="bi bi-arrow-repeat spin me-1 d-none" id="spin-{{ $order->id }}"></i>
                                    <span id="label-{{ $order->id }}">{{ $st['label'] }}</span>
                                </span>
                            </div>
                        </div>

                        {{-- Body: Tiến trình Stepper Real-Time --}}
                        <div class="card-body p-4">
                            {{-- Stepper Tiến trình --}}
                            <div class="mb-4 p-3 bg-light rounded-4 border">
                                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-diagram-3-fill text-primary me-2"></i> Tiến Trình Giao Hàng Thời Gian Thực:</h6>
                                
                                <div class="position-relative my-4 px-2" id="stepper-box-{{ $order->id }}">
                                    @if ($order->status === 'cancelled')
                                        <div class="alert alert-danger mb-0 rounded-3">
                                            <i class="bi bi-x-circle-fill me-2 fs-5"></i> <strong>Đơn hàng này đã bị hủy.</strong> Vui lòng liên hệ hỗ trợ nếu bạn có thắc mắc.
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-between position-relative z-1 text-center">
                                            {{-- Bước 1 --}}
                                            <div class="step-item {{ $st['step'] >= 1 ? 'text-primary fw-bold' : 'text-muted' }}" id="step1-{{ $order->id }}">
                                                <div class="step-icon rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 {{ $st['step'] >= 1 ? 'bg-primary text-white shadow' : 'bg-white border text-muted' }}" style="width: 42px; height: 42px;">
                                                    <i class="bi bi-receipt fs-5"></i>
                                                </div>
                                                <span class="small d-block">1. Đặt đơn</span>
                                            </div>

                                            {{-- Bước 2 --}}
                                            <div class="step-item {{ $st['step'] >= 2 ? 'text-primary fw-bold' : 'text-muted' }}" id="step2-{{ $order->id }}">
                                                <div class="step-icon rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 {{ $st['step'] >= 2 ? 'bg-primary text-white shadow' : 'bg-white border text-muted' }}" style="width: 42px; height: 42px;">
                                                    <i class="bi bi-check-circle-fill fs-5"></i>
                                                </div>
                                                <span class="small d-block">2. Đã xác nhận</span>
                                            </div>

                                            {{-- Bước 3 --}}
                                            <div class="step-item {{ $st['step'] >= 3 ? 'text-primary fw-bold' : 'text-muted' }}" id="step3-{{ $order->id }}">
                                                <div class="step-icon rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 {{ $st['step'] >= 3 ? 'bg-primary text-white shadow' : 'bg-white border text-muted' }}" style="width: 42px; height: 42px;">
                                                    <i class="bi bi-truck fs-5"></i>
                                                </div>
                                                <span class="small d-block">3. Đang giao hàng</span>
                                            </div>

                                            {{-- Bước 4 --}}
                                            <div class="step-item {{ $st['step'] >= 4 ? 'text-success fw-bold' : 'text-muted' }}" id="step4-{{ $order->id }}">
                                                <div class="step-icon rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 {{ $st['step'] >= 4 ? 'bg-success text-white shadow' : 'bg-white border text-muted' }}" style="width: 42px; height: 42px;">
                                                    <i class="bi bi-house-door-fill fs-5"></i>
                                                </div>
                                                <span class="small d-block">4. Hoàn thành</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Danh sách sản phẩm trong đơn --}}
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <h6 class="fw-bold text-dark mb-3">Sản phẩm đã đặt:</h6>
                                    <div class="d-flex flex-column gap-2">
                                        @foreach ($order->items as $item)
                                            <div class="d-flex align-items-center gap-3 p-2 bg-light rounded-3 border">
                                                <img src="{{ asset(str_starts_with($item->product->image ?? '', 'http') ? $item->product->image : (str_contains($item->product->image ?? '', 'storage') ? $item->product->image : 'storage/products/' . ($item->product->image ?? ''))) }}" 
                                                     width="50" height="50" class="rounded-2 object-fit-cover border">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0 fw-bold text-dark small">{{ $item->product->productname ?? 'Sản phẩm' }}</h6>
                                                    <span class="text-muted small">{{ number_format($item->price) }}đ × {{ $item->quantity }}</span>
                                                </div>
                                                <span class="fw-bold text-danger small me-2">{{ number_format($item->price * $item->quantity) }}đ</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="p-3 bg-light rounded-4 border h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-3">Thông tin nhận hàng:</h6>
                                            <p class="mb-1 small"><strong>Người nhận:</strong> {{ $order->customer->fullname ?? 'N/A' }}</p>
                                            <p class="mb-1 small"><strong>Số điện thoại:</strong> {{ $order->customer->phone ?? 'N/A' }}</p>
                                            <p class="mb-1 small"><strong>Địa chỉ:</strong> {{ $order->customer->address ?? 'N/A' }}</p>
                                            <p class="mb-1 small"><strong>Thanh toán:</strong> <span class="badge bg-secondary" id="payment-badge-{{ $order->id }}">{{ $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</span></p>
                                        </div>
                                        <div class="border-top pt-2 mt-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-dark">Tổng tiền thanh toán:</span>
                                                <span class="fs-5 fw-extrabold text-danger">{{ number_format($order->total_amount) }}đ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border mb-5">
                <i class="bi bi-search text-muted opacity-50 display-1"></i>
                <h4 class="text-muted fw-bold mt-3">Không tìm thấy đơn hàng nào!</h4>
                <p class="text-muted">Vui lòng kiểm tra lại Số điện thoại hoặc Mã đơn hàng đã nhập.</p>
            </div>
        @endif
    @else
        <div class="text-center py-5 bg-white rounded-4 shadow-sm border mb-5">
            <i class="bi bi-clock-history text-primary opacity-50 display-1"></i>
            <h4 class="text-dark fw-bold mt-3">Nhập Số Điện Thoại Để Tra Cứu</h4>
            <p class="text-muted mx-auto" style="max-width: 500px;">
                Ví dụ nhập: <strong>0901234567</strong> hoặc Mã đơn hàng <strong>DH...</strong> vào ô tìm kiếm ở trên để xem tiến trình giao hàng trực tiếp.
            </p>
        </div>
    @endif

</div>

{{-- JavaScript AJAX Polling Real-Time Auto-Update --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const orderCards = document.querySelectorAll(".order-card-item");
        if (orderCards.length === 0) return;

        // Hàm gọi API kiểm tra trạng thái đơn hàng mỗi 4 giây
        function pollOrderStatus() {
            orderCards.forEach(card => {
                const orderId = card.dataset.orderId;
                if (!orderId) return;

                fetch(`/orders/status-check/${orderId}`, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        const labelEl = document.getElementById(`label-${orderId}`);
                        const badgeEl = document.getElementById(`badge-${orderId}`);
                        const paymentBadgeEl = document.getElementById(`payment-badge-${orderId}`);

                        if (labelEl) labelEl.innerText = data.status_label;
                        if (paymentBadgeEl) paymentBadgeEl.innerText = data.payment_status;

                        if (badgeEl) {
                            badgeEl.className = `badge bg-${data.status_color} px-3 py-2 rounded-pill fs-6 fw-bold shadow-sm order-status-badge`;
                        }

                        // Cập nhật các bước Stepper
                        const step = data.step;
                        for (let i = 1; i <= 4; i++) {
                            const stepEl = document.getElementById(`step${i}-${orderId}`);
                            if (stepEl) {
                                const iconEl = stepEl.querySelector('.step-icon');
                                if (i <= step) {
                                    stepEl.className = `step-item ${i === 4 ? 'text-success' : 'text-primary'} fw-bold`;
                                    if (iconEl) iconEl.className = `step-icon rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 ${i === 4 ? 'bg-success' : 'bg-primary'} text-white shadow`;
                                } else {
                                    stepEl.className = 'step-item text-muted';
                                    if (iconEl) iconEl.className = 'step-icon rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 bg-white border text-muted';
                                }
                            }
                        }
                    }
                })
                .catch(err => console.error("Lỗi polling:", err));
            });
        }

        // Chạy tự động cập nhật mỗi 4 giây
        setInterval(pollOrderStatus, 4000);
    });
</script>
@endsection
