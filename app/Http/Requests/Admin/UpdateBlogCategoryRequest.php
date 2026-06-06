<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_ar' => 'sometimes|string|max:255',
            'name_en' => 'sometimes|nullable|string|max:255',
        ];
    }
}
