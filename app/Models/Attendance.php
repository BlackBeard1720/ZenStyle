<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    public const STATUS_PRESENT = 'present';
    public const STATUS_LATE = 'late';
    public const STATUS_ABSENT = 'absent';
    public const STATUS_LEAVE = 'leave';

    public const STATUSES = [
        self::STATUS_PRESENT,
        self::STATUS_LATE,
        self::STATUS_ABSENT,
        self::STATUS_LEAVE,
    ];

    protected $fillable = [
        'staff_id',
        'work_date',
        'check_in',
        'check_out',
        'working_hours',
        'overtime_hours',
        'status',
        'note',
    ];

    protected $casts = [
        'work_date' => 'date',
        'check_in' => 'datetime:H:i',
        'check_out' => 'datetime:H:i',
        'working_hours' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}
