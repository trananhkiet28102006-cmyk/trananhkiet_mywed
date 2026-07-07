<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quên mật khẩu | Admin Panel</title>

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
        }
        .forgot-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 480px;
            padding: 40px;
            transition: transform 0.3s ease;
        }
        .forgot-card:hover {
            transform: translateY(-5px);
        }
        .forgot-title {
            font-weight: 800;
            color: #38bdf8;
            letter-spacing: -0.5px;
        }
        .form-control {
            background-color: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            border-radius: 8px;
            padding: 12px 16px;
        }
        .form-control:focus {
            background-color: rgba(15, 23, 42, 0.8);
            border-color: #38bdf8;
            color: #f8fafc;
            box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.25);
        }
        .form-control::placeholder {
            color: #94a3b8;
        }
        .form-label {
            font-weight: 600;
            color: #cbd5e1;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #38bdf8 0%, #3b82f6 100%);
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4);
            transform: translateY(-2px);
        }
        .input-group-text {
            background-color: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
        }
        .back-link {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .back-link:hover {
            color: #f8fafc;
        }
    </style>
</head>
<body>

    <div class="forgot-card">
        <div class="text-center mb-4">
            <h2 class="forgot-title mb-1"><i class="bi bi-patch-question-fill"></i> QUÊN MẬT KHẨU</h2>
            <p class="text-secondary">Nhập email để nhận đường dẫn khôi phục mật khẩu</p>
        </div>

        <x-admin.alert />

        <form action="{{ route('admin.forgotpass.post') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="form-label">Email tài khoản</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           placeholder="example@domain.com" 
                           value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="bi bi-send-fill"></i> Gửi yêu cầu khôi phục
            </button>

            <div class="text-center">
                <a href="{{ route('admin.login') }}" class="back-link"><i class="bi bi-arrow-left"></i> Quay lại trang đăng nhập</a>
            </div>
        </form>
    </div>

    {{-- CDN Bootstrap JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
