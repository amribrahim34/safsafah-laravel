<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $items = CartItemResource::collection($this->items);
        $totalPrice = $items->sum('subtotal');
        
        return [
            'cartId' => $this->id,
            'items' => $items,
            'totalItems' => $items->sum('quantity'),
            'totalPrice' => $totalPrice,
            'promoCode' => $this->promoCode ? $this->promoCode->code : null,
            'discountAmount' => 0, // Logic to be implemented based on promo code
            'finalPrice' => $totalPrice, // Minus discount
        ];
    }
}
