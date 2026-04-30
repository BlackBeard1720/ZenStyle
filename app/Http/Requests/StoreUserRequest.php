<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required', // tên đăng nhập bắt buộc
            'email' => 'required|email|unique:users,email', // email bắt buộc, đúng định dạng, không trùng
            'password' => 'required|min:6', // mật khẩu tối thiểu 6 ký tự
            'role_id' => 'required', // phải chọn role (admin, receptionist, stylist)
        ];
    }
}
