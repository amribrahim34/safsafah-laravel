<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title_ar'            => 'sometimes|string|max:255',
            'title_en'            => 'sometimes|nullable|string|max:255',
            'content_ar'          => 'sometimes|string',
            'content_en'          => 'sometimes|nullable|string',
            'featured_image'      => 'sometimes|nullable|image|max:2048',
            'blog_category_ids'   => 'sometimes|nullable|array',
            'blog_category_ids.*' => 'exists:blog_categories,id',
            'published_at'        => 'sometimes|nullable|date',
        ];
    }
}
