<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'email',
        'specialization',
        'avatar',
        'salary',
        'hire_date',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointmentServices(): HasMany
    {
        return $this->hasMany(AppointmentService::class);
    }

    public function schedules()
    {
        return $this->hasMany(StaffSchedule::class);
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'staff_id', 'id');
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }
}
