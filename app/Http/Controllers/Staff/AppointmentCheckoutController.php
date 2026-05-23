<?php

namespace App\Http\Controllers\Staff;

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

        if ($appointment->status === 'cancelled') {
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
        //
    }
}
