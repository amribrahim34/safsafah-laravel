<?php

namespace App\Http\Requests\App\Auth;

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
     * Get the validation rules that Apply to the request.
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
            'email.required_without' => __('App/auth.email_required_without'),
            'mobile.required_without' => __('App/auth.mobile_required_without'),
            'password.required' => __('App/auth.password_required'),
            'email.email' => __('App/auth.email_invalid'),
            'mobile.string' => __('App/auth.mobile_invalid'),
            'password.string' => __('App/auth.password_invalid'),
            
        ];
    }
}
