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
            'categoryId' => 'nullable|exists:categories,id',
            'brandId' => 'nullable|exists:brands,id',
            'skinTypeId' => 'nullable|exists:skin_types,id',
            'minPrice' => 'nullable|numeric|min:0',
            'maxPrice' => 'nullable|numeric|min:0',
            'searchQuery' => 'nullable|string|max:255',
            'page' => 'nullable|integer|min:1',
            'limit' => 'nullable|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'categoryId.exists' => __('messages.category_not_found'),
            'brandId.exists' => __('messages.brand_not_found'),
            'skinTypeId.exists' => __('messages.skin_type_not_found'),
            'minPrice.numeric' => __('messages.price_must_be_numeric'),
            'maxPrice.numeric' => __('messages.price_must_be_numeric'),
            'searchQuery.string' => __('messages.search_must_be_string'),
        ];
    }
}
