<?php

namespace App\Services\Website;

use App\Models\Blog;

class BlogService
{
    public function getAllBlogsPaginated($search = null)
    {
        return Blog::query()
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(15);
    }

    public function getBlogBySlug($slug)
    {
        return Blog::where('slug', $slug)->firstOrFail();
    }
}
