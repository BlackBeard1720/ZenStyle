<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug','excerpt','body','image','published_at','status'];

    protected $dates = ['published_at'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ?: asset('images/frontend/banner/Gemini_Generated_Image_6hfrq56hfrq56hfr.png');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
