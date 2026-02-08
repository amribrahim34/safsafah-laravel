<?php

namespace App\Services\Website;

use App\Models\Cart;

class CartService
{
    /**
     * Create a new class instance.
     */
    public function getCart($user)
    {
        // Get or create cart
        return Cart::firstOrCreate(
            ['user_id' => $user->id],
            // Default attributes if creating
            ['promo_code_id' => null] 
        )->load(['items.product', 'promoCode']);
    }

    public function addItem($user, array $data)
    {
        $cart = $this->getCart($user);
        $productId = $data['productId'];
        $quantity = $data['quantity'] ?? 1;

        // Check if item exists
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

    public function updateItem($user, $cartItemId, array $data)
    {
        $cart = $this->getCart($user);
        $cartItem = $cart->items()->where('id', $cartItemId)->firstOrFail();

        $cartItem->quantity = $data['quantity'];
        $cartItem->save();

        return $cart->load(['items.product', 'promoCode']);
    }

    public function removeItem($user, $cartItemId)
    {
        $cart = $this->getCart($user);
        $cart->items()->where('id', $cartItemId)->delete();
        
        return $cart->load(['items.product', 'promoCode']);
    }

    public function applyPromo($user, $code)
    {
        // Mock logic for promo code
        // In real app, validating code against DB
        return $this->getCart($user);
    }
}
