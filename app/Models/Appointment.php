<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Appointment extends Model
{
    protected $fillable = [
        'client_id',
        // thêm các cột khác khi làm feature đặt lịch
    ];

    public function clients(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
