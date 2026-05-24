<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_PAID = 'paid';

    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_CONFIRMED,
        self::STATUS_PAID,
    ];

    protected $fillable = [
        'staff_id',
        'month',
        'year',
        'standard_work_days',
        'actual_work_days',
        'base_salary',
        'bonus',
        'deduction',
        'net_salary',
        'status',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'standard_work_days' => 'integer',
        'actual_work_days' => 'integer',
        'base_salary' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deduction' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}
