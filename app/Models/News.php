<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'summary', 'external_url', 'image', 'status'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ?: asset('images/default-news.jpg');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
