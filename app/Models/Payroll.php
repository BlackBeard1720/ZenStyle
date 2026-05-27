<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'staff_id',
        'month',
        'year',
        'base_salary',
        'commission',
        'total_salary',
        'status',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
