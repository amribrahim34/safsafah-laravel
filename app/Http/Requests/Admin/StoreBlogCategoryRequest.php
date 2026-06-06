<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
        ];
    }
}
