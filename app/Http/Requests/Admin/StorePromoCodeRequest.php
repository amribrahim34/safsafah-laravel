<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePromoCodeRequest extends FormRequest
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
            'code' => 'required|string|unique:promo_codes',
            'discount' => 'required|numeric',
            'is_percent' => 'boolean',
            'expiry_date' => 'nullable|date',
            'usage_limit' => 'nullable|integer',
            'active' => 'boolean',
            'min_order_value' => 'nullable|numeric',
            'max_discount_amount' => 'nullable|numeric',
        ];
    }
}
