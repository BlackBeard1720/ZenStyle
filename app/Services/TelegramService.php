<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected ?string $botToken;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
    }

    public function sendMessage(string|int $chatId, string $message): bool
    {
        if (! $this->botToken) {
            return false;
        }

        $response = Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
        ]);

        return $response->successful() && $response->json('ok') === true;
    }
}
