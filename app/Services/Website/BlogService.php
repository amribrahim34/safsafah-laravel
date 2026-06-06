<?php

namespace App\Services\Website;

use App\Models\Blog;

class BlogService
{
    public function getAllBlogsPaginated($search = null, $categoryId = null, $categorySlug = null, $limit = 15)
    {
        return Blog::query()
            ->with('blogCategories')
            ->published()
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%");
            }))
            ->when($categoryId, fn($q) => $q->whereHas('blogCategories', fn($q) => $q->where('blog_categories.id', $categoryId)))
            ->when($categorySlug && !$categoryId, fn($q) => $q->whereHas('blogCategories', fn($q) => $q->where('blog_categories.slug', $categorySlug)))
            ->latest()
            ->paginate((int) $limit);
    }

    public function getBlogBySlug($slug)
    {
        return Blog::with('blogCategories')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();
    }
}
