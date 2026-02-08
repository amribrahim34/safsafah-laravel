<?php

namespace App\Services\Website;

use App\Models\Product;
use App\Models\WishList;

class WishlistService
{
    /**
     * Create a new class instance.
     */
    public function getWishlist($user)
    {
        return WishList::where('user_id', $user->id)
            ->with('product')
            ->get();
    }

    public function addProduct($user, $productId)
    {
        // Check if product exists
        Product::findOrFail($productId);

        return WishList::firstOrCreate([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);
    }

    public function removeProduct($user, $productId)
    {
        return WishList::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->delete();
    }
}
