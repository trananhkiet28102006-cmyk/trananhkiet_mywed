<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Lỗi máy chủ hệ thống</title>
    
    {{-- CDN Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- CDN Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            color: #f8fafc;
            margin: 0;
        }
        .error-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 520px;
            padding: 50px 40px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .error-card:hover {
            transform: translateY(-5px);
        }
        .error-icon {
            font-size: 5rem;
            color: #f97316;
            margin-bottom: 20px;
            animation: spin 6s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .error-code {
            font-size: 3.5rem;
            font-weight: 900;
            color: #f8fafc;
            letter-spacing: -1px;
            margin-bottom: 10px;
        }
        .error-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #38bdf8;
            margin-bottom: 15px;
        }
        .error-message {
            color: #94a3b8;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 35px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #38bdf8 0%, #3b82f6 100%);
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="error-card">
        <div class="error-icon">
            <i class="bi bi-gear-wide-connected"></i>
        </div>
        <div class="error-code">500</div>
        <div class="error-title">LỖI HỆ THỐNG MÁY CHỦ</div>
        <p class="error-message">
            Máy chủ đã gặp lỗi không mong muốn khi xử lý yêu cầu này.<br>
            Chúng tôi đang nỗ lực khắc phục vấn đề. Vui lòng quay lại sau.
        </p>
        
        @if(Auth::check())
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left-circle me-2"></i> Quay lại Dashboard
            </a>
        @else
            <a href="/" class="btn btn-primary">
                <i class="bi bi-house-door-fill me-2"></i> Quay về Trang chủ
            </a>
        @endif
    </div>

    {{-- CDN Bootstrap JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
