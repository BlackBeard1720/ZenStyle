<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramOtp extends Model
{
    protected $fillable = [
        'phone',
        'telegram_chat_id',
        'otp_code',
        'expires_at',
        'verified_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];
}
