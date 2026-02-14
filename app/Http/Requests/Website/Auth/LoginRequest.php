<?php

namespace App\Http\Requests\Website\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required_without:mobile|email',
            'mobile' => 'required_without:email|string',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required_without' => __('website/auth.email_required_without'),
            'mobile.required_without' => __('website/auth.mobile_required_without'),
            'password.required' => __('website/auth.password_required'),
            'email.email' => __('website/auth.email_invalid'),
            'mobile.string' => __('website/auth.mobile_invalid'),
            'password.string' => __('website/auth.password_invalid'),
            
        ];
    }
}
