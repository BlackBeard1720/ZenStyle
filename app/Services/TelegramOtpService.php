<?php

namespace App\Services;

use App\Models\TelegramOtp;
use App\Models\TelegramUser;
use Illuminate\Support\Carbon;

class TelegramOtpService
{
    public function __construct(
        protected TelegramService $telegramService
    ) {
    }

    public function sendOtp(string $phone): array
    {
        $telegramUser = TelegramUser::where('phone', $phone)->first();

        if (! $telegramUser) {
            return [
                'ok' => false,
                'message' => 'Số điện thoại này chưa liên kết Telegram.',
            ];
        }

        $otpCode = (string) random_int(100000, 999999);

        TelegramOtp::create([
            'phone' => $phone,
            'telegram_chat_id' => $telegramUser->telegram_chat_id,
            'otp_code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        $message = "Mã OTP ZenStyle của bạn là: {$otpCode}\nMã có hiệu lực trong 5 phút.";

        $sent = $this->telegramService->sendMessage(
            $telegramUser->telegram_chat_id,
            $message
        );

        return [
            'ok' => $sent,
            'message' => $sent
                ? 'Đã gửi OTP qua Telegram thành công.'
                : 'Không gửi được OTP qua Telegram.',
        ];
    }

    public function verifyOtp(string $phone, string $otpCode): array
    {
        $otp = TelegramOtp::where('phone', $phone)
            ->where('otp_code', $otpCode)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (! $otp) {
            return [
                'ok' => false,
                'message' => 'Mã OTP không đúng hoặc đã được sử dụng.',
            ];
        }

        if ($otp->expires_at->isPast()) {
            return [
                'ok' => false,
                'message' => 'Mã OTP đã hết hạn. Vui lòng yêu cầu gửi mã mới.',
            ];
        }

        $otp->update([
            'verified_at' => now(),
        ]);

        return [
            'ok' => true,
            'message' => 'Xác thực OTP thành công.',
        ];
    }
}
