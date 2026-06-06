<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'slug',
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_blog_category');
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%");
            });
        });
    }
}
