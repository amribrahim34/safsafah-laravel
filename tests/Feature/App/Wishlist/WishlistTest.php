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

    $response = $this->actingAs($user)->postJson("/api/app/wishlist/{$product->id}");
    $response->assertStatus(201);
});

test('user can remove product from wishlist', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();
    WishList::factory()->create(['user_id' => $user->id, 'product_id' => $product->id]);

    $response = $this->actingAs($user)->deleteJson("/api/app/wishlist/{$product->id}");
    $response->assertOk();
});
