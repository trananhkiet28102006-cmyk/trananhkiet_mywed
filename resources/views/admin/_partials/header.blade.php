<nav class="navbar navbar-light bg-light admin-header px-3 border-bottom shadow-sm">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold text-primary"><i class="bi bi-speedometer2"></i> Admin Panel</span>
        <div class="d-flex align-items-center gap-3">
            @if(Auth::check())
                <span class="text-secondary">Xin chào <strong>{{ Auth::user()->fullname }}</strong></span>
                
                <form action="{{ route('admin.logout') }}" method="POST" class="m-0" onsubmit="return confirm('Bạn có chắc chắn muốn đăng xuất?')">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </button>
                </form>
            @else
                <a href="{{ route('admin.login') }}" class="btn btn-primary btn-sm">Đăng nhập</a>
            @endif
        </div>
    </div>
</nav>
