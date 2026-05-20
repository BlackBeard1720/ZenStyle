<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $staffId = $user->staff?->id;

        $appointments = Appointment::query()
            ->with(['client', 'appointmentServices.service', 'appointmentServices.staff'])
            ->when($user->hasRole('stylist'), function ($query) use ($staffId) {
                if (! $staffId) {
                    return $query->whereRaw('1 = 0');
                }

                return $query->whereHas('appointmentServices', function ($query) use ($staffId) {
                    $query->where('staff_id', $staffId);
                });
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword)
                        ->orWhereHas('client', function ($query) use ($keyword) {
                            $query->where('full_name', 'like', '%' . $keyword . '%')
                                ->orWhere('phone', 'like', '%' . $keyword . '%')
                                ->orWhere('email', 'like', '%' . $keyword . '%');
                        });
                });
            })
            ->when($request->appointment_date, function ($query, $date) {
                $query->whereDate('appointment_date', $date);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff.appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('staff.appointments.create', [
            'clients' => Client::orderBy('full_name')->get(),
            'services' => Service::whereIn('status', ['active', 'available'])->orderBy('service_name')->get(),
            'staff' => Staff::where('status', 'active')->orderBy('full_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => ['exists:services,id'],
            'staff_id' => ['nullable', 'exists:staff,id'],
            'notes' => ['nullable', 'string'],
        ]);

            if ($this->hasStaffConflict($data)) {
            return back()
                ->withInput()
                ->with('error', 'Nhan vien nay da co lich hen vao thoi gian da chon.');
        }

        $services = Service::whereIn('id', $data['service_ids'])->get();
        $totalAmount = $services->sum('price');

        $appointment = DB::transaction(function () use ($data, $services, $totalAmount) {
            $appointment = Appointment::create([
                'client_id' => $data['client_id'],
                'appointment_date' => $data['appointment_date'],
                'appointment_time' => $data['appointment_time'],
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
                'total_amount' => $totalAmount,
            ]);

            foreach ($services as $service) {
                AppointmentService::create([
                    'appointment_id' => $appointment->id,
                    'service_id' => $service->id,
                    'staff_id' => $data['staff_id'] ?? null,
                    'price_at_booking' => $service->price,
                ]);
            }

            return $appointment;
        });

        return to_route('staff.appointments.show', $appointment)
            ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['client', 'appointmentServices.service', 'appointmentServices.staff']);

        return view('staff.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        if (! $appointment->canBeEdited()) {
            return to_route('staff.appointments.show', $appointment)
                ->with('error', 'Completed or cancelled appointments cannot be edited.');
        }

        $appointment->load(['client', 'appointmentServices.service', 'appointmentServices.staff']);

        return view('staff.appointments.edit', [
            'appointment' => $appointment,
            'clients' => Client::orderBy('full_name')->get(),
            'services' => Service::whereIn('status', ['active', 'available'])->orderBy('service_name')->get(),
            'staff' => Staff::where('status', 'active')->orderBy('full_name')->get(),
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        if (! $appointment->canBeEdited()) {
            return to_route('staff.appointments.show', $appointment)
                ->with('error', 'Completed or cancelled appointments cannot be edited.');
        }

        $data = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => ['exists:services,id'],
            'staff_id' => ['nullable', 'exists:staff,id'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['pending', 'confirmed', 'cancelled', 'completed'])],
        ]);

        if ($this->hasStaffConflict($data, $appointment)) {
            return back()
                ->withInput()
                ->with('error', 'Nhan vien nay da co lich hen vao thoi gian da chon.');
        }

        $services = Service::whereIn('id', $data['service_ids'])->get();
        $totalAmount = $services->sum('price');

        DB::transaction(function () use ($appointment, $data, $services, $totalAmount) {
            $appointment->update([
                'client_id' => $data['client_id'],
                'appointment_date' => $data['appointment_date'],
                'appointment_time' => $data['appointment_time'],
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
                'total_amount' => $totalAmount,
            ]);

            $appointment->appointmentServices()->delete();

            foreach ($services as $service) {
                AppointmentService::create([
                    'appointment_id' => $appointment->id,
                    'service_id' => $service->id,
                    'staff_id' => $data['staff_id'] ?? null,
                    'price_at_booking' => $service->price,
                ]);
            }
        });

        return to_route('staff.appointments.show', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }

    public function cancel(Appointment $appointment)
    {
        if (! $appointment->canBeCancelled()) {
            return to_route('staff.appointments.index')
                ->with('error', 'Only pending or confirmed appointments can be cancelled.');
        }

        $appointment->update([
            'status' => 'cancelled',
        ]);

        return to_route('staff.appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        return $this->cancel($appointment);
    }

    private function hasStaffConflict(array $data, ?Appointment $appointment = null): bool
    {
        $staffId = $data['staff_id'] ?? null;

        if (! $staffId) {
            return false;
        }

        return Appointment::query()
            ->whereDate('appointment_date', $data['appointment_date'])
            ->whereTime('appointment_time', $data['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->when($appointment, fn ($query) => $query->whereKeyNot($appointment->id))
            ->whereHas('appointmentServices', function ($query) use ($staffId) {
                $query->where('staff_id', $staffId);
            })
            ->exists();
    }
}
