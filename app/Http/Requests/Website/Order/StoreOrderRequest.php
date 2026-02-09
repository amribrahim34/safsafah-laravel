<?php

namespace App\Http\Requests\Website\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'customerName' => 'required|string|max:255',
            'customerAddress' => 'required|string',
            'customerMobile' => 'required|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'deliveryNotes' => 'nullable|string',
            'paymentType' => 'required|string|in:CASH_ON_DELIVERY,ONLINE',
        ];
    }
}
