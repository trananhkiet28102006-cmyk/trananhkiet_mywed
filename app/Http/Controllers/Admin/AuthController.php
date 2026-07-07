<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login()
    {
        // Kiểm tra đã lưu đăng nhập chưa thì chuyển đến Dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    // Xử lý đăng nhập
    public function postLogin(Request $request)
    {
        // validate - kiểm tra dữ liệu đầu vào
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'username' => 'Tên đăng nhập',
                'password' => 'Mật khẩu',
            ]
        );

        // Lấy thông tin user
        $user = User::where('username', $request->username)->first();

        // Nếu không tìm thấy người dùng
        if (!$user) {
            return back()
                ->with('error', 'Tên đăng nhập không tồn tại.')
                ->withInput();
        }

        // Kiểm tra mật khẩu
        $check = Hash::check($request->password, $user->password);
        if (!$check) {
            return back()
                ->with('error', 'Mật khẩu không đúng.')
                ->withInput();
        }

        // Kiểm tra trạng thái hoạt động của tài khoản
        if ($user->status == 0) {
            return back()
                ->with('error', 'Tài khoản của bạn đã bị khóa.')
                ->withInput();
        }

        // Biến ghi nhớ tài khoản
        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);

        // Điều hướng về URL mong muốn hoặc Dashboard
        return redirect()->intended(route('admin.dashboard'))->with('success', 'Đăng nhập thành công!');
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        // Đăng xuất user
        Auth::logout();

        // Xóa session hiện tại
        $request->session()->invalidate();

        // Tạo lại CSRF token mới
        $request->session()->regenerateToken();

        // Điều hướng về trang login
        return redirect()->route('admin.login')->with('success', 'Đăng xuất thành công!');
    }

    // Hiển thị trang đổi mật khẩu
    public function changePassword()
    {
        return view('admin.auth.changepassword');
    }

    // Xử lý đổi mật khẩu
    public function postChangePassword(Request $request)
    {
        $request->validate(
            [
                'old_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ],
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'confirmed' => 'Mật khẩu mới và mật khẩu xác nhận không khớp.',
            ],
            [
                'old_password' => 'Mật khẩu cũ',
                'new_password' => 'Mật khẩu mới',
            ]
        );

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Mật khẩu cũ không chính xác.');
        }

        // Cập nhật mật khẩu mới
        $user->password = $request->new_password;
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    // Hiển thị trang Quên mật khẩu
    public function forgotPassword()
    {
        return view('admin.auth.forgotpassword');
    }

    // Xử lý quên mật khẩu
    public function postForgotPassword(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'required' => ':attribute không được để trống.',
                'email' => ':attribute không hợp lệ.',
                'exists' => ':attribute này không tồn tại trên hệ thống.',
            ],
            [
                'email' => 'Email',
            ]
        );

        // Giả lập gửi email thành công
        return back()->with('success', 'Đường dẫn khôi phục mật khẩu đã được gửi qua email của bạn!');
    }
}
