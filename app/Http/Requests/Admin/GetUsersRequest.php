<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetUsersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search'  => 'nullable|string|max:255',
            /**
             * Accepted values:
             *   has_orders        – users with at least one order
             *   no_orders         – users with no orders
             *   has_beauty_profile – users who filled their beauty profile
             */
            'filter'  => ['nullable', 'string', Rule::in(['has_orders', 'no_orders', 'has_beauty_profile'])],
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }
}
