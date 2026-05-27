<?php

namespace App\Services;

use App\Models\TelegramUser;

class TelegramBotUpdateService
{
    public function __construct(
        protected TelegramService $telegramService,
        protected TelegramOtpService $telegramOtpService
    ) {
    }

    public function process(array $update): ?array
    {
        $message = $update['message'] ?? null;

        if (! is_array($message)) {
            return null;
        }

        $chatId = $message['chat']['id'] ?? null;
        $text = trim((string) ($message['text'] ?? ''));

        if (! $chatId || $text === '') {
            return null;
        }

        if ($text === '/start' || $text === '/start booking') {
            $this->telegramService->sendMessage(
                $chatId,
                "Welcome to ZenStyle Telegram verification bot.\n\nPlease send your phone number in this format:\n0900000000"
            );

            return [
                'action' => 'sent_instruction',
                'telegram_chat_id' => $chatId,
            ];
        }

        if (preg_match('/^\/start\s+(.+)$/', $text, $matches)) {
            $payload = trim($matches[1]);
            $phoneFromPayload = $this->extractPhoneFromStartPayload($payload);

            if ($phoneFromPayload) {
                return $this->linkTelegramUser($message, $phoneFromPayload, true);
            }
        }

        if ($this->normalizePhone($text)) {
            return $this->linkTelegramUser($message, $text, false);
        }

        $this->telegramService->sendMessage(
            $chatId,
            "ZenStyle could not recognize your phone number.\n\nPlease enter your phone number in this format:\n0900000000"
        );

        return [
            'action' => 'sent_invalid_phone_message',
            'telegram_chat_id' => $chatId,
            'text' => $text,
        ];
    }

    private function linkTelegramUser(array $message, string $phone, bool $fromDeepLink): array
    {
        $chatId = (string) $message['chat']['id'];
        $username = $message['from']['username'] ?? null;
        $firstName = $message['from']['first_name'] ?? null;

        $normalizedPhone = $this->normalizePhone($phone);

        if (! $normalizedPhone) {
            $this->telegramService->sendMessage(
                $chatId,
                "Invalid phone number format. Please use this format:\n0900000000"
            );

            return [
                'action' => 'invalid_phone',
                'telegram_chat_id' => $chatId,
            ];
        }

        $existing = TelegramUser::query()->where('phone', $normalizedPhone)->first();

        TelegramUser::query()->updateOrCreate(
            ['phone' => $normalizedPhone],
            [
                'telegram_chat_id' => $chatId,
                'telegram_username' => $username,
                'first_name' => $firstName,
            ]
        );

        if ($existing && (string) $existing->telegram_chat_id === $chatId) {
            $this->telegramService->sendMessage(
                $chatId,
                "Your phone number {$normalizedPhone} is already linked to this Telegram account. Sending a new OTP now."
            );
        } else {
            $this->telegramService->sendMessage(
                $chatId,
                "ZenStyle has successfully linked phone number {$normalizedPhone} to this Telegram account. Sending your OTP now."
            );
        }

        $otpResult = $this->telegramOtpService->generateAndSendOtp($normalizedPhone, $chatId);

        if (! $otpResult['ok']) {
            $this->telegramService->sendMessage(
                $chatId,
                $otpResult['message']
            );
        }

        return [
            'action' => $existing ? 'updated_or_relinked_user' : 'linked_user',
            'source' => $fromDeepLink ? 'start_payload' : 'manual_message',
            'phone' => $normalizedPhone,
            'telegram_chat_id' => $chatId,
            'telegram_username' => $username,
            'first_name' => $firstName,
            'otp_sent' => $otpResult['ok'],
        ];
    }

    private function extractPhoneFromStartPayload(string $payload): ?string
    {
        if (str_starts_with($payload, 'link_')) {
            $payload = substr($payload, 5);
        }

        return $this->normalizePhone(urldecode($payload));
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
