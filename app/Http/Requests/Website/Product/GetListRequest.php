<?php

namespace App\Http\Requests\Website\Product;

use Illuminate\Foundation\Http\FormRequest;

class GetListRequest extends FormRequest
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
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'skin_type_id' => 'nullable|exists:skin_types,id',
            'price_range' => 'nullable|array',
            'price_range.min' => 'nullable|numeric',
            'price_range.max' => 'nullable|numeric',
            'search' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.exists' => __('messages.category_not_found'),
            'brand_id.exists' => __('messages.brand_not_found'),
            'skin_type_id.exists' => __('messages.skin_type_not_found'),
            'price_range.min.numeric' => __('messages.price_range_min_numeric'),
            'price_range.max.numeric' => __('messages.price_range_max_numeric'),
            'search.string' => __('messages.search_string'),
        ];
    }
}
