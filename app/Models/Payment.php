<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
