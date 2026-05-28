<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user?->hasRole('stylist')) {
            abort(403);
        }

        $payments = Payment::query()
            ->with(['appointment.client'])
            ->when($request->filled('keyword'), function ($query) use ($request) {
                $keyword = trim((string) $request->input('keyword'));

                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('id', $keyword)
                        ->orWhere('appointment_id', $keyword)
                        ->orWhere('transaction_code', 'like', '%' . $keyword . '%')
                        ->orWhereHas('appointment.client', function ($clientQuery) use ($keyword) {
                            $clientQuery->where('full_name', 'like', '%' . $keyword . '%')
                                ->orWhere('phone', 'like', '%' . $keyword . '%')
                                ->orWhere('email', 'like', '%' . $keyword . '%');
                        });
                });
            })
            ->when($request->filled('payment_method'), function ($query) use ($request) {
                $query->where('payment_method', $request->string('payment_method'));
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status'));
            })
            ->when($request->filled('paid_from'), function ($query) use ($request) {
                $query->whereDate('paid_at', '>=', $request->date('paid_from')->toDateString());
            })
            ->when($request->filled('paid_to'), function ($query) use ($request) {
                $query->whereDate('paid_at', '<=', $request->date('paid_to')->toDateString());
            })
            ->latest('paid_at')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('staff.payments.index', compact('payments'));
    }

    public function show(Request $request, Payment $payment)
    {
        if ($request->user()?->hasRole('stylist')) {
            abort(403);
        }

        $payment->load([
            'appointment.client',
            'appointment.appointmentServices.service',
            'appointment.appointmentServices.staff',
        ]);

        return view('staff.payments.show', compact('payment'));
    }

    public function markAsRefunded(Request $request, Payment $payment): RedirectResponse
    {
        if ($request->user()?->hasRole('stylist')) {
            abort(403);
        }

        if ($payment->status !== 'paid') {
            return back()->with('error', 'Only paid payments can be marked as refunded.');
        }

        $payment->update(['status' => 'refunded']);

        return to_route('staff.payments.show', $payment)
            ->with('success', 'Payment marked as refunded successfully.');
    }
}
