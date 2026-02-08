<?php

use App\Models\Product;
use function Pest\Laravel\getJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can fetch single product', function () {
    $product = Product::factory()->create();

    $response = getJson("/api/products/{$product->id}");

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'id',
                'nameEn',
                'price',
                'image',
                'descriptionEn',
            ]
        ]);
});

test('fetch non-existent product returns 404', function () {
    $response = getJson('/api/products/999');

    $response->assertStatus(404);
});
