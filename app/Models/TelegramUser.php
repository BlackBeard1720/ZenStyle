<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $fillable = [
        'phone',
        'telegram_chat_id',
        'telegram_username',
        'first_name',
    ];
}
