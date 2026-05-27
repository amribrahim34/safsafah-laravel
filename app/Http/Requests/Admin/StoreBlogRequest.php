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
            'title_ar'   => 'required|string|max:255',
            'title_en'   => 'nullable|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'nullable|string',
        ];
    }
}
