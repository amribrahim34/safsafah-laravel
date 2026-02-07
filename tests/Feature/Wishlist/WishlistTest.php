<?php

use App\Models\Product;
use App\Models\User;
use App\Models\WishList;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can add product to wishlist', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = postJson("/api/wishlist/{$product->id}");

    $response->assertStatus(404);
});

test('user can remove product from wishlist', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();
    WishList::factory()->create(['user_id' => $user->id, 'product_id' => $product->id]);

    $response = deleteJson("/api/wishlist/{$product->id}");

    $response->assertStatus(404);
});
