<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Cart\AddToCartRequest;
use App\Http\Requests\Website\Cart\ApplyPromoCodeRequest;
use App\Http\Requests\Website\Cart\UpdateCartItemRequest;
use App\Http\Resources\Website\CartResource;
use App\Services\Website\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart($request->user());
        return new CartResource($cart);
    }

    public function store(AddToCartRequest $request)
    {
        $cart = $this->cartService->addItem($request->user(), $request->validated());
        return new CartResource($cart);
    }

    public function update(UpdateCartItemRequest $request, $cartItem)
    {
        // Note: Route model binding for $cartItem might need adjustement if we want to ensure it belongs to user's cart
        // But for simplicity, we pass ID and service checks ownership
        $cart = $this->cartService->updateItem($request->user(), $cartItem, $request->validated());
        return new CartResource($cart);
    }

    public function destroy(Request $request, $cartItem)
    {
        $cart = $this->cartService->removeItem($request->user(), $cartItem);
        return new CartResource($cart);
    }

    public function applyPromoCode(ApplyPromoCodeRequest $request)
    {
        $cart = $this->cartService->applyPromo($request->user(), $request->validated()['code']);
        return new CartResource($cart);
    }
}
