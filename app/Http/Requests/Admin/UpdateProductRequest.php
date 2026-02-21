<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $this->route('product'),
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active_ingredients' => 'nullable|array',
            'active_ingredients.*' => 'exists:active_ingredients,id',
            'skin_types' => 'nullable|array',
            'skin_types.*' => 'exists:skin_types,id',
            'skin_concerns' => 'nullable|array',
            'skin_concerns.*' => 'exists:skin_concerns,id',
        ];
    }
}
