<?php

namespace App\Http\Requests\App\Order;

use Illuminate\Foundation\Http\FormRequest;

class GuestOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customerName'       => 'required|string|max:255',
            'customerMobile'     => 'required|string|max:20',
            'customerAddress'    => 'required|string',
            'latitude'           => 'nullable|numeric',
            'longitude'          => 'nullable|numeric',
            'deliveryNotes'      => 'nullable|string',
            'paymentType'        => 'required|string|in:CASH_ON_DELIVERY,ONLINE',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ];
    }
}
