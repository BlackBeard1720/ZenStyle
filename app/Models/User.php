<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory;

    // Các thuộc tính có thể gán hàng loạt
    protected $fillable = [
        "username", // Tên đăng nhập của người dùng
        "email",    // Địa chỉ email của người dùng
        "phone",    // Số điện thoại của người dùng
        "password", // Mật khẩu đã được mã hóa của người dùng
        "role_id",  // ID của vai trò liên kết với người dùng
        "status",   // Tình trạng của người dùng (ví dụ: hoạt động, vô hiệu)
    ];

    // Định nghĩa mối quan hệ giữa User và Role
    public function role(): BelongsTo {
        return $this->belongsTo(Role::class); // Một người dùng thuộc về một vai trò
    }
}
