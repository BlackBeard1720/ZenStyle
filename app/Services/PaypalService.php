<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PaypalService
{
    /**
     * Lay base url theo moi truong sandbox/live.
     */
    private function baseUrl(): string
    {
        return config('services.paypal.base_url');
    }

    /**
     * Lay access token tu PayPal bang client id va secret.
     */
    private function accessToken(): string
    {
        $response = Http::withBasicAuth(
            config('services.paypal.client_id'),
            config('services.paypal.client_secret')
        )
            ->asForm()
            ->post($this->baseUrl() . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Cannot get PayPal access token.');
        }

        return $response->json('access_token');
    }

    /**
     * Tao PayPal order cho lich hen.
     */
    public function createOrder(Appointment $appointment): array
    {
        $accessToken = $this->accessToken();

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post($this->baseUrl() . '/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'reference_id' => 'appointment_' . $appointment->id,
                        'description' => 'ZenStyle Appointment #' . $appointment->id,
                        'amount' => [
                            'currency_code' => config('services.paypal.currency', 'USD'),
                            'value' => number_format((float) $appointment->total_amount, 2, '.', ''),
                        ],
                    ],
                ],
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Cannot create PayPal order.');
        }

        return $response->json();
    }

    /**
     * Capture PayPal order sau khi khach approve.
     */
    public function captureOrder(string $orderId): array
    {
        $accessToken = $this->accessToken();

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post($this->baseUrl() . "/v2/checkout/orders/{$orderId}/capture");

        if (! $response->successful()) {
            throw new RuntimeException('Cannot capture PayPal order.');
        }

        return $response->json();
    }
}
