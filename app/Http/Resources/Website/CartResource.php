<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $items = CartItemResource::collection($this->items);
        $subtotal = $this->calculateSubtotal();
        $discount = $this->calculateDiscount($subtotal);
        $totalPrice = $subtotal - $discount;

        return [
            'cartId' => $this->id,
            'items' => $items,
            'totalPrice' => $totalPrice ,
            'totalItems' => $items->sum('quantity'),
            'subtotal' => $subtotal,
            'promoCode' => $this->promoCode?->code,
            'discountAmount' => $discount,
            'finalPrice' => max(0, $subtotal - $discount),
        ];
    }

    private function calculateSubtotal(): float
    {
        return $this->items->sum(fn($item) => $item->product->price * $item->quantity);
    }

    private function calculateDiscount(float $subtotal): float
    {
        $promoCode = $this->promoCode;

        if (!$promoCode) {
            return 0;
        }

        if ($promoCode->is_percent) {
            $discount = $subtotal * ($promoCode->discount / 100);

            if ($promoCode->max_discount_amount) {
                $discount = min($discount, (float) $promoCode->max_discount_amount);
            }
        } else {
            $discount = (float) $promoCode->discount;
        }

        return $discount ?? 0;
    }
}
