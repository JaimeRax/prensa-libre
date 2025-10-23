<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    use HasFactory;

    protected $fillable = ['title','image_url','excerpt','body','published_at','user_id'];
    protected $casts = ['published_at' => 'datetime'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_news');
    }
    public function scopePublished($q)
    {
        return $q->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
