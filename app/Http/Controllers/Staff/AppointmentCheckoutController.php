<?php

namespace App\Http\Controllers\Staff;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentCheckoutController extends Controller
{
    public function show(Appointment $appointment) {
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

        public function store(Request $request, Appointment $appointment) {
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

            DB::transaction(function () use ($appointment, $data) {
                Payment::create([
                    'appointment_id' => $appointment->id,
                    'amount' => $appointment->total_amount,
                    'payment_method' => $data['payment_method'],
                    'status' => 'paid',
                    'note' => $data['note'] ?? null,
                    'paid_at' => now(),
                ]);
            });

            return to_route('staff.appointments.show', $appointment)
                ->with('success', 'Payment completed successfully.');
        }
    }
