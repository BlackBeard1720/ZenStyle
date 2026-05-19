<?php

namespace App\Http\Middleware;

use App\Helpers\JwtHelper;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class JwtAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy JWT từ cookie access_token. Cookie này được tạo sau khi staff đăng nhập thành công.
        $token = $request->cookie('access_token');

        // Decode token. Nếu token hết hạn, sai chữ ký hoặc sai định dạng thì helper trả về null.
        $decoded = JwtHelper::decodeToken($token);

        // Không có token hợp lệ thì chuyển về màn hình đăng nhập staff.
        if (!$decoded || empty($decoded->uid)) {
            return redirect()
                ->route('staff.login')
                ->withoutCookie('access_token')
                ->withErrors([
                    'email' => 'Vui lòng đăng nhập lại.',
                ]);
        }

        // Luôn query lại user thật trong database để cập nhật trạng thái mới nhất.
        // Việc này giúp token cũ không dùng được nữa nếu tài khoản đã bị khóa/xóa.
        $user = User::query()
            ->with('role')
            ->where('id', $decoded->uid)
            ->where('status', 'active')
            ->first();

        // Nếu user không tồn tại hoặc không còn active thì xóa cookie JWT và bắt đăng nhập lại.
        if (!$user) {
            return redirect()
                ->route('staff.login')
                ->withoutCookie('access_token')
                ->withErrors([
                    'email' => 'Tài khoản không tồn tại hoặc đã bị khóa.',
                ]);
        }

        // Gắn user và payload vào request để controller/view có thể lấy bằng request()->attributes.
        $request->attributes->set('auth_user', $user);
        $request->attributes->set('jwt_payload', $decoded);

        // Set user resolver để request()->user(), Gate, Policy và middleware can vẫn dùng được.
        $request->setUserResolver(fn () => $user);
        Auth::setUser($user);

        // Share user cho toàn bộ Blade trong request hiện tại, ví dụ layout/header/sidebar.
        View::share('authUser', $user);

        return $next($request);
    }
}
