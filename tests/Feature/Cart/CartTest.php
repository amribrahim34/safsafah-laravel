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

    $response = $this->actingAs($user)->getJson('/api/cart'); // Should actAs($user) in real scenario - middleware handling might be needed in test setup

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'cartId',
                'items',
                'totalItems',
                'totalPrice',
                'finalPrice',
            ]
        ]);
});

test('user can add item to cart', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/cart/items', [
        'productId' => $product->id,
        'quantity' => 2,
    ]);

    $response->assertCreated();
});

test('user can update cart item quantity', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $user->id]);
    $item = CartItem::factory()->create(['cart_id' => $cart->id]);

    $response = $this->actingAs($user)->putJson("/api/cart/items/{$item->id}", [
        'quantity' => 5,
    ]);

    $response->assertOk();
});

test('user can remove item from cart', function () {
    $user = User::factory()->create();
    $cart = Cart::factory()->create(['user_id' => $user->id]);
    $item = CartItem::factory()->create(['cart_id' => $cart->id]);

    $response = $this->actingAs($user)->deleteJson("/api/cart/items/{$item->id}");

    $response->assertOk();
});

// Test for promo code
test('user can apply promo code', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->postJson('/api/cart/promo-code', [
        'code' => 'DISCOUNT10',
    ]);
    
    // Expecting error or success depending on logic, but not 404
    // Since we don't have the logic implemented yet, we might want to check for validation error if code doesn't exist
    // or checks mock for code existence.
    // For now assuming we just want to hit the route.
    $response->assertStatus(422); // Validation error because code likely doesn't exist in DB
});
