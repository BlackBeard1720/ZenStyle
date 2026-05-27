<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Services\EmailOtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CustomerBookingOtpController extends Controller
{
    public function send(Request $request, EmailOtpService $emailOtpService): JsonResponse|RedirectResponse
    {
        $data = session('booking_data', []);
        $email = $data['email'] ?? null;

        if (! $email) {
            $message = 'Please complete booking information before requesting OTP.';

            if ($request->expectsJson()) {
                return response()->json(['ok' => false, 'message' => $message], 422);
            }

            return redirect()->route('booking')->withErrors(['booking' => $message]);
        }

        $result = $emailOtpService->sendOtp($email);

        if ($request->expectsJson()) {
            return response()->json($result, $result['ok'] ? 200 : 422);
        }

        return back()
            ->withInput()
            ->with('otp_pending', true)
            ->with($result['ok'] ? 'success' : 'error', $result['message']);
    }
}
