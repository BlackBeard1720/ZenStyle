<?php

namespace App\Events;

use App\Models\Appointment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppointmentCreated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Appointment $appointment)
    {
        $this->appointment->loadMissing('client', 'appointmentServices.service', 'appointmentServices.staff');
    }

    public function broadcastOn(): Channel
    {
        return new Channel('staff.appointments');
    }

    public function broadcastAs(): string
    {
        return 'appointment.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->appointment->id,
            'client_name' => $this->appointment->client?->full_name,
            'client_phone' => $this->appointment->client?->phone,
            'appointment_date' => optional($this->appointment->appointment_date)->format('d/m/Y'),
            'appointment_time' => $this->appointment->appointment_time,
            'status' => $this->appointment->status,
            'total_amount' => $this->appointment->total_amount,
            'message' => 'Có lịch hẹn mới từ ' . ($this->appointment->client?->full_name ?? 'khách hàng'),
        ];
    }
}
