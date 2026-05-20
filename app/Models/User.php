<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory;

    //protected $guarded = [];
    protected $fillable = ["username", "email", "phone", "password", "role_id", "status",];

    public function role(): BelongsTo {
        return $this->belongsTo(Role::class);
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function staff(): HasOne
    {
        return $this->hasOne(Staff::class);
    }

    public function hasRole(string $role): bool
    {
        return $this->role?->role_name === $role;
    }

    public function fcmTokens(): HasMany
    {
        return $this->hasMany(FcmToken::class);
    }
}
