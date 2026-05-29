<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'appointment_date',
        'appointment_time',
        'status',
        'reminder_sent_at',
        'notes',
        'total_amount',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'reminder_sent_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function appointmentServices(): HasMany
    {
        return $this->hasMany(AppointmentService::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'appointment_service')
            ->withPivot(['id', 'staff_id', 'price_at_booking']);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isPaid(): bool
    {
        return $this->payments()
            ->where('status', 'paid')
            ->exists();
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'], true);
    }

    public function canBeEdited(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'], true);
    }
}
