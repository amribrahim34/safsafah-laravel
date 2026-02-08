<?php

namespace App\Http\Requests\Website\BeautyProfile;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeautyProfileRequest extends FormRequest
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
            'skinTypeId' => 'required|exists:skin_types,id',
            'skinConcernIds' => 'nullable|array',
            'skinConcernIds.*' => 'exists:skin_concerns,id',
            'allergies' => 'nullable|string',
            'preferredIngredientIds' => 'nullable|array',
            'preferredIngredientIds.*' => 'exists:active_ingredients,id',
            'avoidedIngredientIds' => 'nullable|array',
            'avoidedIngredientIds.*' => 'exists:active_ingredients,id',
        ];
    }
}
