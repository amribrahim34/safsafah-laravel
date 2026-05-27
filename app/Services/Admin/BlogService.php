<?php

namespace App\Services\Admin;

use App\Models\Blog;

class BlogService
{
    public function getAllBlogsPaginated($search = null)
    {
        return Blog::query()
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(15);
    }

    public function getBlogById($id)
    {
        return Blog::findOrFail($id);
    }

    public function createBlog($data)
    {
        $data['slug'] = arabic_slug($data['title_ar']);

        return Blog::create($data);
    }

    public function updateBlog($id, $data)
    {
        $blog = Blog::findOrFail($id);

        if (isset($data['title_ar'])) {
            $data['slug'] = arabic_slug($data['title_ar']);
        }

        $blog->update($data);

        return $blog;
    }

    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);
        return $blog->delete();
    }
}
