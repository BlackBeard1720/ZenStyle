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
        $normalizedPhone = $this->normalizePhone($phone);

        if (! $normalizedPhone) {
            return [
                'ok' => false,
                'message' => 'Invalid phone number format.',
            ];
        }

        $telegramUser = TelegramUser::query()->where('phone', $normalizedPhone)->first();

        if (! $telegramUser) {
            return [
                'ok' => false,
                'message' => 'This phone number is not linked to Telegram yet.',
            ];
        }

        return $this->generateAndSendOtpForTelegramUser($telegramUser);
    }

    public function generateAndSendOtpForTelegramUser(TelegramUser $telegramUser): array
    {
        $normalizedPhone = $this->normalizePhone($telegramUser->phone);

        if (! $normalizedPhone) {
            return [
                'ok' => false,
                'message' => 'Invalid phone number format.',
            ];
        }

        return $this->generateAndSendOtp($normalizedPhone, (string) $telegramUser->telegram_chat_id);
    }

    public function generateAndSendOtp(string $phone, string|int $chatId): array
    {
        $normalizedPhone = $this->normalizePhone($phone);

        if (! $normalizedPhone) {
            return [
                'ok' => false,
                'message' => 'Invalid phone number format.',
            ];
        }

        TelegramOtp::query()
            ->where('phone', $normalizedPhone)
            ->whereNull('verified_at')
            ->update(['expires_at' => now()]);

        $otpCode = (string) random_int(100000, 999999);

        TelegramOtp::create([
            'phone' => $normalizedPhone,
            'telegram_chat_id' => (string) $chatId,
            'otp_code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        $message = "Your ZenStyle OTP code is: {$otpCode}\nThis code is valid for 5 minutes.";

        $sent = $this->telegramService->sendMessage($chatId, $message);

        return [
            'ok' => $sent,
            'message' => $sent
                ? 'OTP has been sent via Telegram successfully.'
                : 'Could not send OTP via Telegram.',
        ];
    }

    public function verifyOtp(string $phone, string $otpCode): array
    {
        $normalizedPhone = $this->normalizePhone($phone);

        if (! $normalizedPhone) {
            return [
                'ok' => false,
                'message' => 'Invalid phone number format.',
            ];
        }

        $otp = TelegramOtp::query()->where('phone', $normalizedPhone)
            ->where('otp_code', $otpCode)
            ->whereNull('verified_at')
            ->where('expires_at', '>', now())
            ->latest('id')
            ->first();

        if (! $otp) {
            return [
                'ok' => false,
                'message' => 'OTP is invalid, expired, or already used.',
            ];
        }

        $otp->update([
            'verified_at' => now(),
        ]);

        return [
            'ok' => true,
            'message' => 'OTP verification successful.',
        ];
    }

    private function normalizePhone(string $phone): ?string
    {
        $normalized = preg_replace('/[\s.\-]+/', '', trim($phone));

        if (! is_string($normalized) || ! preg_match('/^0\d{9,10}$/', $normalized)) {
            return null;
        }

        return $normalized;
    }
}
