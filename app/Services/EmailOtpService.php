<?php

namespace App\Services;

use App\Mail\BookingOtpMail;
use App\Models\EmailOtp;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EmailOtpService
{
    public function sendOtp(string $email): array
    {
        $normalizedEmail = $this->normalizeEmail($email);

        if ($normalizedEmail === '') {
            return ['ok' => false, 'message' => 'Could not send OTP email. Please try again.'];
        }

        EmailOtp::query()
            ->where('email', $normalizedEmail)
            ->whereNull('verified_at')
            ->update(['expires_at' => now()]);

        $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailOtp::query()->create([
            'email' => $normalizedEmail,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(5),
        ]);

        try {
            Mail::to($normalizedEmail)->send(new BookingOtpMail($otpCode));

            return ['ok' => true, 'message' => 'OTP has been sent to your email.'];
        } catch (Throwable $exception) {
            report($exception);

            return ['ok' => false, 'message' => 'Could not send OTP email. Please try again.'];
        }
    }

    public function verifyOtp(string $email, string $otpCode): array
    {
        $normalizedEmail = $this->normalizeEmail($email);

        $emailOtp = EmailOtp::query()
            ->where('email', $normalizedEmail)
            ->where('otp_code', trim($otpCode))
            ->whereNull('verified_at')
            ->where('expires_at', '>', now())
            ->latest('id')
            ->first();

        if (! $emailOtp) {
            return ['ok' => false, 'message' => 'Invalid or expired OTP. Please try again.'];
        }

        $emailOtp->update([
            'verified_at' => now(),
        ]);

        return ['ok' => true, 'message' => 'OTP verified successfully.'];
    }

    private function normalizeEmail(string $email): string
    {
        return strtolower(trim($email));
    }
}
