<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    /**
     * Lay Access Token tu PayPal.
     * Token nay dung de goi API tao order va capture payment.
     */
    private function getAccessToken(): ?string
    {
        $config = config('services.paypal');

        $response = Http::asForm()
            ->withBasicAuth($config['client_id'], $config['secret'])
            ->post($config['base_url'] . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            Log::error('PayPal Auth Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        }

        return $response->json('access_token');
    }

    /**
     * Tao PayPal order tu appointment that.
     * Hien tai chi thanh toan cho lich hen dich vu, khong thanh toan cho kho hang.
     */
    public function createPayment(Request $request, Appointment $appointment)
    {
        $appointment->load('payments');

        if ($appointment->status !== 'completed') {
            return redirect()
                ->back()
                ->with('error', 'Only completed appointments can be paid.');
        }

        if ($appointment->payments()->where('status', 'paid')->exists()) {
            return redirect()
                ->back()
                ->with('error', 'This appointment has already been paid.');
        }

        if ((float) $appointment->total_amount <= 0) {
            return redirect()
                ->back()
                ->with('error', 'Appointment total amount is invalid.');
        }

        $accessToken = $this->getAccessToken();

        if (! $accessToken) {
            return redirect()
                ->back()
                ->with('error', 'Cannot connect to PayPal.');
        }

        $config = config('services.paypal');

        // Neu total_amount dang la USD thi dung dong nay.
        $amount = number_format((float) $appointment->total_amount, 2, '.', '');

        // Neu total_amount cua ban dang la VND, tam thoi demo co the dung:
        // $usdRate = 25000;
        // $amount = number_format((float) $appointment->total_amount / $usdRate, 2, '.', '');

        $orderData = [
            'intent' => 'CAPTURE',

            'purchase_units' => [
                [
                    'reference_id' => 'appointment_' . $appointment->id,
                    'description' => 'ZenStyle appointment #' . $appointment->id,
                    'custom_id' => (string) $appointment->id,

                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $amount,
                    ],
                ],
            ],

            'application_context' => [
                'return_url' => route('staff.appointments.paypal.success', $appointment),
                'cancel_url' => route('staff.appointments.paypal.cancel', $appointment),
                'user_action' => 'PAY_NOW',
                'shipping_preference' => 'NO_SHIPPING',
            ],
        ];

        $response = Http::withToken($accessToken)
            ->post($config['base_url'] . '/v2/checkout/orders', $orderData);

        if ($response->failed()) {
            Log::error('PayPal Create Order Failed', [
                'appointment_id' => $appointment->id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Cannot create PayPal order.');
        }

        $result = $response->json();

        // Hien tai payment nay chi danh cho appointment service.
        // order_id de null neu bang payments cua ban van con cot order_id.
        // Neu sau nay mo rong sang product/order payment,
        // nen tach controller hoac tach service de xu ly Order/Invoice rieng.
        Payment::create([
            'appointment_id' => $appointment->id,
            'order_id' => null,
            'amount' => $appointment->total_amount,
            'payment_method' => 'paypal',
            'status' => 'pending',
            'paypal_order_id' => $result['id'] ?? null,
            'paid_at' => null,
        ]);

        foreach ($result['links'] ?? [] as $link) {
            if (($link['rel'] ?? null) === 'approve') {
                return redirect()->away($link['href']);
            }
        }

        return redirect()
            ->back()
            ->with('error', 'PayPal approve link not found.');
    }

    /**
     * Tam thoi de trong.
     * Buoc sau moi xu ly capture payment tai day.
     */
    public function paymentSuccess(Request $request, Appointment $appointment)
    {
        return redirect()
            ->route('staff.appointments.show', $appointment)
            ->with('success', 'PayPal returned successfully. Capture step will be handled next.');
    }

    /**
     * Xu ly khi user bam cancel tren PayPal.
     */
    public function paymentCancel(Request $request, Appointment $appointment)
    {
        return redirect()
            ->route('staff.appointments.checkout.show', $appointment)
            ->with('info', 'PayPal payment was cancelled.');
    }

    /**
     * Route test local neu ban dang dung /test-paypal-connection.
     */
    public function testConnection()
    {
        $accessToken = $this->getAccessToken();

        if (! $accessToken) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot get PayPal access token.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'PayPal sandbox connected successfully.',
            'token_preview' => substr($accessToken, 0, 20) . '...',
        ]);
    }
}
