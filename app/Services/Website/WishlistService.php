<?php

namespace App\Services\Website;

use App\Models\Product;
use App\Models\WishList;

class WishlistService
{
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }
    /**
     * Create a new class instance.
     */
    public function getWishlist()
    {
        return Wishlist::select(
            'products.id', 
            'products.name_ar', 
            'products.name_en', 
            'products.price', 
            'products.image'
            )
            ->join('products', 'wish_lists.product_id', '=', 'products.id')
            ->where('wish_lists.user_id', $this->user->id)
            ->get();
    }

    public function addProduct($productId)
    {
        // Check if product exists
        Product::findOrFail($productId);

        return WishList::firstOrCreate([
            'user_id' => $this->user->id,
            'product_id' => $productId,
        ]);
    }

    public function removeProduct( $productId)
    {
        return WishList::where('user_id', $this->user->id)
            ->where('product_id', $productId)
            ->delete();
    }
}
