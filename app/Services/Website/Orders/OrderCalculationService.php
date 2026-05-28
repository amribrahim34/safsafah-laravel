<?php

namespace App\Services\Website\Orders;

use App\Models\PromoCode;
use Exception;
use Illuminate\Support\Collection;

class OrderCalculationService
{
    private const SHIPPING_COST = 50;
    
    public function calculateSubtotal(Collection $items): float
    {
        return $items->sum(fn($item) => $item->product->price * $item->quantity);
    }

    public function validatePromoCode(PromoCode $promoCode, float $subtotal): void
    {
        if (!$promoCode->active) {
            throw new Exception('Promo code is inactive.');
        }

        if ($promoCode->expiry_date && $promoCode->expiry_date->isPast()) {
            throw new Exception('Promo code has expired.');
        }

        if ($promoCode->usage_limit && $promoCode->times_used >= $promoCode->usage_limit) {
            throw new Exception('Promo code usage limit has been reached.');
        }

        if ($promoCode->min_order_value && $subtotal < $promoCode->min_order_value) {
            throw new Exception("A minimum order value of {$promoCode->min_order_value} is required for this promo code.");
        }
    }

    public function calculateDiscount(PromoCode $promoCode, float $subtotal): float
    {
        if ($promoCode->is_percent) {
            $discount = $subtotal * ($promoCode->discount / 100);

            if ($promoCode->max_discount_amount) {
                $discount = min($discount, (float) $promoCode->max_discount_amount);
            }
        } else {
            $discount = (float) $promoCode->discount;
        }

        return min($discount, $subtotal);
    }

    public function calculate(Collection $items, ?PromoCode $promoCode = null): array
    {
        $subtotal = $this->calculateSubtotal($items);
        $discount = 0;

        if ($promoCode) {
            $this->validatePromoCode($promoCode, $subtotal);
            $discount = $this->calculateDiscount($promoCode, $subtotal);
        }

        $tax = 0;
        $shipping = self::SHIPPING_COST;
        $total = max(0, $subtotal - $discount + $tax + $shipping);

        return compact('subtotal', 'discount', 'tax', 'shipping', 'total');
    }
}
