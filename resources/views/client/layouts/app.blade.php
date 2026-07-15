<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mini Shop')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Gọi Vite load CSS và JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- CDN Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
    @yield('styles')
</head>
<body>

    {{-- Header --}}
    @include('client._partials.header')

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
