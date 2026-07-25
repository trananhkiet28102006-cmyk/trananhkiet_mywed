<div class="admin-sidebar bg-dark text-white p-3 vh-100">
    <h4 class="mb-4 text-center border-bottom pb-3">
        <i class="bi bi-speedometer2 me-2"></i>Admin Panel
    </h4>
    <ul class="nav flex-column gap-2">
        <li class="nav-item">
            <a class="nav-link text-white py-2 px-3 rounded hover-bg" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white py-2 px-3 rounded hover-bg" href="{{ route('admin.categories.index') }}">
                <i class="bi bi-tags me-2"></i> Quản lý danh mục
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white py-2 px-3 rounded hover-bg" href="{{ route('admin.brands.index') }}">
                <i class="bi bi-award me-2"></i> Quản lý thương hiệu
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white py-2 px-3 rounded hover-bg" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people me-2"></i> Quản lý người dùng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white py-2 px-3 rounded hover-bg" href="{{ route('admin.products.index') }}">
                <i class="bi bi-box-seam me-2"></i> Quản lý sản phẩm
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white py-2 px-3 rounded hover-bg" href="{{ route('admin.posts.index') }}">
                <i class="bi bi-journal-text me-2"></i> Quản lý bài viết
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white py-2 px-3 rounded hover-bg" href="{{ route('admin.orders.index') }}">
                <i class="bi bi-cart me-2"></i> Quản lý đơn hàng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white py-2 px-3 rounded hover-bg" href="{{ route('admin.change-password.form') }}">
                <i class="bi bi-key-fill me-2 text-warning"></i> Đổi mật khẩu
            </a>
        </li>
    </ul>
</div>
