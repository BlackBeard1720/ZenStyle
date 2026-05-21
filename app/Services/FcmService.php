<?php

namespace App\Services;

use App\Models\User;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Throwable;

class FcmService
{
    private array $lastErrors = [];

    public function sendToUser(User $user, string $title, string $body, array $data = []): void
    {
        $tokens = $user->fcmTokens()->pluck('token');

        foreach ($tokens as $token) {
            $this->sendToToken($token, $title, $body, $data);
        }
    }

    public function sendToToken(string $token, string $title, string $body, array $data = []): void
    {
        try {
            $message = CloudMessage::fromArray(['token' => $token])
                ->withNotification(Notification::create($title, $body))
                ->withData($this->stringifyData($data));

            app('firebase.messaging')->send($message);
        } catch (Throwable $e) {
            $this->lastErrors[] = $e->getMessage();
            report($e);
        }
    }

    public function lastErrors(): array
    {
        return $this->lastErrors;
    }

    private function stringifyData(array $data): array
    {
        return collect($data)
            ->map(fn ($value) => is_scalar($value) ? (string) $value : json_encode($value))
            ->all();
    }
}
