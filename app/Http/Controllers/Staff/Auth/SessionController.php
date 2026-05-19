<?php

namespace App\Http\Controllers\Staff\Auth;

use App\Helpers\JwtHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    /**
     * Hiển thị form đăng nhập staff.
     */
    public function create()
    {
        return view('staff.auth.signin');
    }

    /**
     * Xử lý đăng nhập staff bằng JWT tự viết.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào. Session vẫn được dùng cho flash error và old input.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tìm user active theo email và load role để đưa role_name vào JWT.
        $user = User::query()
            ->with('role')
            ->where('email', $credentials['email'])
            ->where('status', 'active')
            ->first();

        // Không dùng Auth::attempt vì dự án đang chuyển staff area sang JWT cookie.
        // Hash::check giúp so sánh password người dùng nhập với password đã hash trong database.
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])
                ->onlyInput('email');
        }

        // Tạo JWT chứa uid và thông tin user cơ bản, không chứa password.
        $token = JwtHelper::createToken($user);

        // Lưu JWT vào cookie httpOnly để JavaScript phía client không đọc được token.
        // Khi production chạy HTTPS, nên đổi secure thành true.
        return redirect()
            ->intended(route('staff.dashboard'))
            ->withCookie(cookie(
                name: 'access_token',
                value: $token,
                minutes: JwtHelper::ACCESS_TOKEN_MINUTES,
                path: '/',
                domain: null,
                secure: false,
                httpOnly: true,
                raw: false,
                sameSite: 'Lax'
            ));
    }

    /**
     * Đăng xuất staff bằng cách xóa cookie JWT.
     */
    public function destroy(Request $request)
    {
        // Không gọi Auth::logout() vì staff không còn đăng nhập bằng Laravel session auth.
        // Vẫn regenerate CSRF token để form sau logout dùng token mới.
        $request->session()->regenerateToken();

        return to_route('staff.login')
            ->withoutCookie('access_token');
    }
}
