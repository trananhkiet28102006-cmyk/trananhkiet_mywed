<nav class="navbar navbar-expand-lg navbar-light navbar-glass"> 
    <div class="container"> 
 
        {{-- Logo --}} 
        <a class="navbar-brand navbar-brand-logo d-flex align-items-center" href="{{ route('home') }}"> 
            <i class="bi bi-cpu-fill me-2 text-primary"></i> 
            MINI<span style="color: var(--secondary);">SHOP</span>
        </a> 
 
        <button class="navbar-toggler border-0" type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbarMain"> 
            <span class="navbar-toggler-icon"></span> 
        </button> 

        <div class="collapse navbar-collapse" id="navbarMain"> 
            {{-- Menu --}} 
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4"> 
                <li class="nav-item"> 
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"> 
                        <i class="bi bi-house-door me-1"></i> Trang chủ 
                    </a> 
                </li> 

                {{-- Dropdown Danh mục --}} 
                <li class="nav-item dropdown"> 
                    <a class="nav-link dropdown-toggle" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown"> 
                        <i class="bi bi-grid-fill me-1"></i> Danh mục 
                    </a> 
                    <ul class="dropdown-menu shadow"> 
                        @forelse($categories as $cate)
                            <li> 
                                <a class="dropdown-item" href="{{ url('category/' . $cate->slug) }}">
                                    <i class="bi bi-chevron-right me-2 text-primary" style="font-size: 0.75rem;"></i>{{ $cate->catename }}
                                </a> 
                            </li> 
                        @empty
                            <li><span class="dropdown-item text-muted">Chưa có danh mục</span></li>
                        @endforelse
                    </ul> 
                </li> 
 
                {{-- Dropdown Thương hiệu --}} 
                <li class="nav-item dropdown"> 
                    <a class="nav-link dropdown-toggle" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown"> 
                        <i class="bi bi-award-fill me-1"></i> Thương hiệu 
                    </a> 
                    <ul class="dropdown-menu shadow"> 
                        @forelse($brands as $brand)
                            <li> 
                                <a class="dropdown-item" href="{{ url('brand/' . $brand->slug) }}">
                                    <i class="bi bi-patch-check me-2 text-primary" style="font-size: 0.75rem;"></i>{{ $brand->brandname }}
                                </a> 
                            </li> 
                        @empty
                            <li><span class="dropdown-item text-muted">Chưa có thương hiệu</span></li>
                        @endforelse
                    </ul> 
                </li> 

                <li class="nav-item"> 
                    <a class="nav-link {{ request()->routeIs('products.search') ? 'active' : '' }}" href="{{ route('products.search') }}">
                        <i class="bi bi-funnel-fill me-1"></i> Tất cả sản phẩm
                    </a> 
                </li> 
            </ul> 
 
            {{-- Tìm kiếm --}} 
            <form class="d-flex me-lg-3 my-2 my-lg-0" action="{{ route('products.search') }}" method="GET"> 
                <div class="input-group search-input-group">
                    <input class="form-control" 
                           type="search" 
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Tìm tên sản phẩm..."> 
                    <button class="btn btn-search" type="submit"> 
                        <i class="bi bi-search me-1"></i> Tìm
                    </button> 
                </div>
            </form> 
 
            <div class="d-flex align-items-center my-2 my-lg-0">
                {{-- Nút chuyển đổi Chế độ Sáng / Tối theo Thời gian --}}
                <button type="button" class="btn-theme-toggle" id="theme-toggle-btn" title="Chuyển đổi giao diện Sáng / Tối">
                    <i class="bi bi-sun-fill text-warning" id="theme-toggle-icon"></i>
                </button>

                {{-- Giỏ hàng --}} 
                <a href="{{ route('cart.show') }}" class="btn-cart-nav"> 
                    <i class="bi bi-bag-check-fill fs-5"></i>
                    <span>Giỏ hàng</span>
                    <span class="badge-cart-count" id="cart-count"> 
                        {{ count(session('cart', [])) }} 
                    </span> 
                </a> 
            </div> 
        </div> 
    </div> 
</nav> 
