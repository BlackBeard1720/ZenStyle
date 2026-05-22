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

        // Lay update_id cuoi cung da xu ly
        $lastUpdateId = Cache::get('telegram_last_update_id');

        $params = [];

        if ($lastUpdateId) {
            // Chi lay update moi hon
            $params['offset'] = $lastUpdateId + 1;
        }

        $response = Http::get("https://api.telegram.org/bot{$token}/getUpdates", $params);
        $updates = $response->json('result', []);
        $processedUpdates = [];

        foreach ($updates as $update) {
            $updateId = $update['update_id'] ?? null;

            if ($updateId) {
                // Luu update_id moi nhat
                Cache::put('telegram_last_update_id', $updateId);
            }

            $result = $telegramBotUpdateService->process($update);

            if ($result) {
                $processedUpdates[] = $result;
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
