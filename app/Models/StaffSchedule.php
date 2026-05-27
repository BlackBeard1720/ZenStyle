<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffSchedule extends Model
{
    protected $fillable = [
        'staff_id',
        'work_date',
        'start_time',
        'end_time',
        'status',
        'note',
    ];

    protected $casts = [
        'work_date' => 'date',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
