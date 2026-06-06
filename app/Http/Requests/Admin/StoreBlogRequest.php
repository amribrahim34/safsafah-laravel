<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title_ar'            => 'required|string|max:255',
            'title_en'            => 'nullable|string|max:255',
            'content_ar'          => 'required|string',
            'content_en'          => 'nullable|string',
            'featured_image'      => 'nullable|image|max:2048',
            'blog_category_ids'   => 'nullable|array',
            'blog_category_ids.*' => 'exists:blog_categories,id',
            'published_at'        => 'nullable|date',
        ];
    }
}
