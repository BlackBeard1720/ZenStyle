<?php

namespace App\Helpers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use RuntimeException;
use Throwable;

class JwtHelper
{
    /**
     * Thời gian sống của access token, tính bằng phút.
     * Cookie đăng nhập cũng dùng đúng số phút này để token và cookie hết hạn cùng lúc.
     */
    public const ACCESS_TOKEN_MINUTES = 120;

    public static function createToken(User $user): string
    {
        // JWT_SECRET phải nằm trong .env để server ký token.
        // Không hard-code secret trong code vì sẽ khó thay đổi khi deploy.
        $secretKey = self::secretKey();
        $now = time();

        $payload = [
            // iss: nơi phát hành token, thường dùng tên app hoặc URL app.
            'iss' => config('app.name'),

            // iat: thời điểm tạo token, giúp biết token được cấp lúc nào.
            'iat' => $now,

            // exp: thời điểm hết hạn token. Firebase JWT sẽ tự báo lỗi nếu token quá hạn.
            'exp' => $now + (60 * self::ACCESS_TOKEN_MINUTES),

            // uid đặt ở cấp cao nhất để middleware lấy nhanh id user rồi query lại database.
            'uid' => $user->id,

            // Chỉ lưu thông tin cần hiển thị/kiểm tra cơ bản.
            // Tuyệt đối không đưa password, remember_token hoặc dữ liệu nhạy cảm vào JWT.
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'role_id' => $user->role_id,
                'role_name' => $user->role?->role_name,
                'status' => $user->status,
            ],
        ];

        return JWT::encode($payload, $secretKey, 'HS256');
    }

    public static function decodeToken(?string $token): ?object
    {
        // Không có token thì coi như chưa đăng nhập.
        if (!$token) {
            return null;
        }

        try {
            // Giải mã token bằng cùng secret và thuật toán đã dùng khi tạo token.
            return JWT::decode($token, new Key(self::secretKey(), 'HS256'));
        } catch (Throwable $e) {
            // Token sai chữ ký, sai định dạng hoặc hết hạn đều trả về null để middleware xử lý.
            return null;
        }
    }

    private static function secretKey(): string
    {
        $secretKey = (string) env('JWT_SECRET', '');

        if ($secretKey === '') {
            throw new RuntimeException('JWT_SECRET is not configured.');
        }

        return $secretKey;
    }
}
