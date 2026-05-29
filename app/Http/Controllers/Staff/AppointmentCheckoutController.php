<?php

namespace App\Http\Controllers\Staff;

use App\Mail\PaymentReceiptMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Payment;
use App\Services\PaypalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentCheckoutController extends Controller
{
    public function show(Appointment $appointment)
    {
        $appointment->load([
            'client',
            'appointmentServices.service',
            'appointmentServices.staff',
            'payments',
        ]);

        if ($appointment->status !== 'completed') {
            return to_route('staff.appointments.show', $appointment)
                ->with('error', 'Cannot checkout a cancelled appointment.');
        }

        if ($appointment->isPaid()) {
            return to_route('staff.appointments.show', $appointment)
                ->with('error', 'This appointment has already been paid.');
        }

        return view('staff.appointments.checkout', compact('appointment'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $appointment->load('payments');

        if ($appointment->status !== 'completed') {
            return to_route('staff.appointments.show', $appointment)
                ->with('error', 'Only completed appointments can be checked out.');
        }

        if ($appointment->isPaid()) {
            return to_route('staff.appointments.show', $appointment)
                ->with('error', 'This appointment has already been paid.');
        }

        $data = $request->validate([
            'payment_method' => ['required', 'in:cash'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $payment = DB::transaction(function () use ($appointment, $data) {
            $transactionCode = 'CASH-' . now()->format('YmdHis') . '-' . $appointment->id;
            return Payment::create([
                'appointment_id' => $appointment->id,
                'amount' => $appointment->total_amount,
                'payment_method' => $data['payment_method'],
                'status' => 'paid',
                'transaction_code' => $transactionCode,
                'note' => $data['note'] ?? null,
                'paid_at' => now(),
            ]);
        });
        $this->sendPaymentReceiptMail($payment);
        return to_route('staff.appointments.show', $appointment)
            ->with('success', 'Payment completed successfully.');
    }

    public function createPaypalOrder(
        Appointment $appointment,
        PaypalService $payPalService
    ): JsonResponse {
        $appointment->load('payments');

        if ($appointment->status !== 'completed') {
            return response()->json([
                'message' => 'Only completed appointments can be paid.',
            ], 422);
        }

        if ($appointment->isPaid()) {
            return response()->json([
                'message' => 'This appointment has already been paid.',
            ], 422);
        }

        $order = $payPalService->createOrder($appointment);

        return response()->json([
            'id' => $order['id'],
        ]);
    }
    public function capturePaypalOrder(
        Request $request,
        Appointment $appointment,
        PaypalService $payPalService
    ): JsonResponse {
        $appointment->load('payments');

        if ($appointment->status !== 'completed') {
            return response()->json([
                'message' => 'Only completed appointments can be paid.',
            ], 422);
        }

        if ($appointment->isPaid()) {
            return response()->json([
                'message' => 'This appointment has already been paid.',
            ], 422);
        }

        $data = $request->validate([
            'order_id' => ['required', 'string'],
        ]);

        $capture = $payPalService->captureOrder($data['order_id']);

        if (($capture['status'] ?? null) !== 'COMPLETED') {
            return response()->json([
                'message' => 'PayPal payment was not completed.',
            ], 422);
        }

        $captureId = data_get($capture, 'purchase_units.0.payments.captures.0.id');

        $payment = DB::transaction(function () use ($appointment, $data, $captureId) {
            return Payment::create([
                'appointment_id' => $appointment->id,
                'amount' => $appointment->total_amount,
                'payment_method' => 'paypal',
                'status' => 'paid',
                'transaction_code' => $captureId,
                'paypal_order_id' => $data['order_id'],
                'paypal_capture_id' => $captureId,
                'note' => 'Paid by PayPal',
                'paid_at' => now(),
            ]);
        });

        $this->sendPaymentReceiptMail($payment);

        return response()->json([
            'message' => 'PayPal payment completed successfully.',
            'redirect_url' => route('staff.appointments.show', $appointment),
        ]);
    }

    private function sendPaymentReceiptMail(Payment $payment): void
    {
        $payment->loadMissing([
            'appointment.client',
            'appointment.appointmentServices.service.category',
            'appointment.appointmentServices.staff',
        ]);

        $email = $payment->appointment?->client?->email;

        if (empty($email)) {
            return;
        }

        Mail::to($email)->queue(new PaymentReceiptMail($payment));
    }
}
