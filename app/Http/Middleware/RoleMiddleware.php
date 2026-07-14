<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Lấy thông tin user đang đăng nhập
        $user = Auth::user();

        // Kiểm tra xem role của user có nằm trong danh sách roles được phép hay không
        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        // Nếu không có quyền, trả về lỗi 403
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }
}
