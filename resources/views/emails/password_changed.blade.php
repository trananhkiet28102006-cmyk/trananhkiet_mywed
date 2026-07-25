<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo Đổi Mật Khẩu Thành Công</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 30px; text-align: center; color: #ffffff;">
            <h1 style="margin: 0; font-size: 24px;">🔒 Thông Báo Bảo Mật</h1>
            <p style="margin: 8px 0 0 0; font-size: 14px; opacity: 0.9;">Hệ thống Quản trị MiniShop</p>
        </div>

        {{-- Content --}}
        <div style="padding: 30px; color: #334155; line-height: 1.6;">
            <p style="font-size: 16px;">Xin chào <strong>{{ $user->fullname ?? $user->name ?? 'Quản trị viên' }}</strong>,</p>

            <p style="font-size: 15px;">Mật khẩu tài khoản Quản trị Admin của bạn tại hệ thống MiniShop vừa được thay đổi thành công vào lúc:</p>

            <div style="background-color: #f8fafc; border-left: 4px solid #6366f1; padding: 15px 20px; margin: 20px 0; border-radius: 4px;">
                <p style="margin: 0; font-size: 14px; color: #475569;">
                    <strong>Tài khoản Email:</strong> {{ $user->email }}<br>
                    <strong>Thời gian đổi:</strong> {{ \Carbon\Carbon::parse($time)->format('H:i:s - d/m/Y') }}
                </p>
            </div>

            <p style="font-size: 14px; color: #64748b;">
                ⚠️ <strong>Cảnh báo bảo mật:</strong> Nếu bạn KHÔNG thực hiện hành động đổi mật khẩu này, vui lòng liên hệ ngay với Bộ phận Kỹ thuật hoặc quản trị viên hệ thống để kiểm tra và bảo vệ tài khoản.
            </p>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/login') }}" style="background-color: #4f46e5; color: #ffffff; padding: 12px 28px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 14px; display: inline-block;">
                    Đăng nhập Admin
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div style="background-color: #f1f5f9; padding: 20px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0;">Email này được gửi tự động từ Hệ thống Website MiniShop. Vui lòng không trả lời trực tiếp email này.</p>
        </div>
    </div>
</body>
</html>
