<?php

namespace App\Services\Admin;

use App\Models\Blog;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    public function __construct(private FileUploadService $fileUploadService) {}

    public function getAllBlogsPaginated($search = null, $categoryId = null)
    {
        return Blog::query()
            ->with('blogCategories')
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            }))
            ->when($categoryId, fn($q) => $q->whereHas('blogCategories', fn($q) => $q->where('blog_categories.id', $categoryId)))
            ->latest()
            ->paginate(15);
    }

    public function getBlogById($id)
    {
        return Blog::with('blogCategories')->findOrFail($id);
    }

    public function createBlog($data)
    {
        $data['slug'] = arabic_slug($data['title_ar']);
        $data['read_time'] = $this->calculateReadTime($data['content_ar'] ?? '');

        if (isset($data['featured_image'])) {
            $data['featured_image'] = $this->fileUploadService->upload($data['featured_image'], 'blogs', $data['title_en'] ?? $data['title_ar']);
        }

        $categoryIds = $data['blog_category_ids'] ?? [];
        unset($data['blog_category_ids']);

        $blog = Blog::create($data);
        $blog->blogCategories()->sync($categoryIds);

        return $blog->load('blogCategories');
    }

    public function updateBlog($id, $data)
    {
        $blog = Blog::findOrFail($id);

        if (isset($data['title_ar'])) {
            $data['slug'] = arabic_slug($data['title_ar']);
        }

        if (isset($data['content_ar'])) {
            $data['read_time'] = $this->calculateReadTime($data['content_ar']);
        }

        if (isset($data['featured_image'])) {
            $data['featured_image'] = $this->fileUploadService->updateImage($blog->featured_image, $data['featured_image'], 'blogs', $data['title_en'] ?? $data['title_ar'] ?? null);
        }

        $categoryIds = $data['blog_category_ids'] ?? null;
        unset($data['blog_category_ids']);

        $blog->update($data);

        if ($categoryIds !== null) {
            $blog->blogCategories()->sync($categoryIds);
        }

        return $blog->load('blogCategories');
    }

    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        return $blog->delete();
    }

    private function calculateReadTime(string $content): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($content)) / 150));
    }
}
