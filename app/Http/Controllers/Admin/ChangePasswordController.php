<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PasswordChangedMail;

class ChangePasswordController extends Controller
{
    /**
     * Hiển thị giao diện Đổi mật khẩu Admin
     */
    public function showChangePasswordForm()
    {
        return view('admin.change_password');
    }

    /**
     * Xử lý Đổi mật khẩu và Gửi Mail thông báo về Gmail
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại!',
            'new_password.required'     => 'Vui lòng nhập mật khẩu mới!',
            'new_password.min'          => 'Mật khẩu mới phải có ít nhất 6 ký tự!',
            'new_password.confirmed'    => 'Xác nhận mật khẩu mới không trùng khớp!',
        ]);

        $user = auth()->user();

        // 1. Kiểm tra mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác!']);
        }

        // 2. Cập nhật mật khẩu mới mã hóa Bcrypt
        $user->password = Hash::make($request->new_password);
        $user->save();

        // 3. Gửi Mail thông báo về Gmail của Admin
        $mailSent = false;
        try {
            Mail::to($user->email)->send(new PasswordChangedMail($user, now()));
            $mailSent = true;
        } catch (\Exception $e) {
            Log::error("Lỗi gửi Mail Gmail: " . $e->getMessage());
        }

        $message = 'Đổi mật khẩu thành công!';
        if ($mailSent) {
            $message .= ' Email thông báo bảo mật đã được gửi trực tiếp về Gmail (' . $user->email . ').';
        } else {
            $message .= ' (Hệ thống đã lưu mật khẩu mới, nhưng không thể kết nối tới Gmail do giới hạn mạng/Cấu hình SMTP).';
        }

        return redirect()->route('admin.change-password.form')->with('success', $message);
    }
}
