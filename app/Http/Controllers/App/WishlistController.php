<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\ProductResource;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\Website\WishlistService;

class WishlistController extends Controller
{
    protected $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    public function index(Request $request)
    {
        $products = $this->wishlistService->getWishlist();
        return ProductResource::collection($products);
    }

    public function store(Request $request, $product)
    {
        // $product comes from URL parameter. 
        // If route binding is active, it might be a Product model. 
        // If not, it's an ID. Service handles ID.
        // Let's assume ID for now to match service text, or model binding if auto.
        // If Model binding, $product is Product model.
        // Service expects ID.
        
        $productId = $product instanceof Product ? $product->id : $product;
        
        $this->wishlistService->addProduct( $productId);
        return response()->json(['message' => 'Product added to wishlist'], 201);
    }

    public function destroy(Request $request, $product)
    {
        $productId = $product instanceof Product ? $product->id : $product;
        $this->wishlistService->removeProduct($productId);
        return response()->json(['message' => 'Product removed from wishlist']);
    }
}
