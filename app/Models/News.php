<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'is_active',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime'
    ];

    // 自動產生 slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    // 取得圖片完整 URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/news/' . $this->id . '/' . $this->image);
        }
        return null;
    }
}
