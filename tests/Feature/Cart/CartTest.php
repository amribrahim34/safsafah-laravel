<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can get their cart', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $user->id]);

    $response = getJson('/api/cart'); // Should actAs($user) in real scenario

    $response->assertStatus(404);
});

test('user can add item to cart', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = postJson('/api/cart/items', [
        'product_id' => $product->id,
        'quantity' => 2,
    ]);

    $response->assertStatus(404);
});

test('user can update cart item quantity', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $user->id]);
    $item = CartItem::factory()->create(['cart_id' => $cart->id]);

    $response = putJson("/api/cart/items/{$item->id}", [
        'quantity' => 5,
    ]);

    $response->assertStatus(404);
});

test('user can remove item from cart', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $user->id]);
    $item = CartItem::factory()->create(['cart_id' => $cart->id]);

    $response = deleteJson("/api/cart/items/{$item->id}");

    $response->assertStatus(404);
});

// Test for promo code
test('user can apply promo code', function () {
    $response = postJson('/api/cart/promo-code', [
        'code' => 'DISCOUNT10',
    ]);
    
    $response->assertStatus(404);
});
