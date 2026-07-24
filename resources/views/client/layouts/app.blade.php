<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mini Shop - Thế giới Công nghệ chính hãng')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- CDN Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- Gọi Vite load CSS và JS Client --}}
    @vite(['resources/css/client.css', 'resources/js/client.js'])
    
    <script>
        // Mặc định khởi tạo Giao diện Trắng Sáng
        (function() {
            var theme = localStorage.getItem('user-theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.removeAttribute('data-theme');
            }
        })();
    </script>

    @yield('styles')
</head>
<body>

    {{-- Announcement Bar --}}
    <div class="top-announcement text-center">
        <div class="container">
            <span><i class="bi bi-lightning-fill me-1"></i> GIẢM GIÁ KHỦNG ĐẾN 40% - GIAO HÀNG HỎA TỐC 2H TRONG NỘI THÀNH!</span>
        </div>
    </div>

    {{-- Navbar --}}
    @include('client._partials.navbar')

    {{-- Main Content --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('client._partials.footer')

    @yield('scripts')
</body>
</html>
