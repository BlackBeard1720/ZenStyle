<?php

namespace App\Services;

use App\Models\TelegramUser;

class TelegramBotUpdateService
{
    public function __construct(
        protected TelegramService $telegramService
    ) {
    }

    public function process(array $update): ?array
    {
        $message = $update['message'] ?? null;

        if (! $message) {
            return null;
        }

        $chatId = $message['chat']['id'] ?? null;
        $text = trim($message['text'] ?? '');

        if (! $chatId || $text === '') {
            return null;
        }

        if ($text === '/start') {
            $this->telegramService->sendMessage(
                $chatId,
                "Xin chao! Day la bot xac thuc lich hen cua ZenStyle.\n\nVui long nhap so dien thoai ban da dung tren form dat lich.\n\nVi du: 0900000000"
            );

            return [
                'action' => 'sent_instruction',
                'telegram_chat_id' => $chatId,
            ];
        }

        if (preg_match('/^\/start\s+(0[0-9]{9,10})$/', $text, $matches)) {
            return $this->linkTelegramUser($message, $matches[1]);
        }

        if (preg_match('/^0[0-9]{9,10}$/', $text)) {
            return $this->linkTelegramUser($message, $text);
        }

        $this->telegramService->sendMessage(
            $chatId,
            "ZenStyle chua nhan dien duoc so dien thoai.\n\nVui long nhap so dien thoai theo dang 0xxxxxxxxx.\nVi du: 0900000000"
        );

        return [
            'action' => 'sent_invalid_phone_message',
            'telegram_chat_id' => $chatId,
            'text' => $text,
        ];
    }

    private function linkTelegramUser(array $message, string $phone): array
    {
        $chatId = $message['chat']['id'];
        $username = $message['from']['username'] ?? null;
        $firstName = $message['from']['first_name'] ?? null;

        $existing = TelegramUser::query()
            ->where('phone', $phone)
            ->where('telegram_chat_id', $chatId)
            ->first();

        if ($existing) {
            return [
                'action' => 'already_linked',
                'phone' => $phone,
                'telegram_chat_id' => $chatId,
            ];
        }

        TelegramUser::query()->updateOrCreate(
            ['phone' => $phone],
            [
                'telegram_chat_id' => $chatId,
                'telegram_username' => $username,
                'first_name' => $firstName,
            ]
        );

        $this->telegramService->sendMessage(
            $chatId,
            "ZenStyle da lien ket Telegram thanh cong voi so {$phone}.\n\nBay gio ban hay quay lai trang dat lich va bam \"Gui OTP\" de nhan ma xac thuc."
        );

        return [
            'action' => 'linked_user',
            'phone' => $phone,
            'telegram_chat_id' => $chatId,
            'telegram_username' => $username,
            'first_name' => $firstName,
        ];
    }
}
