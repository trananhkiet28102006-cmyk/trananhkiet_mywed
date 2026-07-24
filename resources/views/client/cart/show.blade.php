@extends('client.layouts.app') 
@section('title', 'Giỏ hàng & Thanh toán - Mini Shop') 

@section('content') 
    @php 
        $cart = Session::get('cart', []); 
        $total = 0; 
        $totalQuantity = 0; 
    @endphp 
    <div class="container py-4"> 
        <div class="d-flex align-items-center mb-4">
            <h2 class="fw-bold mb-0 text-dark">
                <i class="bi bi-cart-check-fill text-primary me-2"></i>Giỏ hàng & Thanh toán
            </h2>
        </div>

        {{-- Hiển thị lỗi validate --}} 
        @if ($errors->any()) 
            <div class="alert alert-danger shadow-sm rounded-3 mb-4"> 
                <ul class="mb-0"> 
                    @foreach ($errors->all() as $error) 
                        <li><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</li> 
                    @endforeach 
                </ul> 
            </div> 
        @endif 

        {{-- Hiển thị thông báo --}} 
        @if (session('success') || session('error')) 
            <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} shadow-sm rounded-3 mb-4"> 
                <i class="bi bi-info-circle-fill me-2"></i>{{ session('success') ?? session('error') }} 
            </div> 
        @endif 
 
        <form action="{{ route('cart.checkout') }}" method="POST"> 
            @csrf 
            <div class="row g-4"> 
                <!-- Thông tin khách hàng --> 
                <div class="col-lg-5"> 
                    <div class="card border-0 shadow-sm rounded-4"> 
                        <div class="card-header bg-dark text-white p-3 rounded-top-4"> 
                            <h5 class="card-title mb-0 fw-bold fs-6">
                                <i class="bi bi-person-lines-fill me-2"></i>1. Thông tin giao hàng
                            </h5> 
                        </div> 
                        <div class="card-body p-4"> 
                            <div class="mb-3"> 
                                <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label> 
                                <input type="text" name="fullname" class="form-control form-control-lg" placeholder="Ví dụ: Nguyễn Văn A" required 
                                       value="{{ old('fullname') }}"> 
                            </div> 
                            <div class="mb-3"> 
                                <label class="form-label fw-semibold">Số điện thoại <span class="text-danger">*</span></label> 
                                <input type="text" name="phone" class="form-control form-control-lg" placeholder="Ví dụ: 0901234567" required 
                                       value="{{ old('phone') }}"> 
                            </div> 
                            <div class="mb-3"> 
                                <label class="form-label fw-semibold">Email nhận hóa đơn</label> 
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="Ví dụ: nguyenvana@gmail.com" 
                                       value="{{ old('email') }}"> 
                            </div> 
                            <div class="mb-3"> 
                                <label class="form-label fw-semibold">Địa chỉ nhận hàng <span class="text-danger">*</span></label> 
                                <textarea name="address" rows="3" class="form-control" placeholder="Số nhà, tên đường, phường/xã, quận/huyện..." required>{{ old('address') }}</textarea> 
                            </div> 
                            <div class="mb-3"> 
                                <label class="form-label fw-semibold">Ghi chú đơn hàng (nếu có)</label> 
                                <textarea name="note" rows="2" class="form-control" placeholder="Ghi chú thêm về thời gian giao hàng, hướng dẫn chỉ đường...">{{ old('note') }}</textarea> 
                            </div> 
                        </div> 
                    </div> 
                </div> 
 
                <!-- Đơn hàng của bạn --> 
                <div class="col-lg-7"> 
                    <div class="card border-0 shadow-sm rounded-4"> 
                        <div class="card-header bg-dark text-white p-3 rounded-top-4"> 
                            <h5 class="card-title mb-0 fw-bold fs-6">
                                <i class="bi bi-bag-check-fill me-2"></i>2. Chi tiết đơn hàng của bạn
                            </h5> 
                        </div> 
                        <div class="card-body p-0"> 
                            @if (count($cart) > 0) 
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0"> 
                                        <thead class="table-light"> 
                                            <tr> 
                                                <th width="50" class="text-center">STT</th> 
                                                <th width="80">Ảnh</th> 
                                                <th>Sản phẩm</th> 
                                                <th width="110" class="text-end">Đơn giá</th> 
                                                <th width="70" class="text-center">SL</th> 
                                                <th width="120" class="text-end">Thành tiền</th> 
                                                <th width="60" class="text-center">Xóa</th> 
                                            </tr> 
                                        </thead> 
                                        <tbody> 
                                            @foreach ($cart as $item) 
                                                @php 
                                                    $subtotal = $item['price'] * $item['quantity']; 
                                                    $total += $subtotal; 
                                                    $totalQuantity += $item['quantity']; 
                                                @endphp 
     
                                                <tr> 
                                                    <td class="text-center text-muted">{{ $loop->iteration }}</td> 
                                                    <td> 
                                                        <img src="{{ asset(str_starts_with($item['image'], 'http') ? $item['image'] : (str_contains($item['image'], 'storage') ? $item['image'] : 'storage/products/' . $item['image'])) }}" 
                                                             width="60" class="rounded-3 border"> 
                                                    </td> 
                                                    <td> 
                                                        <span class="fw-bold text-dark d-block mb-1">{{ $item['productname'] }}</span> 
                                                    </td> 
                                                    <td class="text-end text-muted">{{ number_format($item['price']) }}đ</td> 
                                                    <td class="text-center"> 
                                                        <span class="badge bg-secondary px-2 py-1 fs-6">{{ $item['quantity'] }}</span> 
                                                    </td> 
                                                    <td class="text-end text-danger fw-bold"> 
                                                        {{ number_format($subtotal) }}đ 
                                                    </td> 
                                                    <td class="text-center"> 
                                                        <button type="button" 
                                                                class="btn btn-outline-danger btn-sm btn-remove-cart rounded-circle" 
                                                                data-url="{{ route('cart.remove', $item['productid']) }}"
                                                                title="Xóa khỏi giỏ"> 
                                                            <i class="bi bi-trash-fill"></i> 
                                                        </button> 
                                                    </td> 
                                                </tr> 
                                            @endforeach 
                                        </tbody> 
                                        <tfoot class="table-light"> 
                                            <tr> 
                                                <td colspan="4" class="text-end fw-bold text-secondary"> 
                                                    Tổng số lượng sản phẩm: 
                                                </td> 
                                                <td class="text-center fw-bold"> 
                                                    <span id="totalQuantity" class="badge bg-primary fs-6">{{ $totalQuantity }}</span> 
                                                </td> 
                                                <td colspan="2"></td> 
                                            </tr> 
                                            <tr> 
                                                <td colspan="5" class="text-end fw-bold text-dark fs-6"> 
                                                    Tổng tiền cần thanh toán: 
                                                </td> 
                                                <td class="text-danger text-end fw-extrabold fs-5" colspan="2"> 
                                                    <span id="total">{{ number_format($total) }} đ</span> 
                                                </td> 
                                            </tr> 
                                        </tfoot> 
                                    </table> 
                                </div>
                            @else 
                                <div class="text-center py-5">
                                    <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                                    <h5 class="mt-3 text-muted">Giỏ hàng của bạn đang trống!</h5>
                                    <p class="text-muted">Hãy chọn cho mình các sản phẩm công nghệ yêu thích nhé.</p>
                                    <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                                        <i class="bi bi-arrow-left me-1"></i> Khám phá mua sắm
                                    </a>
                                </div>
                            @endif 
                        </div> 
                    </div> 

                    @if (count($cart) > 0)
                        <div class="d-flex justify-content-between align-items-center mt-4"> 
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold"> 
                                <i class="bi bi-arrow-left me-1"></i> Mua thêm sản phẩm 
                            </a> 
                            <button class="btn btn-success btn-lg rounded-pill px-5 fw-bold shadow-lg" type="submit" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;"> 
                                <i class="bi bi-check-circle-fill me-2"></i> XÁC NHẬN ĐẶT HÀNG 
                            </button> 
                        </div> 
                    @endif
                </div> 
            </div> 
        </form> 
 
    </div> 
@endsection 
