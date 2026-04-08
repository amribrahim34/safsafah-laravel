<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'facebook'  => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'tiktok'    => 'nullable|url|max:255',
            'whatsapp'  => ['nullable', 'string', 'regex:/^(010|011|012|015)\d{8}$/'],
            'email'     => 'nullable|email|max:255',
            'mobile'    => ['nullable', 'string', 'regex:/^(010|011|012|015)\d{8}$/'],
        ];
    }
}
