<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm"> 
    <div class="container"> 
 
        {{-- Logo --}} 
        <a class="navbar-brand fw-bold" href="{{ route('home') }}"> 
            Mini Shop 
        </a> 
 
        <button class="navbar-toggler" type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbarMain"> 
            <span class="navbar-toggler-icon"></span> 
        </button> 
        <div class="collapse navbar-collapse" id="navbarMain"> 
            {{-- Menu --}} 
            <ul class="navbar-nav me-auto"> 
                <li class="nav-item"> 
                    <a class="nav-link active" href="{{ route('home') }}"> 
                        Trang chủ 
                    </a> 
                </li> 
                {{-- Dropdown Danh mục --}} 
                <li class="nav-item dropdown"> 
                    <a class="nav-link dropdown-toggle" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown"> 
                        Danh mục 
                    </a> 
                    <ul class="dropdown-menu"> 
                        <li> 
                            <a class="dropdown-item" href="#">Laptop</a> 
                        </li> 
                        <li> 
                            <a class="dropdown-item" href="#">Chuột</a> 
                        </li> 
                        <li> 
                            <a class="dropdown-item" href="#">Bàn phím</a> 
                        </li> 
                        <li> 
                            <a class="dropdown-item" href="#">Tai nghe</a> 
                        </li> 
                        <li><hr class="dropdown-divider"></li> 
                        <li> 
                            <a class="dropdown-item" href="#"> 
                                Xem tất cả 
                            </a> 
                        </li> 
                    </ul> 
                </li> 
 
                <li class="nav-item"> 
                    <a class="nav-link" href="#">Liên hệ</a> 
                </li> 
            </ul> 
 
            {{-- Tìm kiếm --}} 
            <form class="d-flex me-3"> 
                <input class="form-control me-2" 
                       type="search" 
                       placeholder="Tìm sản phẩm..."> 
 
                <button class="btn btn-outline-primary"> 
                    Tìm 
                </button> 
            </form> 
 
            {{-- Giỏ hàng --}} 
            <a href="#" class="btn btn-outline-success"> 
                  Giỏ hàng (0) 
            </a> 
        </div> 
    </div> 
</nav> 
