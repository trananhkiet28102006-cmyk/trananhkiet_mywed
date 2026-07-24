<footer class="footer-dark mt-5"> 
    <div class="container"> 
        <div class="row g-4 mb-4"> 
 
            {{-- Cột 1: Giới thiệu --}} 
            <div class="col-lg-4 col-md-6 mb-3"> 
                <h5 class="navbar-brand-logo mb-3">MINI<span>SHOP</span></h5> 
                <p class="text-muted mb-3" style="font-size: 0.9rem;"> 
                    Mini Shop chuyên cung cấp các sản phẩm công nghệ, điện thoại, laptop, 
                    phụ kiện cao cấp chính hãng với chế độ bảo hành uy tín và giá cả cạnh tranh nhất thị trường. 
                </p> 
                <div class="d-flex gap-3 text-white fs-5">
                    <a href="#" class="text-white hover-opacity"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white hover-opacity"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-white hover-opacity"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white hover-opacity"><i class="bi bi-tiktok"></i></a>
                </div>
            </div> 
 
            {{-- Cột 2: Liên kết nhanh --}} 
            <div class="col-lg-2 col-md-6 mb-3"> 
                <h6 class="footer-heading">Liên kết nhanh</h6> 
                <ul class="footer-links"> 
                    <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right me-1"></i>Trang chủ</a></li> 
                    <li><a href="{{ route('products.search') }}"><i class="bi bi-chevron-right me-1"></i>Tất cả sản phẩm</a></li> 
                    <li><a href="{{ route('cart.show') }}"><i class="bi bi-chevron-right me-1"></i>Giỏ hàng</a></li> 
                    <li><a href="#"><i class="bi bi-chevron-right me-1"></i>Chính sách bảo hành</a></li> 
                </ul> 
            </div> 

            {{-- Cột 3: Hỗ trợ khách hàng --}}
            <div class="col-lg-3 col-md-6 mb-3"> 
                <h6 class="footer-heading">Hỗ trợ khách hàng</h6> 
                <ul class="footer-links"> 
                    <li><a href="#"><i class="bi bi-chevron-right me-1"></i>Hướng dẫn mua hàng</a></li> 
                    <li><a href="#"><i class="bi bi-chevron-right me-1"></i>Hình thức thanh toán</a></li> 
                    <li><a href="#"><i class="bi bi-chevron-right me-1"></i>Chính sách đổi trả</a></li> 
                    <li><a href="#"><i class="bi bi-chevron-right me-1"></i>Điều khoản dịch vụ</a></li> 
                </ul> 
            </div> 
 
            {{-- Cột 4: Liên hệ --}} 
            <div class="col-lg-3 col-md-6 mb-3"> 
                <h6 class="footer-heading">Thông tin liên hệ</h6> 
                <p class="mb-2" style="font-size: 0.9rem;"><i class="bi bi-geo-alt-fill text-primary me-2"></i>123 Nguyễn Văn A, Quận 1, TP. HCM</p> 
                <p class="mb-2" style="font-size: 0.9rem;"><i class="bi bi-telephone-fill text-primary me-2"></i>0909 999 999 (Hotline 24/7)</p> 
                <p class="mb-2" style="font-size: 0.9rem;"><i class="bi bi-envelope-fill text-primary me-2"></i>support@minishop.com</p> 
            </div> 
 
        </div> 
 
        <hr style="border-color: #334155;"> 
 
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-2" style="font-size: 0.85rem;"> 
            <p class="mb-2 mb-md-0">© 2026 <strong>Mini Shop</strong>. Tất cả quyền được bảo lưu.</p> 
            <div class="d-flex gap-3">
                <span class="badge bg-secondary">Visa</span>
                <span class="badge bg-secondary">MasterCard</span>
                <span class="badge bg-secondary">Momo</span>
                <span class="badge bg-secondary">COD</span>
            </div>
        </div> 
    </div> 
</footer> 
