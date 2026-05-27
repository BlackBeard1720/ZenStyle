<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    public const STATUS_PRESENT = 'present';
    public const STATUS_LATE = 'late';
    public const STATUS_ABSENT = 'absent';
    public const STATUS_LEAVE = 'leave';

    protected $fillable = [
        'staff_id',
        'work_date',
        'check_in',
        'check_out',
        'status',
    ];

    protected $casts = [
        'work_date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }

    public function getWorkingHoursAttribute()
    {
        if (!$this->check_in || !$this->check_out) {
            return 0;
        }

        return round($this->check_in->diffInMinutes($this->check_out) / 60, 2);
    }
}
