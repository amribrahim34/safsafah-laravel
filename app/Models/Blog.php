<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
        'slug',
        'featured_image',
        'read_time',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }

        return null;
    }

    public function blogCategories()
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_blog_category');
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
