<?php

namespace App\Services\Website;

use App\Models\Cart;
use App\Models\PromoCode;
use App\Services\Website\Orders\OrderCalculationService;

class CartService
{
    public function __construct(private OrderCalculationService $calculationService)
    {
    }

    public function getCart($user): Cart
    {
        return Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['promo_code_id' => null]
        )->load(['items.product', 'promoCode']);
    }

    public function addItem($user, array $data): Cart
    {
        $cart = $this->getCart($user);
        $productId = $data['productId'];
        $quantity = $data['quantity'] ?? 1;

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return $cart->load(['items.product', 'promoCode']);
    }

    public function updateItem($user, $cartItemId, array $data): Cart
    {
        $cart = $this->getCart($user);
        $cartItem = $cart->items()->where('id', $cartItemId)->firstOrFail();

        $cartItem->quantity = $data['quantity'];
        $cartItem->save();

        return $cart->load(['items.product', 'promoCode']);
    }

    public function removeItem($user, $cartItemId): Cart
    {
        $cart = $this->getCart($user);
        $cart->items()->where('id', $cartItemId)->delete();

        return $cart->load(['items.product', 'promoCode']);
    }

    public function applyPromo($user, string $code): Cart
    {
        $cart = $this->getCart($user);
        $promoCode = PromoCode::where('code', $code)->firstOrFail();

        $subtotal = $this->calculationService->calculateSubtotal($cart->items);
        $this->calculationService->validatePromoCode($promoCode, $subtotal);

        $cart->promo_code_id = $promoCode->id;
        $cart->save();

        return $cart->load(['items.product', 'promoCode']);
    }
}
