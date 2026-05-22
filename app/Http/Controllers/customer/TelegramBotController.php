<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Services\TelegramBotUpdateService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TelegramBotController extends Controller
{
    public function processUpdates(TelegramBotUpdateService $telegramBotUpdateService): array
    {
        $token = config('services.telegram.bot_token');

        if (! $token) {
            return [
                'ok' => false,
                'message' => 'Chua cau hinh Telegram bot token.',
            ];
        }

        // Lay update_id cuoi cung da xu ly
        $lastUpdateId = Cache::get('telegram_last_update_id');

        $params = [];

        if ($lastUpdateId) {
            // Chi lay update moi hon
            $params['offset'] = $lastUpdateId + 1;
        }

        $response = Http::get("https://api.telegram.org/bot{$token}/getUpdates", $params);

        if (! $response->successful() || $response->json('ok') !== true) {
            return [
                'ok' => false,
                'message' => 'Khong lay duoc update tu Telegram.',
                'telegram_response' => $response->json(),
            ];
        }

        $updates = $response->json('result', []);
        $processedUpdates = [];

        foreach ($updates as $update) {
            $updateId = $update['update_id'] ?? null;

            $result = $telegramBotUpdateService->process($update);

            if ($result) {
                $processedUpdates[] = $result;
            }

            if ($updateId) {
                // Luu update_id da xu ly
                Cache::put('telegram_last_update_id', $updateId);
            }
        }

        return [
            'ok' => true,
            'processed_update_count' => count($updates),
            'handled_update_count' => count($processedUpdates),
            'linked_count' => collect($processedUpdates)->where('action', 'linked_user')->count(),
            'last_update_id' => Cache::get('telegram_last_update_id'),
            'processed_updates' => $processedUpdates,
        ];
    }
}
