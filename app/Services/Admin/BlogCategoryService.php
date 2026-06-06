<?php

namespace App\Services\Admin;

use App\Models\BlogCategory;

class BlogCategoryService
{
    public function getAllPaginated($search = null)
    {
        return BlogCategory::query()
            ->search($search)
            ->latest()
            ->paginate(15);
    }

    public function getById($id)
    {
        return BlogCategory::findOrFail($id);
    }

    public function create($data)
    {
        $data['slug'] = arabic_slug($data['name_ar']);

        return BlogCategory::create($data);
    }

    public function update($id, $data)
    {
        $category = BlogCategory::findOrFail($id);

        if (isset($data['name_ar'])) {
            $data['slug'] = arabic_slug($data['name_ar']);
        }

        $category->update($data);

        return $category;
    }

    public function delete($id)
    {
        $category = BlogCategory::findOrFail($id);

        return $category->delete();
    }
}
