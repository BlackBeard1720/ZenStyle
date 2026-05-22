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
                'Vui long gui so dien thoai ban da dung de dat lich tren ZenStyle. Vi du: 0326477859'
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
            'ZenStyle khong nhan dien duoc so dien thoai. Vui long gui so dien thoai dang 0xxxxxxxxx.'
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

        // Luu thong tin lien ket Telegram
        TelegramUser::updateOrCreate(
            ['telegram_chat_id' => $chatId],
            [
                'phone' => $phone,
                'telegram_username' => $username,
                'first_name' => $firstName,
            ]
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
